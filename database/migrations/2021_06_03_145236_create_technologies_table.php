<?php

use App\Models\Enums\TechnologyType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTechnologiesTable extends Migration
{
    public function up(): void
    {
        Schema::create('technologies', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('type');
            $table->string('website_url');
            $table->string('image_url');
            $table->text('description');
            $table->json('recommended_by');

            $table->timestamps();
        });
    }
}
