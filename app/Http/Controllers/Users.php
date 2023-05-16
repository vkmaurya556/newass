<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Business as BusinessModel;

class Users extends Controller
{
    //
    function login(Request $request)
    {
        $user = User::where("password", $request->password)
            ->where("email", $request->username)
            ->where("type", $request->type)
            ->get();
        if (count($user)) {
            $token = uniqid();
            DB::table('personal_access_tokens')->insert(
                array(
                    'tokenable_id' => $user[0]['id'],
                    'token' => $token
                )
            );
            if ($request->type == 1) {
                session(['adminuser' => $request->username]);
                session(['token' => $token]);
                return redirect("business");
            } else {
                return [
                    "message" => "Login Successfully",
                    "success" => true,
                    "token" => $token,
                    "name" => $user[0]['name'],
                ];
            }
            // $request->session()->forget('adminuser');
        } else {
            if ($request->type == 1) {
                return redirect()->back();
            } else {
                return [
                    "message" => "Invalid Credintial Request",
                    "success" => false
                ];
            }
        }
    }

    function signup(Request $request)
    {
        $response = ["message" => "Something went wrong", "success" => false];
        $user = new User();
        $user->type = 2;
        $user->name = $request->name;
        $user->email = $request->username;
        $user->password = $request->password;

        $res = $user->save();


        if ($res) {
            $token = uniqid();
            DB::table('personal_access_tokens')->insert(
                array(
                    'tokenable_id' => $user->toArray()['id'],
                    'token' => $token
                )
            );


            $response['token'] = $token;
            $response['name'] =  $request->name;
            $response['success'] = true;
            $response['message'] = "Registration Successful.";
        }
        return $response;
    }
    function rating(Request $request)
    {
        $response = ["message" => "Something went wrong", "success" => false];
        // validate token

        $token_info = DB::table("personal_access_tokens")->where("token", $request->login_token)->get();

        if (count($token_info)) {
            $user_id = $token_info[0]->tokenable_id;
            $rating = new Rating();

            $rating->business_id = $request->business_id;
            $rating->rating = $request->rating;
            $rating->comment = $request->comment;
            $rating->user_id = $user_id;
            $rating->save();


            BusinessModel::where('id', $request->business_id)->increment('total_rated_users', 1);
            BusinessModel::where('id', $request->business_id)->increment('total_rating', $request->rating);


            $response['message'] = "Thanks For give Rating.";
            $response['success'] = true;
        } else {
            $response['message'] = "Invalid Token";
        }

        return $response;
    }
}
