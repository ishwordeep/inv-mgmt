<?php

namespace Database\Seeders;


use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now()->toDateTimeString();
        $this->time = $now;
        $this->organization();
        $this->users();
        $this->units();
        $this->category();
        $this->subcategory();
        $this->supplier();
        $this->store();
        $this->brand();
        $this->item();
        $this->po_sequence();
        $this->stock_adjustment_no();
        $this->invoice_sequence();
    }

    private function organization()
    {

        DB::table('mst_organizations')->insert([
            array('id' => 1, 'code' => '1','name_en'=>'Deep Organization','name_lc'=>'Deep Organization', 'country_id' => 1, 'province_id'=>1,'district_id'=>1,'address'=>"Damak",'email'=>'deep@gmail.com','phone'=>'1234567890','created_at' => $this->time,'is_active'=>true),
        ]);
        DB::statement("SELECT SETVAL('mst_organizations_id_seq',100)");
    }

    private function users(){
        DB::table('users')->insert([
            array('id' => 1, 'code'=>'sys','name' => 'System Admin', 'email' => 'super@gmail.com','user_level'=>1,'password' => \Hash::make('123456')),
            array('id' => 2, 'code'=>'1','name' => 'Deep Admin', 'email' => 'deep@gmail.com','user_level'=>2,'password' => \Hash::make('123456')),
            array('id' => 3, 'code'=>'2','name' => 'A Store', 'email' => 'a@gmail.com','user_level'=>3,'password' => \Hash::make('123456')),
            array('id' => 4, 'code'=>'3','name' => 'B Store', 'email' => 'b@gmail.com','user_level'=>3,'password' => \Hash::make('123456')),
            array('id' => 5, 'code'=>'4','name' => 'C Store', 'email' => 'c@gmail.com','user_level'=>3,'password' => \Hash::make('123456')),
        ]);
        DB::statement("SELECT SETVAL('users_id_seq',100)");

    }
    
    private function units(){
        DB::table('mst_units')->insert([
            array('id' => 1, 'code_text'=>'kg','name_en' => 'KG','name_lc' => 'KG'),
            array('id' => 2, 'code_text'=>'lt','name_en' => 'Litre','name_lc' => 'Litre'),
        ]);
        DB::statement("SELECT SETVAL('mst_units_id_seq',100)");
    }

    private function category(){
        DB::table('mst_categories')->insert([
            array('id' => 1, 'code'=>'1','name_en' => 'Veg','name_lc' => 'Veg'),
            array('id' => 2, 'code'=>'2','name_en' => 'Non Veg','name_lc' => 'Non Veg'),
        ]);
        DB::statement("SELECT SETVAL('mst_categories_id_seq',100)");
    }

    private function subcategory(){
        DB::table('mst_subcategories')->insert([
            array('id' => 1, 'code'=>'1','category_id'=>'1','name_en' => 'Tomato','name_lc' => 'Tomato'),
            array('id' => 2, 'code'=>'2','category_id'=>'1','name_en' => 'Potato','name_lc' => 'Potato'),
       
            array('id' => 3, 'code'=>'3','category_id'=>'2','name_en' => 'Meat','name_lc' => 'Meat'),
            array('id' => 4, 'code'=>'4','category_id'=>'2','name_en' => 'Fish','name_lc' => 'Fish'),
        ]);
        DB::statement("SELECT SETVAL('mst_subcategories_id_seq',100)");
    }

    private function supplier(){
        DB::table('mst_suppliers')->insert([
            array('id' => 1, 'code'=>'1','name_en' => 'Government Ltd','name_lc' => 'Government Ltd'),
            array('id' => 2, 'code'=>'2','name_en' => 'Hello Ltd','name_lc' => 'hello Ltd'),
           
        ]);
        DB::statement("SELECT SETVAL('mst_suppliers_id_seq',100)");
    }

    private function store(){
        DB::table('mst_stores')->insert([
            array('id' => 1, 'code'=>'1','name_en' => 'A-Store','name_lc' => 'A-Store'),
            array('id' => 2, 'code'=>'2','name_en' => 'B-Store','name_lc' => 'B-Store'),
            array('id' => 3, 'code'=>'3','name_en' => 'C-Store','name_lc' => 'C-Store'),
        
        ]);
        DB::statement("SELECT SETVAL('mst_stores_id_seq',100)");
    }

    private function brand(){
        DB::table('mst_brands')->insert([
            array('id' => 1, 'code'=>'1','name_en' => 'Brand1','name_lc' => 'Brand1'),
            array('id' => 2, 'code'=>'2','name_en' => 'Brand2','name_lc' => 'Brand2'),
            array('id' => 3, 'code'=>'3','name_en' => 'Brand3','name_lc' => 'Brand3'),
        
        ]);
        DB::statement("SELECT SETVAL('mst_brands_id_seq',100)");
    }
    
    private function item(){
        DB::table('mst_items')->insert([
            array('id' => 1, 'code'=>'1','category_id'=>1,'subcategory_id'=>1,'supplier_id'=>1,'name_en' => 'Item1','name_lc' => 'Item1','brand_id'=>1,'unit_id'=>1,'tax_vat'=>13,'discount_mode_id'=>1),
            array('id' => 2, 'code'=>'2','category_id'=>1,'subcategory_id'=>1,'supplier_id'=>1,'name_en' => 'Item2','name_lc' => 'Item2','brand_id'=>1,'unit_id'=>1,'tax_vat'=>13,'discount_mode_id'=>1),
            array('id' => 3, 'code'=>'3','category_id'=>1,'subcategory_id'=>1,'supplier_id'=>1,'name_en' => 'Item3','name_lc' => 'Item3','brand_id'=>1,'unit_id'=>1,'tax_vat'=>13,'discount_mode_id'=>1),
        ]);
        DB::statement("SELECT SETVAL('mst_items_id_seq',100)");
    }

    private function po_sequence(){
        DB::table('mst_po_sequences')->insert([
            array('id' => 1, 'code'=>'1','name' => 'Purchase Order','sequence_code' =>'PO'),
        ]);
        DB::statement("SELECT SETVAL('mst_items_id_seq',100)");
    }

    private function stock_adjustment_no(){
        DB::table('mst_stock_adjustment_no')->insert([
            array('id' => 1, 'code'=>'1','name' => 'Stock Adjustment','sequence_code' =>'SA'),
        ]);
        DB::statement("SELECT SETVAL('mst_items_id_seq',100)");
    }

    private function invoice_sequence(){
        DB::table('mst_invoice_sequences')->insert([
            array('id' => 1, 'code'=>'1','name' => 'InvoiceSequence','sequence_code' =>'IS'),
        ]);
        DB::statement("SELECT SETVAL('mst_items_id_seq',100)");
    }
}
