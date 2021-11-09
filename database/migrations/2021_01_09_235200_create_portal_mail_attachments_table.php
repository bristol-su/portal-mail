<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePortalMailAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portal_mail_attachments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('filename');
            $table->string('mime');
            $table->string('path');
            $table->integer('size');
            $table->unsignedBigInteger('sent_mail_id')->nullable();
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
        Schema::dropIfExists('portal_mail_attachments');
    }
}
