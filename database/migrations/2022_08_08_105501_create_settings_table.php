<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
            $table->string("app_name")->nullable();
            $table->string("description")->nullable();
            $table->string("footer_text")->nullable();
            $table->string("logo")->nullable();
            $table->string("favicon")->nullable();
            $table->string("contact_mail")->nullable();
            $table->string("banner_image")->nullable();
            $table->string("banner_title")->nullable();
            $table->string("banner_description")->nullable();
            $table->timestamps();
        });

        DB::table('settings')->insert(
            array(
                'logo' => '/uploads/sitesetting/logo.png',
                'favicon' => '/uploads/sitesetting/favicon.png',
                'banner_image' => '/uploads/sitesetting/banner.jpg',
            )
        );
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
