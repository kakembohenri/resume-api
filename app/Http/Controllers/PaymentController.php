<?php

namespace App\Http\Controllers;

use App\CustomHelpers\ReturnBase;
use App\Models\Payment;
use App\Models\Resume;
use Exception;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use KingFlamez\Rave\Facades\Rave as Flutterwave;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    /** MAKE PAYMENT
     * DESCRIPTION: Handle the action of making a payment
     * ENDPOINT: /subscriptions
     * METHOD: POST
     * TODO
     * - call flutterwave api with details about the subscription plan
     * - redirect_url should be url on frontend
     * - decode response in resp parameter
     * - send resp to backend
     */

    public function MakePayment()
    {
        try {

            $reference = Flutterwave::generateReference();

            $data = [
                'payment_options' => 'card,banktransfer,mobilemoney',
                'amount' => 50000,
                'email' => auth()->user()->Email,
                'tx_ref' => $reference,
                'currency' => "UGX",
                'redirect_url' => env('FLW_CALLBACK_URL') . auth()->user()->Id . "/",
                'customer' => [
                    "user_id" => auth()->user()->Id,
                    'email' => auth()->user()->Email,
                    "name" => auth()->user()->Name,
                ],
                "customizations" => [
                    "title" => 'Make payment',
                    "description" => 'Payment for access to CV'
                ]
            ];

            $charge  = Flutterwave::initializePayment($data);

            if ($charge['status'] !== 'success') {
                // notify something went wrong
                return ReturnBase::Error('Something went wrong!', Response::HTTP_BAD_REQUEST);
            }

            return ReturnBase::JustMessage($charge['data']['link'], Response::HTTP_OK);
        } catch (\Exception $exp) {
            if ($exp instanceof ConnectException) {
                return ReturnBase::Error("Having issues connecting to flutterwave servers. 
                Please Immediatley Try Making The Transaction Again", Response::HTTP_BAD_REQUEST);
            } else {
                return ReturnBase::InternalServerError($exp);
            }
        }
    }

    /** CONFIRM A PAYMENT
     * DESCRIPTION: Deals with processing the result from attempting to make a payment from the
     * flutterwave portal
     *
     *
     *
     */

    public function ConfirmPayment(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'params' => 'required|string'
            ]);

            if ($validator->fails()) {
                return ReturnBase::HandleValidationErrors($validator);
            }

            parse_str($request->params, $queryArray);
            $status = $queryArray['status'];

            //if payment is successful
            if ($status == 'successful') {
                // $transactionID = Flutterwave::getTransactionIDFromCallback();
                $transactionID = $queryArray['transaction_id'];
                $data = Flutterwave::verifyTransaction($transactionID);
                $amount = $data['data']['amount'];
                // Create payment
                Payment::create([
                    'User_Id' => auth()->user()->Id,
                    'Amount' => $amount,
                    'CreatedAt' => date('Y-m-d H:i:s', time()),
                ]);

                $code = Str::random(64);

                // Include AccessCode
                Resume::where('User_Id', auth()->user()->Id)->update([
                    'RefererCode' =>  $code
                ]);

                return ReturnBase::JustMessage('Payment is successful', Response::HTTP_CREATED);
            } elseif ($status ==  'cancelled') {
                //Put desired action/code after transaction has been cancelled here
                Log::warning('canceled');
                return ReturnBase::Error('Transaction cancelled', Response::HTTP_BAD_REQUEST);
            } else {
                //Put desired action/code after transaction has failed here
                Log::error('Youre screwed!!!');
                return ReturnBase::Error('Transaction failed', Response::HTTP_CREATED);
            }
        } catch (Exception $exp) {
            return ReturnBase::InternalServerError($exp);
        }

        // Get the transaction from your DB using the transaction reference (txref)
        // Check if you have previously given value for the transaction. If you have, redirect to your successpage else, continue
        // Confirm that the currency on your db transaction is equal to the returned currency
        // Confirm that the db transaction amount is equal to the returned amount
        // Update the db transaction record (including parameters that didn't exist before the transaction is completed. for audit purpose)
        // Give value for the transaction
        // Update the transaction to note that you have given value for the transaction
        // You can also redirect to your success page from here
    }
}
