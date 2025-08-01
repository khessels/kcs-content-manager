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
        Schema::create('content', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('parent_id')->nullable( true);
            $table->foreign('parent_id')->references('id')->on('content');

            $table->string( 'app')->nullable(false);
            $table->unsignedBigInteger('user_id')->index()->nullable( true);
            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->enum('status', ['ACTIVE', 'INACTIVE'])->default('ACTIVE')->nullable( false);
            $table->string( 'page')->nullable(true);
            $table->string( 'language')->nullable(true);
            $table->string( 'key')->nullable(false);
            $table->text( 'value')->nullable(true);
            $table->text( 'default')->nullable(true);
//            $table->string( 'alt')->nullable(true);
//            $table->string( 'title')->nullable(true);
            $table->json( 'data')->nullable(true);
            $table->string( 'mimetype')->nullable(false)->default('text/plain');
            $table->enum( 'env', ['local','production'])->nullable(false)->default('local');
            $table->string( 'env_source')->nullable(false)->default('unknown');
            $table->dateTime('publish_at')->nullable(true);
            $table->dateTime('expire_at')->nullable(true);
            $table->dateTime('last_seen_at')->nullable(true);

            $table->timestamps();
        });
        Schema::create('mimetypes', function (Blueprint $table) {
            $table->id();
            $table->string( 'mimetype')->nullable(false);
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
