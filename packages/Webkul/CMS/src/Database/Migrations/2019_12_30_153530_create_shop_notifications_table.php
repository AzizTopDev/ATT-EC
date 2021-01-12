<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('display_flag');
            $table->string('admin_name');
            $table->text('title');
            $table->text('content');
            $table->timestamps();
            $table->integer('deleted_flag')->default(0);
            $table->timestamp('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_notifications');
    }
}
