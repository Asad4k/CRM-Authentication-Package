<?php

namespace AJG\CRM_Authentication\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;

use Session;

// use GuzzleHttp\Exception\GuzzleException;
// use GuzzleHttp\Client;

class User extends Model
{
    protected $table = 'crm_users';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'username',
        'first_name',
        'last_name',
        'email',
        'role',
        'token'
    ];

    public static function user() {
        $user_id = Session::get("user_id");
        $user = User::where('user_id', '=', $user_id)->first();
        return($user);
    }

    public function authenticate($username, $password) {
        $username = $this->secureString($username);
        $password = $this->secureString($password);
        $url = config('crm_authentication.main.crm_authentication_url');
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $username . ':' . $password);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        $output = curl_exec($ch);
        if($output === false || $output == "") {
            return 'false';
        }
        curl_close($ch);
        $data = json_decode($output, true);
        return $data;
    }

    private function secureString($str) {
        $secured = strip_tags(is_array($str) ? implode ($str) : $str);
        $secured = htmlspecialchars($secured);
        return $secured;
    }

    public function updateUser($authenticated) {
        if(!$authenticated['user']['deleted']) {
            $user = User::where('user_id', '=', $authenticated['user']['id'])->first();
            $token = $this->generateToken();
            if($user) {
                $user->user_id = $authenticated['user']['id'];
                $user->username = $authenticated['user']['userName'];
                $user->first_name = $authenticated['user']['firstName'];
                $user->last_name = $authenticated['user']['lastName'];
                $user->email = $authenticated['user']['emailAddress'];
                $user->role = $authenticated['user']['isAdmin'];
                $user->token = $token;
                $user->save();

                $sessionData = [
                    'user_id' => $authenticated['user']['id'],
                    'user_token' => $token
                ];
                session()->put('user_id', $authenticated['user']['id']);
                session()->put('user_token', $token);
                return $sessionData;
            } else {
                $this->newUser($authenticated, $token);
                $sessionData = [
                    'user_id' => $authenticated['user']['id'],
                    'user_token' => $token
                ];
                return $sessionData;
            }

        } else {
            $user = User::where('user_id', '=', $authenticated['user']['id'])->first();
            if($user) {
                $user->delete();
            }
            return 'false';
        }
    }

    public function newUser($authenticated, $token) {
        $user = new User();
        $user->user_id = $authenticated['user']['id'];
        $user->username = $authenticated['user']['userName'];
        $user->first_name = $authenticated['user']['firstName'];
        $user->last_name = $authenticated['user']['lastName'];
        $user->email = $authenticated['user']['emailAddress'];
        $user->role = $authenticated['user']['isAdmin'];
        $user->token = $token;
        $user->save();
    }

    private function generateToken () {
        $token = Str::random(25);
        return $token;
    }
}
