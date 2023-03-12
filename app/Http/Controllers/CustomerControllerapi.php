<?php

namespace App\Http\Controllers;

use App\Models\Customer;

use Illuminate\Http\Request;
use Validator;

class CustomerControllerapi extends Controller
{

    public function list_customer($id = null)
    {
        if ($id == '') {
            $data = Customer::get();
            return response()->json(['message' => $data], 200);
        } else {
            $data = Customer::findorfail($id);
            return response()->json(['message' => $data], 200);
        }
    }



    //add single customer put api
    public function add_customer(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

            $ruls = [
                'customers.*.name' => 'required',
                'customers.*.phone' => 'required',
            ];

            $custom_message = [
                'customers.*.name.required' => 'The Name is required',
                'customers.*.phone.required' => 'The phone is required',
            ];
            $validators = Validator::make($data, $ruls, $custom_message);
            if ($validators->fails()) {
                return response()->json($validators->errors(), 422);
            }


            foreach ($data['customers'] as $adcustomer) {
                $customer = new Customer();
                $customer->name = $adcustomer['name'];
                $customer->phone = $adcustomer['phone'];
                $customer->save();

                $message = 'Customer Added SuccessfullY!';
            }


            return response()->json(['message' => $message, 201]);
        }
    }
}
