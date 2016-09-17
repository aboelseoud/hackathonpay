<?php
/**
 * Created by PhpStorm.
 * User: habo
 * Date: 9/17/16
 * Time: 3:18 AM
 */

namespace App\Http\Controllers;

use App\User;
use App\Child;
use App\Card;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function getChildren($id)
    {
        return User::findOrFail($id)->children;
    }

    public function addChild($id, Request $request)
    {
        $user = User::find($id);
        if ($user) {
            $child = new Child;
            $child->fill($request->toArray());

            if ($request->hasFile('image')) {
                $destinationPath = 'uploads/img/children';
                $original_file_name = $request->file('image')->getClientOriginalName();
                $new_file_name = str_random(30) . $original_file_name;
                $save_proccess = $request->file('image')->move($destinationPath, $new_file_name);
                if ($save_proccess) {
                    if (file_exists($child->image_path)) {
                        if ($child->image_name != 'default.jpg') {
                            unlink($child->image_path);
                        }
                    }
                    $child->image_name = $original_file_name;
                    $child->image_path = $destinationPath . '/' . $new_file_name;
                }
            }

            $child->parent()->associate($user);
            if ($child->save()) {
                return ['status' => 1];
            }
        }
        return ['status' => 0];
    }

    public function getCards($id)
    {
        return User::findOrFail($id)->cards;
    }

    public function addCard($id, Request $request)
    {
        $user = User::find($id);
        if ($user) {
            $card = new Card;
            $card->fill($request->toArray());
            $card->user()->associate($user);
            if ($card->save()) {
                return ['status' => 1];
            }
        }
        return ['status' => 0];
    }
}