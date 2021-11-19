<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFailedAtToSentMailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('portal_mail_sent_emails', function (Blueprint $table) {
            $table->timestamp('failed_at')->nullable()->after('sent_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('portal_mail_sent_emails', function (Blueprint $table) {
            $table->dropColumn('failed_at');
        });
    }
}
