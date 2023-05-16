<?php

namespace App\Http\Controllers;

use App\Models\Business as BusinessModel;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Business extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function create(Request $request)
    {
        $response = ["message" => "Something went wrong", "success" => false];
        if ($request->id == 0) {
            $businessModel = new BusinessModel();
        } else {
            $businessModel = BusinessModel::find($request->id);
        }

        $file = $request->file('image');

        if ($file) {

            //Move Uploaded File
            $destinationPath = 'uploads';
            $file_name = strtotime(now()) . "." . $file->getClientOriginalExtension();
            $file->move($destinationPath, $file_name);
            $businessModel->image = ($destinationPath . "/" . $file_name);
            // dd($file);
        }
        $businessModel->name = $request->name;
        $businessModel->type = $request->type;
        $businessModel->address = $request->address;
        $res = $businessModel->save();

        if ($res) {
            $response['success'] = true;
            if ($request->id == 0) {
                $response['message'] = "Business Created successfully";
            } else
                $response['message'] = "Business Updated successfully";
        }
        return $response;
    }
    function list()
    {
        
        $response = ["message" => "Fetch Business", "success" => true, "data" => []];
        $response['data'] = BusinessModel::all();
        return $response;
    }
}
