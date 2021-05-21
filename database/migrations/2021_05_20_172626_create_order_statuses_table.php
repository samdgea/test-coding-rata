<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderStatusesTable extends Migration
{
    public function up()
    {
        Schema::create('order_status', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('order_id');
            $table->enum('order_status', [ 'Design', 'Confirmed', 'Printing','Ready', 'Sent', 'Complete'])->default('Design');
            $table->text('status_remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_status');
    }
}
