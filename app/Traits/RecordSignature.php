<?php
namespace App\Traits;

trait RecordSignature
{
    protected static function boot()
    {
        parent::boot();

        static::updating(function ($model) {
            $model->updated_by = auth()->user()->ID;
        });

        static::creating(function ($model) {
            $model->created_by = auth()->user()->ID;
        });
        //etc

    }

}