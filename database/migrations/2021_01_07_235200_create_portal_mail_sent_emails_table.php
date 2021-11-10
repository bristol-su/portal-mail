<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePortalMailSentEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portal_mail_sent_emails', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('subject')->nullable();
            $table->string('content')->nullable();
            $table->text('to')->nullable();
            $table->unsignedInteger('from_id')->nullable();
            $table->text('cc')->nullable();
            $table->text('bcc')->nullable();
            $table->boolean('is_sent')->default(false);
            $table->boolean('is_error')->default(false);
            $table->text('error_message')->nullable();
            $table->integer('priority')->nullable();
            $table->string('reply_to')->nullable();
            $table->uuid('uuid')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->text('sent_via')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->unsignedInteger('resend_id')->nullable();
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
        Schema::dropIfExists('portal_mail_sent_emails');
    }
}
