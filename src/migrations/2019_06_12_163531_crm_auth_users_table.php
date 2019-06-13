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
            foreach ($extra_fields['boolean'] as $field) {
                $table->longText($field)->nullable();
            }
            foreach ($extra_fields['string'] as $field) {
                $table->longText($field)->nullable();
            }
            foreach ($extra_fields['longText'] as $field) {
                $table->longText($field)->nullable();
            }
            foreach ($extra_fields['integer'] as $field) {
                $table->integer($field)->nullable();
            }
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('crm_users');
    }
}
