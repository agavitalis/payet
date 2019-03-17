<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('username');
            $table->string('email');
            $table->string('phone');
        
            $table->string('transaction_id');
            $table->string('amount');
            $table->string('transaction_by');
            $table->string('transaction_type');
            $table->string('transaction_benefit');
            $table->string('benefit_type');
            $table->string('transaction_mode');
            $table->string('transaction_details');
            $table->string('transaction_status');
          
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
}
