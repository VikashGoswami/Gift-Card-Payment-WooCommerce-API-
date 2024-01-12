<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Payment;
use Illuminate\Support\Facades\Session;

class GiftCardController extends Controller
{
    
    public function validateGiftCard(Request $request)
    {
        $apiUsername = config('secrets.woocommerce.api_username');
        $apiPassword = config('secrets.woocommerce.api_password');

        $giftCardNumber = $request->input('gift_card_number');

        $response = Http::withBasicAuth($apiUsername, $apiPassword)
            ->get('https://etesting.space/wp-json/wc-pimwick/v1/pw-gift-cards/?number=' . $giftCardNumber)->json();

        if ($response) {
            if ($response[0]['balance'] != null) {
                $validatedBalance = $response[0]['balance'];
            } else {
                $validatedBalance = '0';
            }
            Session::put('gift_card_number', $giftCardNumber);
            Session::put('balance', $validatedBalance);
            Session::put('id', $response[0]['pimwick_gift_card_id']);

            return redirect()->back()->with('giftSuccess', 'The Card is valid.');
        } else {
            Session::flush();
            return redirect()->back()->with('giftError', 'Invalid Gift Card, Please check the Gift Card Number')->with('giftNumber', $giftCardNumber);
        }
    }

    public function applyPaymentGiftCard(Request $request)
    {
        $apiUsername = config('secrets.woocommerce.api_username');
        $apiPassword = config('secrets.woocommerce.api_password');
        try {
            if (Session::has('gift_card_number') && Session::has('balance') && Session::has('id')) {

                $id1 = Session::get('id');
                $customerNumber = $request->input('customer_number');
                $giftCardNumber = Session::get('gift_card_number');
                $balance = Session::get('balance');

                $newBalance = "50.00";

                $url = 'https://etesting.space/wp-json/wc-pimwick/v1/pw-gift-cards/'.$id1;
                $updateResponse = Http::withBasicAuth($apiUsername, $apiPassword)->put( $url, ['balance' => $newBalance,] );

                if ($updateResponse->successful()) {
                    Payment::create([
                        'customer_number' => $customerNumber,
                        'card_number' => $giftCardNumber,
                        'balance' => $balance,
                    ]);

                    Session::flush();
                    return redirect()->back()->with('success', 'Payment created successfully.');
                } else {
                    Session::flush();
                    $error = $updateResponse->json();
                    return response()->json(['error' => $error['message']], $updateResponse->status());
                }
            } else {
                return redirect()->back()->with('error', 'Enter Gift Card Number and Check.');
                // return response()->json(['error' => 'Balance session not found'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
