<?php
/**
 * Created by PhpStorm.
 * User: habo
 * Date: 9/17/16
 * Time: 3:23 AM
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Card;

class CardsController extends Controller
{
    public function get($id)
    {
        return Card::findOrFail($id);
    }

    public function destroy($id)
    {
        if (Card::findOrFail($id)->delete())
            return ['status' => 1];
        return ['status' => 0];
    }

    public function update($id, Request $request)
    {
        $card = Card::findOrFail($id);
        $card->fill($request->toArray());
        if ($card->save())
            return ['status' => 1];
        return ['status' => 0];
    }
}