<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldToProductoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('productouts', function (Blueprint $table) {
            $table->string('tracking_number')->unique();
            $table->unsignedBigInteger('employee_id');
            $table->string('vehicle');
            $table->date('date_product_out');
            $table->string('status')->default('pending');
            $table->string('is_active')->default('active');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('productouts', function (Blueprint $table) {
            $table->dropColumn('tracking_number');
            $table->dropColumn('employee_id');
            $table->dropColumn('vehicle');
            $table->dropColumn('date_product_out');
            $table->dropColumn('status');
            $table->dropColumn('is_active');
        });
    }
}
