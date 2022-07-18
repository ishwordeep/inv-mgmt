<?php

namespace App\Base;

use App\Models\MstBrand;
use App\Models\MstCategory;
use App\Models\MstCountry;
use App\Models\MstDiscountMode;
use App\Models\MstDistrict;
use App\Models\MstItem;
use App\Models\MstProvince;
use App\Models\MstStore;
use App\Models\MstSubcategory;
use App\Models\MstSupplier;
use App\Models\MstSupStatus;
use App\Models\MstUnit;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


class BaseModel extends Model
{
    use CrudTrait;

    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = ['id', 'created_at', 'created_by'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $columns = Schema::getColumnListing($model->getTable());

            if (in_array('code', $columns)) {
                $code = self::generateCode($model);
                $model->code = $code;
            }

            if (in_array('created_by', $columns)) {
                $model->created_by =  !is_null(backpack_user()) ? backpack_user()->id : 1;
            }
        });

        static::updating(function ($model) {
            $columns = Schema::getColumnListing($model->getTable());
            if (in_array('updated_by', $columns)) {
                $model->created_by =  !is_null(backpack_user()) ? backpack_user()->id : 1;
            }
        });
    }

    public static function generateCode($model)
    {
        $table = $model->getTable();
        $qu = DB::table($table)
            ->selectRaw('COALESCE(max(code::NUMERIC),0)+1 as code')
            ->whereRaw("(code ~ '^([0-9]+[.]?[0-9]*|[.][0-9]+)$') = true");

        $rec = $qu->first();
        if (isset($rec)) {
            $code = $rec->code;
        }
        else {
            $code = 1;
        }
        return $code;
    }


    public function countryEntity(){
        return $this->belongsTo(MstCountry::class,'country_id','id');
    }
    public function provinceEntity(){
        return $this->belongsTo(MstProvince::class,'province_id','id');
    }

    public function districtEntity(){
        return $this->belongsTo(MstDistrict::class,'district_id','id');
    }
    public function categoryEntity(){
        return $this->belongsTo(MstCategory::class,'category_id','id');
    }
    public function subCategoryEntity(){
        return $this->belongsTo(MstSubcategory::class,'subcategory_id','id');
    }


    public function supplierEntity(){
        return $this->belongsTo(MstSupplier::class,'supplier_id','id');
    }
    public function storeEntity(){
        return $this->belongsTo(MstStore::class,'store_id','id');
    }
    public function brandEntity(){
        return $this->belongsTo(MstBrand::class,'brand_id','id');
    }
    public function unitEntity(){
        return $this->belongsTo(MstUnit::class,'unit_id','id');
    }
    public function itemEntity(){
        return $this->belongsTo(MstItem::class,'item_id','id');
    }
    public function statusEntity(){
        return $this->belongsTo(MstSupStatus::class,'status_id','id');
    }
    public function discountModeEntity(){
        return $this->belongsTo(MstDiscountMode::class,'discount_mode_id','id');
    }
    public function requestedStoreEntity(){
        return $this->belongsTo(MstStore::class,'requested_store_id','id');
    }

}
