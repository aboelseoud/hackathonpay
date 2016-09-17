<?php
/**
 * Created by PhpStorm.
 * User: habo
 * Date: 9/17/16
 * Time: 2:38 AM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $table = 'cards';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}