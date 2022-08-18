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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->string('email')->unique();
            $table->integer('phone_No')->unique();
            $table->text('address');
            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->date('booking_date');
            $table->boolean('booking_type')->default(false); // false for hour, true for day
            $table->string('status')->default('pending');
            $table->unsignedBigInteger('guest_id'); //foreign key
            $table->foreign('guest_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('bookings');
    }
};
