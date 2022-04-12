<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->integer('language_id');
            $table->integer('content_category_id');
            $table->string('content_title')->nullable();
            $table->string('content_coverletter')->nullable();
            $table->text('content')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('content_img1')->nullable();
            $table->string('content_img2')->nullable();
            $table->string('content_img3')->nullable();
            $table->string('content_img4')->nullable();
            $table->string('content_logo')->nullable();
            $table->enum('content_status',['active','deactive'])->default('active');
            $table->string('ip')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contents');
    }
}
