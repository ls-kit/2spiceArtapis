<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uploads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('category_id'); // 1 = music, 2 = comedy, 3 = talent
            // $table->unsignedBigInteger('category_id')->unsigned()->index();
            // $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->longtext('description')->nullable();
            $table->string('thumbnail_image')->nullable();
            $table->string('upload')->nullable();
            $table->date('release_date')->nullable();
            $table->string('region');
            $table->integer('type_id')->nullable();
            $table->string('upload_duration')->nullable();
            $table->bigInteger('view')->nullable()->default(0);
            $table->boolean('status')->default(1);
            $table->boolean('featured')->default(1);
            $table->boolean('sell')->nullable();
            $table->float('price')->nullable();
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
        Schema::dropIfExists('uploads');
    }
}
