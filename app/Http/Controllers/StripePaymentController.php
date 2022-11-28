<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Stripe;

class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {
        return view('stripe');
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $customer = array(
            "address" => [
                "line1" => "1/A Mohakhali",
                "postal_code" => "1200",
                "city" => "DHAKA",
                "state" => "DHK",
                "country" => "BD",
            ],
            "email" => "ferdous.bs23@gmail.com",
            "name" => "Ferdous Azad",
            "source" => $request->stripeToken
        );

        $customer = Stripe\Customer::create($customer);

        $customer_info = [
            "amount" => 100 * 100,
            "currency" => "usd",
            "customer" => $customer->id,
            "description" => "Test payment from BS23",
            "shipping" => [
                "name" => "Jenny Rosen",
                "address" => [
                    "line1" => "510 Townsend St",
                    "postal_code" => "98140",
                    "city" => "San Francisco",
                    "state" => "CA",
                    "country" => "US",
                ],
            ]
        ];

        \Stripe\Charge::create($customer_info);
        Session::flash('success', 'Payment successful!');
        return back();
    }
}
