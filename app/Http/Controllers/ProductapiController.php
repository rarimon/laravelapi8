<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Validator;

class ProductapiController extends Controller
{

    //show api
    public function allproduct($id = null)
    {
        if ($id == '') {
            $data = Product::get();
            return response()->json(['product' => $data], 200);
        } else {
            $data = Product::find($id);
            return response()->json(['product' => $data], 200);
        }
    }

    //add product 

    public function add_product(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

            $ruls = [
                'name' => 'required',
                'price' => 'required',
            ];

            $custom_message = [
                'name.required' => 'Name is Required',
                'price.required' => 'price is Required',
            ];

            $validators = Validator::make($data, $ruls, $custom_message);
            if ($validators->fails()) {
                return response()->json($validators->errors(), 422);
            }



            $product = new Product();
            $product->name = $data['name'];
            $product->price = $data['price'];

            $product->save();

            $message = 'Product Added Successfully!';
            return response()->json(['message' => $message], 201);
        }
    }





    public function add_productmultiple(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

            $ruls = [
                'users.*.name' => 'required',
                'users.*.price' => 'required',
            ];

            $custom_message = [
                'users.*.name.required' => 'Name is Required',
                'users.*.price.required' => 'price is Required',
            ];

            $validators = Validator::make($data, $ruls, $custom_message);
            if ($validators->fails()) {
                return response()->json($validators->errors(), 422);
            }

            foreach ($data['users']  as $aduser) {

                $product = new Product();
                $product->name = $aduser['name'];
                $product->price = $aduser['price'];

                $product->save();

                $message = 'Product Added Successfully!';
            }
            return response()->json(['message' => $message], 201);
        }
    }
}
