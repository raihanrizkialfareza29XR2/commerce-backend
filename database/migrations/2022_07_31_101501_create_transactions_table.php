<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('users_id');
            $table->text('address');
            $table->text('zipcode');
            $table->string('firstname');
            $table->string('confirm_image')->nullable();
            $table->string('lastname');
            $table->string('phone');
            $table->string('courier');
            $table->text('tracking_no')->nullable();
            $table->bigInteger('total_price')->default(0);
            $table->float('shipping_price')->default(0);
            $table->string('status')->default('UNPAID');
            $table->string('payment_id')->nullable();
            $table->string('payment_method')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('transactions');
    }
};
