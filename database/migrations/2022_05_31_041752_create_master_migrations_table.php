<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterMigrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_countries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('name_en')->unique();
            $table->string('name_lc')->unique()->nullable();

            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();
            $table->timestamps();
        });

        Schema::create('mst_provinces', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('name_en')->unique();
            $table->string('name_lc')->unique()->nullable();
            $table->unsignedInteger('country_id');

            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();
            $table->timestamps();

            $table->foreign('country_id')->references('id')->on('mst_countries')->cascadeOnDelete()->cascadeOnUpdate();
        });
        Schema::create('mst_districts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('name_en')->unique();
            $table->string('name_lc')->unique()->nullable();
            $table->unsignedInteger('province_id');

            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();
            $table->timestamps();

            $table->foreign('province_id')->references('id')->on('mst_provinces')->cascadeOnDelete()->cascadeOnUpdate();
        });

        Schema::create('mst_organizations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('name_en')->unique();
            $table->string('name_lc')->unique()->nullable();
            $table->unsignedInteger('country_id')->nullable();
            $table->unsignedInteger('province_id')->nullable();
            $table->unsignedInteger('district_id')->nullable();

            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('logo')->nullable();
            $table->string('description')->nullable();
            $table->boolean('is_active')->default(true);

            $table->unsignedSmallInteger('created_by')->nullable();
            $table->unsignedSmallInteger('updated_by')->nullable();
            $table->unsignedSmallInteger('deleted_by')->nullable();
            $table->timestamps();

            $table->foreign('country_id')->references('id')->on('mst_countries')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('province_id')->references('id')->on('mst_provinces')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('district_id')->references('id')->on('mst_districts')->cascadeOnDelete()->cascadeOnUpdate();
        });

        Schema::create('mst_units', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('name_en')->unique();
            $table->string('name_lc')->unique()->nullable();

            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();
            $table->timestamps();

        });

        Schema::create('mst_discount_modes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code',20)->unique();
            $table->string('name_en',100)->unique();
            $table->string('name_lc',100)->unique();

            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();
            $table->timestamps();
        });

        Schema::create('mst_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('name_en')->unique();
            $table->string('name_lc')->unique()->nullable();
            $table->string('description')->nullable();

            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();
            $table->timestamps();

        });

        Schema::create('mst_subcategories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('name_en')->unique();
            $table->string('name_lc')->unique()->nullable();
            $table->unsignedInteger('category_id')->nullable();

            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('mst_categories')->cascadeOnDelete()->cascadeOnUpdate();
        });

        Schema::create('mst_suppliers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('name_en')->unique();
            $table->string('name_lc')->unique()->nullable();

            $table->unsignedInteger('country_id');
            $table->unsignedInteger('province_id');
            $table->unsignedInteger('district_id');
            $table->string('address');
            $table->string('email');
            $table->string('contact_person');
            $table->string('phone')->unique();
            $table->text('description')->nullable();

            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();
            $table->timestamps();

            $table->foreign('country_id')->references('id')->on('mst_countries')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('province_id')->references('id')->on('mst_provinces')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('district_id')->references('id')->on('mst_districts')->cascadeOnDelete()->cascadeOnUpdate();
        });

        Schema::create('mst_genders', function (Blueprint $table) {

            $table->increments('id');
            $table->string('code')->unique();
            $table->string('name_en')->unique();
            $table->string('name_lc')->unique()->nullable();

            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();
            $table->timestamps();
        });

        Schema::create('mst_invoice_sequences', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('name')->unique();
            $table->string('sequence_code')->unique();

            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('created_by');
            $table->unsignedSmallInteger('updated_by')->nullable();
            $table->unsignedSmallInteger('deleted_by')->nullable();
            $table->timestamps();

        });

        Schema::create('mst_po_sequences', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('name')->unique();
            $table->string('sequence_code')->unique();

            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('created_by');
            $table->unsignedSmallInteger('updated_by')->nullable();
            $table->unsignedSmallInteger('deleted_by')->nullable();
            $table->timestamps();
        });
        Schema::create('mst_purchase_return_sequences', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('name')->unique();
            $table->string('sequence_code')->unique();

            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('created_by');
            $table->unsignedSmallInteger('updated_by')->nullable();
            $table->unsignedSmallInteger('deleted_by')->nullable();
            $table->timestamps();
        });
        Schema::create('mst_stores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('name_en')->unique();
            $table->string('name_lc')->unique()->nullable();
            $table->unsignedInteger('country_id')->nullable();
            $table->unsignedInteger('province_id')->nullable();
            $table->unsignedInteger('district_id')->nullable();

            $table->string('address');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('logo')->nullable();
            $table->string('description')->nullable();

            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('created_by');
            $table->unsignedSmallInteger('updated_by')->nullable();
            $table->unsignedSmallInteger('deleted_by')->nullable();
            $table->timestamps();

            $table->foreign('country_id')->references('id')->on('mst_countries')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('province_id')->references('id')->on('mst_provinces')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('district_id')->references('id')->on('mst_districts')->cascadeOnDelete()->cascadeOnUpdate();
        
        });

        Schema::create('mst_sup_status', function (Blueprint $table) {

            $table->increments('id');
            $table->string('code')->unique();
            $table->string('name_en')->unique();
            $table->string('name_lc')->unique()->nullable();
            $table->string('description')->nullable();

            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();
            $table->timestamps();
        });

        Schema::create('mst_payment_modes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('name_en')->unique();
            $table->string('name_lc')->unique()->nullable();

            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('created_by');
            $table->unsignedSmallInteger('updated_by')->nullable();
            $table->unsignedSmallInteger('deleted_by')->nullable();
            $table->timestamps();
        });

        Schema::create('mst_return_reasons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('name_en')->unique();
            $table->string('name_lc')->unique()->nullable();
            $table->string('description')->nullable();
            $table->boolean('is_active')->default(true);

            $table->unsignedSmallInteger('created_by');
            $table->unsignedSmallInteger('updated_by')->nullable();
            $table->unsignedSmallInteger('deleted_by')->nullable();
            $table->timestamps();
        });
        Schema::create('mst_stock_adjustment_no', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique()->nullable();
            $table->string('name')->unique()->unique()->nullable();
            $table->string('sequence_code')->unique()->unique()->nullable();

            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('created_by');
            $table->unsignedSmallInteger('updated_by')->nullable();
            $table->unsignedSmallInteger('deleted_by')->nullable();
            $table->timestamps();
        });

        Schema::create('mst_batch_no', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique()->nullable();
            $table->string('name')->unique()->nullable();
            $table->string('sequence_code')->unique()->nullable();

            $table->boolean('is_active')->default(true);
             $table->unsignedSmallInteger('created_by');
            $table->unsignedSmallInteger('updated_by')->nullable();
            $table->unsignedSmallInteger('deleted_by')->nullable();
            $table->timestamps();
        });
        Schema::create('mst_brands', function (Blueprint $table) {

            $table->increments('id');
            $table->string('code')->unique();
            $table->string('name_en')->unique();
            $table->string('name_lc')->unique()->nullable();
            $table->string('description')->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();
        });

        Schema::create('mst_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('name_en')->unique();
            $table->string('name_lc')->unique();
            $table->string('description')->nullable();
            $table->unsignedSmallInteger('category_id');
            $table->unsignedSmallInteger('subcategory_id');
            $table->unsignedSmallInteger('supplier_id');
            $table->unsignedSmallInteger('brand_id');
            $table->unsignedSmallInteger('unit_id');
            $table->string('stock_alert_minimum')->nullable();
            $table->string('tax_vat')->nullable();
            $table->unsignedSmallInteger('discount_mode_id')->nullable();
            $table->boolean('is_taxable')->default(false);
            $table->boolean('is_nonclaimable')->default(false);

            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('created_by');
            $table->unsignedSmallInteger('updated_by')->nullable();
            $table->unsignedSmallInteger('deleted_by')->nullable();
            $table->timestamps();


            $table->foreign('category_id')->references('id')->on('mst_categories')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('subcategory_id')->references('id')->on('mst_subcategories')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('supplier_id')->references('id')->on('mst_suppliers')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('unit_id')->references('id')->on('mst_units')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('discount_mode_id')->references('id')->on('mst_discount_modes')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('brand_id')->references('id')->on('mst_brands')->cascadeOnDelete()->cascadeOnUpdate();

        });
        


        

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mst_countries');
        Schema::dropIfExists('mst_provinces');
        Schema::dropIfExists('mst_districts');
        Schema::dropIfExists('mst_organizations');
        Schema::dropIfExists('mst_units');
        Schema::dropIfExists('mst_discount_modes');
        Schema::dropIfExists('mst_categories');
        Schema::dropIfExists('mst_subcategories');
        Schema::dropIfExists('mst_suppliers');
        Schema::dropIfExists('mst_genders');
        Schema::dropIfExists('mst_invoice_sequences');
        Schema::dropIfExists('mst_po_sequences');
        Schema::dropIfExists('mst_purchase_return_sequences');
        Schema::dropIfExists('mst_stores');
        Schema::dropIfExists('mst_sup_status');
        Schema::dropIfExists('mst_payment_modes');
        Schema::dropIfExists('mst_return_reasons');
        Schema::dropIfExists('mst_stock_adjustment_no');
        Schema::dropIfExists('mst_batch_no');
        Schema::dropIfExists('mst_brands');
        Schema::dropIfExists('mst_items');
    }
}
