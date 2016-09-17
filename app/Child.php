<?php
/**
 * Created by PhpStorm.
 * User: habo
 * Date: 9/17/16
 * Time: 2:38 AM
 */

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    protected $table = 'children';
    protected $guarded = [];

    public function parent()
    {
        return $this->belongsTo('App\User');
    }

    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }

    public function boughtProducts() {
        return $this->belongsToMany('App\Product', 'transactions')->withTimestamps();;
    }

    public function blacklist()
    {
        return $this->belongsToMany('App\Product', 'blacklist')->withTimestamps();;
    }

    public function allowedProducts() {
        return Product::all()->except($this->blacklist()->pluck('product_id')->all());
    }

    public function getCreditAttribute() {
        return $this->limit - $this->boughtProducts()->sum('price');
    }

    public function getCreditUsedThisMonthAttribute() {
        return $this->boughtProducts()->where('transactions.created_at', '>=', Carbon::now()->startOfMonth())->sum('price');
    }

}