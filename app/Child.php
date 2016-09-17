<?php
/**
 * Created by PhpStorm.
 * User: habo
 * Date: 9/17/16
 * Time: 2:38 AM
 */

namespace App;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

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

    public function boughtProducts()
    {
        return $this->belongsToMany('App\Product', 'transactions')->withTimestamps();
    }

    public function blacklist()
    {
        return $this->belongsToMany('App\Product', 'blacklist')->withTimestamps();
    }

    public function allowedProducts()
    {
        return Product::all()->except($this->blacklist()->pluck('product_id')->all());
    }

    public function products()
    {
        return DB::table('products')->select(DB::raw('*, (select count(*) from blacklist where product_id = products.id and child_id = ' . $this->id . ') as blacklisted'))->get();
    }

    public function getCreditAttribute()
    {
        return $this->limit - $this->boughtProducts()->sum('price');
    }

    public function getCreditUsedThisMonthAttribute()
    {
        return $this->boughtProducts()->where('transactions.created_at', '>=', Carbon::now()->startOfMonth())->sum('price');
    }

    public function getHistoryAttribute()
    {
        return $this->transactions()->join('products', 'products.id', '=', 'transactions.product_id')->get();
    }

    public static function verify(Request $request)
    {
        $destinationPath = 'uploads/img/verifications';
        $original_file_name = $request->file('image')->getClientOriginalName();
        $new_file_name = str_random(30) . $original_file_name;
        $save_proccess = $request->file('image')->move($destinationPath, $new_file_name);
        if ($save_proccess) {
            $image_path = $destinationPath . '/' . $new_file_name;
            $full_url = env('APP_URL') . '/' . $image_path;

            $url = 'https://api.projectoxford.ai/face/v1.0/detect';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json', 'Ocp-Apim-Subscription-Key: ' . env('FACE_API_KEY')));
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['url' => $full_url]));

            try {
                $response = curl_exec($ch);
                dd($response);
            } catch (HttpException $ex) {
                echo $ex;
            }

        }
    }

}