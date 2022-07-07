<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockMigrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_entries', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('store_id');
            $table->timestamp('entry_date')->nullable();
            $table->string('adjustment_no')->nullable();
            $table->unsignedSmallInteger('created_by')->nullable();
            $table->unsignedSmallInteger('approved_by')->nullable();
            $table->text('remarks')->nullable();
            $table->unsignedFloat('gross_total')->nullable();
            $table->unsignedFloat('total_discount')->nullable();
            $table->unsignedFloat('flat_discount')->nullable();
            $table->unsignedFloat('taxable_amount')->nullable();
            $table->unsignedFloat('total_tax')->nullable();
            $table->unsignedFloat('net_amount')->nullable();
            $table->unsignedInteger('status_id')->nullable();

            $table->timestamps();
            $table->foreign('store_id')->references('id')->on('mst_stores')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('status_id')->references('id')->on('mst_sup_status')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('approved_by')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
        });
        Schema::create('stock_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('stock_id')->nullable();
            $table->unsignedInteger('item_id')->nullable();
            $table->unsignedBigInteger('add_qty')->nullable();
            $table->unsignedBigInteger('free_qty')->nullable();
            $table->unsignedBigInteger('total_qty')->nullable();
            $table->timestamp('expiry_date')->nullable();
            $table->unsignedFloat('unit_cost_price')->nullable();
            $table->unsignedFloat('unit_sales_price')->nullable();
            $table->unsignedFloat('discount')->nullable();
            $table->unsignedInteger('tax_vat')->nullable();
            $table->unsignedFloat('amount')->nullable();
            
            $table->timestamps();
            $table->foreign('item_id')->references('id')->on('mst_items')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('stock_id')->references('id')->on('stock_entries')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_entries');
        Schema::dropIfExists('stock_items');
    }
}
