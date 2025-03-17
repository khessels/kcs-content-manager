<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('pages_id')->index()->nullable( true);
            $table->foreign('pages_id')
                ->references('id')
                ->on('pages');

            $table->enum('status', ['ACTIVE', 'INACTIVE'])->default('ACTIVE')->nullable( false);
            $table->string( 'template')->nullable(true);
            $table->string( 'name')->nullable(true);
            $table->json( 'properties')->nullable(true);
            $table->string( 'roles')->nullable(true)->default('public');
            $table->dateTime('publish_at')->nullable(true);
            $table->dateTime('expire_at')->nullable(true);
            $table->dateTime('last_seen_at')->nullable(true);

            $table->timestamps();
        });

        Schema::create('blog_articles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('blogs_id')->index()->nullable( true);
            $table->foreign('blogs_id')
                ->references('id')
                ->on('blogs');

            $table->enum('status', ['ACTIVE', 'INACTIVE'])->default('ACTIVE')->nullable( false);
            $table->string( 'content')->nullable(true);
            $table->json( 'properties')->nullable(true);
            $table->string( 'roles')->nullable(true)->default('public');
            $table->unsignedInteger('sort_order')->nullable(true);
            $table->dateTime('publish_at')->nullable(true);
            $table->dateTime('expire_at')->nullable(true);
            $table->dateTime('last_seen_at')->nullable(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
