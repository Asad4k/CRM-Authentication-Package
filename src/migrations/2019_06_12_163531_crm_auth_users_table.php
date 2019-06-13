<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrmAuthUsersTable extends Migration
{
    public function up()
    {
        Schema::create('crm_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id')->nullable();
            $table->string('username')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('role')->nullable();
            $table->string('token', 25)->nullable();
            $extra_fields = config('crm_authentication.main.user_extra_fields');

            for ($i=0; $i < count($extra_fields['boolean']); $i++) {
                $table->boolean($extra_fields['boolean'][$i])->nullable();
            }
            for ($i=0; $i < count($extra_fields['string']); $i++) {
                $table->string($extra_fields['string'][$i])->nullable();
            }
            for ($i=0; $i < count($extra_fields['longText']); $i++) {
                $table->longText($extra_fields['longText'][$i])->nullable();
            }
            for ($i=0; $i < count($extra_fields['integer']); $i++) {
                $table->integer($extra_fields['integer'][$i])->nullable();
            }
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('crm_users');
    }
}
