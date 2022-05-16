<?php

namespace App\Http\Controllers\API;

use Exception;
use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit', 6);
        $vegetable_id = $request->input('vegetable_id');
        $status = $request->input('status');
    
        if($id){
            $transaction = Transaction::with('vegetable', 'user')->find($id);

            if($transaction){
                return ResponseFormatter::success(
                    $transaction,
                    'Transaction Data has Successfully Fetched'
                );
            }else{
                return ResponseFormatter::error(
                    null, 
                    'transaction Data Not Found', 
                    404);
            }
        }

        $transaction = Transaction::with('vegetable', 'user')->where('user_id', Auth::user()->id);

        if($vegetable_id){
            $transaction->where('vegetable_id',$vegetable_id);
        }
        
        if($status){
            $transaction->where('status',$status);
        }

        return ResponseFormatter::success(
            $transaction->paginate($limit),
            'Transaction List Data has Succesfully Fetched'
        );
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);

        $transaction->update($request->all());

        return ResponseFormatter::success($transaction, 'Transaction has Successfully Updated');
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'vegetable_id' => 'required|exists:vegetables,id',
            'quantity' => 'required',
            'total' => 'required',
            'status' => 'required',
        ]);

        $transaction = Transaction::create([
            'user_id' => $request->user_id,
            'vegetable_id' => $request->vegetable_id,
            'quantity' => $request->quantity,
            'total' => $request->total,
            'status' => $request->status,
            'payment_url' => '',

        ]);
        // Midtrans Configuration
            Config::$serverKey = config('services.midtrans.serverKey');
            Config::$clientKey = config('services.midtrans.clientKey');
            Config::$isSanitized = config('services.midtrans.isSantized');
            Config::$is3ds = config('services.midtrans.is3ds');
        
        //Call Transaction 
            $transaction = Transaction::with(['user','vegetable'])->find($transaction->id);
        
        // Create Midtrans Transaction
            $midtrans = [
                'transaction_details' => [
                    'order_id' => $transaction->id,
                    'gross_amount' => (int) $transaction->total,
                ],
                'customer_details' => [
                    'first_name' => $transaction->user->name,
                    'email' => $transaction->user->email,
                ],
                'enabled_payments' => ['gopay','bank_transfer'],
                'vtweb' => [],
            ];

        // Call Midtrans
            try {
                // Get Midtrans Payment Page
                $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;
                $transaction->payment_url = $paymentUrl;
                $transaction->save();
                
                // Return Data to API
                return ResponseFormatter::success($transaction, 'Transaction Success');
            } catch (Exception $exception) {
                return ResponseFormatter::error($exception->getMessage(), 'Transaction Failed');
            }
    }
}
