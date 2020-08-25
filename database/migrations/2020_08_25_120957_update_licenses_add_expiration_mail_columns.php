<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateLicensesAddExpirationMailColumns extends Migration
{
    public function up()
    {
        Schema::table('licenses', function (Blueprint $table) {
            $table->timestamp('expiration_warning_mail_sent_at')->nullable();
            $table->timestamp('expiration_mail_sent_at')->nullable();
        });
    }
}
