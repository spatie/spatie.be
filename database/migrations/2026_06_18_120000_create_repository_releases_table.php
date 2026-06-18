<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('repository_releases', function (Blueprint $table) {
            $table->id();
            // repositories.id is int unsigned, so the foreign key column must match it (not bigint)
            $table->unsignedInteger('repository_id');
            $table->foreign('repository_id')->references('id')->on('repositories')->cascadeOnDelete();
            $table->string('tag_name');
            $table->string('name')->nullable();
            $table->longText('body')->nullable();
            $table->string('url')->nullable();
            $table->string('commit_sha')->nullable();
            $table->boolean('is_release')->default(false);
            $table->boolean('is_prerelease')->default(false);
            $table->dateTime('released_at')->nullable();
            $table->timestamps();

            $table->unique(['repository_id', 'tag_name']);
            $table->index('released_at');
        });
    }
};
