<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('blog_posts', function (Blueprint $table): void {
            $table->id();
            $table->uuid('source_id')->nullable()->unique();
            $table->string('source_hash', 64)->nullable();
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('summary_markdown')->nullable();
            $table->longText('markdown');
            $table->text('summary_html')->nullable();
            $table->longText('html');
            $table->json('author_data');
            $table->json('tags');
            $table->boolean('published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamp('first_published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['published', 'published_at']);
        });
    }
};
