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

            $table->boolean('itemWiseDiscount')->nullable();

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
        Schema::create('sales_items', function (Blueprint $table) {

            $table->increments('id');
            $table->unsignedSmallInteger('sales_id')->nullable();
            $table->unsignedSmallInteger('item_id')->nullable();
            $table->unsignedSmallInteger('unit_id')->nullable();
            $table->unsignedSmallInteger('add_qty')->nullable();
            $table->unsignedSmallInteger('free_qty')->nullable();
            $table->unsignedSmallInteger('total_qty')->nullable();
            $table->unsignedSmallInteger('unit_price')->nullable();
            $table->unsignedSmallInteger('discount_mode')->nullable();
            $table->unsignedSmallInteger('discount')->nullable();
            $table->float('tax_vat')->nullable();
            $table->float('item_total')->nullable();

            $table->unsignedInteger('created_by')->nullable();
            $table->timestamps();

            
            $table->foreign('unit_id')->references('id')->on('mst_units')->cascadeOnDelete()->cascadeOnDelete();
            $table->foreign('discount_mode')->references('id')->on('mst_discount_modes')->cascadeOnDelete()->cascadeOnDelete();
            $table->foreign('item_id')->references('id')->on('mst_items')->cascadeOnDelete()->cascadeOnDelete();
            $table->foreign('sales_id')->references('id')->on('sales')->cascadeOnDelete()->cascadeOnDelete();

                
            
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
