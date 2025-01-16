<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('bf24_questions', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('day');
            $table->text('question');
            $table->text('answer');
            $table->text('hint');
        });

        Schema::create('bf24_rewards', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('day');
            $table->string('type');
            $table->dateTime('available_at');
        });

        Schema::create('bf24_codes_pool', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('type');
        });

        Schema::create('bf24_redeemed_rewards', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->tinyInteger('day');
            $table->string('type');
            $table->string('code')->nullable();
            $table->boolean('entered_raffle')->default(false);

            $table->unsignedBigInteger('reward_id')->nullable()->index();
            $table->foreign('reward_id')->references('id')->on('bf24_rewards');

            $table->timestamps();

            $table->unique(['user_id', 'day']);
        });
    }
};
