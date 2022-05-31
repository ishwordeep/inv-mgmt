<?php

namespace App\Base;



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
}
