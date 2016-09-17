<?php
/**
 * Created by PhpStorm.
 * User: habo
 * Date: 9/17/16
 * Time: 2:38 AM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blacklist extends Model
{
    protected $table = 'blacklist';
    protected $guarded = [];
    protected $timestamps = true;

    public function child()
    {
        return $this->belongsTo('App\Child');
    }

    public function product()
    {
        return $this->belongsTo('App\product');
    }

}