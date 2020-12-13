<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('شنساه فایل');
            $table->integer('user_id')->comment('شناسه کاربر اپلود کننده');
            $table->integer('mime_type_id')->comment('شناسه پسوند فایل');
            $table->string('name')->comment('نام فایل');
            $table->string('original_name')->comment('نام اصلی فایل قبل از اپلود');
            $table->string('ext')->comment('پسوند فایل');
            $table->string('file_path')->comment('ادرس فایل');
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
        Schema::dropIfExists('files');
    }
}
