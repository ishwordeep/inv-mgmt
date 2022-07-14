<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        Schema::create('purchase_orders', function (Blueprint $table) {

            $table->increments('id');
            $table->string('po_number')->nullable();
            $table->string('po_date')->nullable();
            $table->string('expected_delivery')->nullable();
            $table->string('approved_by')->nullable();
            $table->float('gross_amt')->nullable();
            $table->float('discount_amt')->nullable();
            $table->float('tax_amt')->nullable();
            $table->float('other_charges')->nullable();
            $table->float('net_amt')->nullable();
            $table->string('comments')->nullable();
            $table->unsignedBigInteger('store_id');
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->unsignedBigInteger('po_type_id');
            $table->unsignedBigInteger('requested_store_id')->nullable();
            $table->unsignedBigInteger('status_id');
            $table->unsignedInteger('created_by')->nullable();


            $table->timestamps();


            $table->foreign('created_by')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('store_id')->references('id')->on('mst_stores')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('supplier_id')->references('id')->on('mst_suppliers')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('po_type_id')->references('id')->on('purchase_order_types')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('requested_store_id')->references('id')->on('mst_stores')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('status_id')->references('id')->on('mst_sup_status')->onDelete('restrict')->onUpdate('cascade');
        });
        Schema::create('purchase_order_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('po_id');
            $table->integer('purchase_qty')->nullable();
            $table->integer('free_qty')->nullable();
            $table->integer('total_qty')->nullable();
            $table->unsignedBigInteger('discount_mode_id')->nullable();
            $table->float('discount')->nullable();
            $table->float('purchase_price')->nullable();
            $table->float('tax_vat')->nullable();
            $table->float('sales_price')->nullable();
            $table->float('item_amount')->nullable();
            $table->unsignedBigInteger('item_id')->nullable();
            $table->unsignedInteger('created_by')->nullable();



            $table->timestamps();
            $table->foreign('created_by')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('po_id')->references('id')->on('purchase_orders')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('discount_mode_id')->references('id')->on('mst_discount_modes')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('item_id')->references('id')->on('mst_items')->cascadeOnDelete()->cascadeOnUpdate();



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_orders');
    }
}
