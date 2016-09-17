<?php
/**
 * Created by PhpStorm.
 * User: habo
 * Date: 9/17/16
 * Time: 3:23 AM
 */

namespace App\Http\Controllers;

use App\Blacklist;
use App\Child;
use App\Product;
use Illuminate\Http\Request;

class ChildrenController extends Controller
{
    public function get($id)
    {
        return Child::findOrFail($id);
    }

    public function destroy($id)
    {
        if (Child::findOrFail($id)->delete())
            return ['status' => 1];
        return ['status' => 0];
    }

    public function update($id, Request $request)
    {
        $child = Child::findOrFail($id);
        $child->fill($request->toArray());
        if ($child->save())
            return ['status' => 1];
        return ['status' => 0];
    }

    public function allowedProducts($id)
    {
        return Child::findOrFail($id)->allowedProducts();
    }

    public function addToBlacklist($cid, $pid)
    {
        $child = Child::findOrFail($cid);
        $product = Product::findOrFail($pid);
        $child->blacklist()->attach($product);
        return ['status' => 1];
    }

    public function removeFromBlacklist($cid, $pid)
    {
        $child = Child::findOrFail($cid);
        $product = Product::findOrFail($pid);
        $child->blacklist()->detach($product);
        return ['status' => 1];
    }

    public function buy($cid, $pid)
    {
        $child = Child::findOrFail($cid);
        $product = Product::findOrFail($pid);
        $child->boughtProducts()->attach($product);
        return ['status' => 1];
    }

    public function history($id)
    {
        return Child::findOrFail($id)->history;
    }

    public function credit($id) {
        return Child::findOrFail($id)->credit;
    }

    public function creditUsedThisMonth($id) {
        return Child::findOrFail($id)->credit_used_this_month;
    }
}