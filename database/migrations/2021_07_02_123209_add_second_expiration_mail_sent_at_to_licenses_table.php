<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('licenses', function (Blueprint $table) {
            $table->dateTime('second_expiration_mail_sent_at')->after('expiration_mail_sent_at')->nullable();
        });
    }
};
