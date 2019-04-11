<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    /**
     * The primary key of the table
     * @var string
     */
    protected $primaryKey = "ID";

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'currencies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Code', 'Name', 'USD', 'PHP'
    ];

    public function updateRequired() {
        return Carbon::parse($this->updated_at)->addMonth(1)->lessThan(Carbon::now());
    }

    public static function getExchangeRate($currency) {
        $c = new Currency();
        $c = $c->where('Code','=', $currency)->firstOrFail();

        return $c->PHP;
    }
}
