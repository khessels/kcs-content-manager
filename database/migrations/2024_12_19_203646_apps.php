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
        Schema::create('apps', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->index()->nullable( true);
            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->string( 'name')->nullable(false);
            $table->enum('status', ['ACTIVE', 'INACTIVE'])->default('ACTIVE')->nullable( false);
            $table->json( 'properties')->nullable(true);
            $table->timestamps();
        });

        Schema::create('app_users', function (Blueprint $table) {
            $table->id();

            $table->string( 'name')->nullable(false);
            $table->unsignedBigInteger('user_id')->index()->nullable( true);
            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->enum('status', ['ACTIVE', 'INACTIVE'])->default('ACTIVE')->nullable( false);
            $table->json( 'properties')->nullable(true);
            $table->timestamps();
        });
        Schema::create('app_kv_store', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable( true);
            $table->foreign('parent_id')->references('id')->on('app_kv_store');

            $table->unsignedBigInteger('app_id')->index()->nullable( true);
            $table->foreign('app_id')
                ->references('id')
                ->on('apps');

            $table->string( 'topic')->nullable(false);
            $table->string( 'key')->nullable(false);
            $table->text( 'value')->nullable(true);
            $table->json( 'data')->nullable(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {


    }
};
