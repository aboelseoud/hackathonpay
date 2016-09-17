<?php
/**
 * Created by PhpStorm.
 * User: habo
 * Date: 9/17/16
 * Time: 3:01 AM
 */

namespace App\Http\Controllers;


use App\Product;

class ProductsController extends Controller
{
    public function index() {
        return Product::all();
    }
}