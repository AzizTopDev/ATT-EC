<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_emails', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type', 100)->unique();
            $table->string('type_label', 150);
            $table->string('sender_name', 100)->nullable();
            $table->string('sender_email', 150)->nullable();
            $table->string('subject', 100)->nullable();
            $table->longText('content')->nullable();
            $table->string('variables', 1500)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_emails');
    }
}