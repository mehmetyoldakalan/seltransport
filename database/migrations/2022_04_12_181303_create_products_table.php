<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->integer('user_id');
            $table->string('product_number')->nullable();
            $table->string('product_barcode')->nullable();
            $table->string('product_name')->nullable();
            $table->double('product_price')->nullable();
            $table->integer('product_count')->nullable();
            $table->string('product_category')->nullable();
            $table->text('product_notes')->nullable();
            $table->string('product_img0')->nullable();
            $table->string('product_img1')->nullable();
            $table->string('product_img2')->nullable();
            $table->string('product_color')->nullable();
            $table->enum('product_status',['active','deactive'])->default('active');
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
        Schema::dropIfExists('products');
    }
}
