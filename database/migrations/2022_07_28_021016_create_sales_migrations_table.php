<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesMigrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('store_id')->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('invoice_date')->nullable();//created date
            $table->unsignedSmallInteger('created_by')->nullable();
            $table->unsignedSmallInteger('approved_by')->nullable();
            $table->date('transaction_date')->nullable();//approved date
            $table->integer('bill_type')->nullable();//corporate OR Individual


            $table->string('company_name')->nullable();//for corporate only
            $table->string('pan_vat')->nullable();//for corporate only
            $table->string('full_name')->nullable();
            $table->string('address', 200)->nullable();
            $table->string('contact_number')->nullable();

            $table->integer('discount_mode_id')->nullable();
            $table->float('discount')->nullable();
            $table->unsignedFloat('flat_discount')->nullable();

            $table->unsignedFloat('gross_total')->nullable();
            $table->unsignedFloat('total_discount')->nullable();
            $table->unsignedFloat('taxable_amount')->nullable();
            $table->unsignedFloat('total_tax')->nullable();
            $table->unsignedFloat('net_amount')->nullable();

            $table->float('receipt_amt')->nullable();
            $table->float('due_amt')->nullable();

            $table->unsignedInteger('status_id')->nullable();
            $table->text('remarks')->nullable();


            $table->timestamps();
            $table->foreign('store_id')->references('id')->on('mst_stores')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('status_id')->references('id')->on('mst_sup_status')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('approved_by')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_migrations');
    }
}
