<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('facility_name')->nullable();
            $table->text('facility_slogan')->nullable();
            $table->string('title')->nullable();
            $table->string('site_url')->nullable();
            $table->text('address1')->nullable();
            $table->text('address2')->nullable();
            $table->string('instagram')->nullable();
            $table->string('twitter')->nullable();
            $table->string('facebook')->nullable();
            $table->string('google')->nullable();
            $table->string('number')->nullable();
            $table->string('number2')->nullable();
            $table->string('number3')->nullable();
            $table->string('top_logo')->nullable();
            $table->string('bottom_logo')->nullable();
            $table->text('map')->nullable();
            $table->text('map2')->nullable();
            $table->text('map3')->nullable();
            $table->text('google_analytic')->nullable();
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
        Schema::dropIfExists('settings');
    }
}
