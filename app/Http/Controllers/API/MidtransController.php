<?php

namespace App\Http\Controllers\API;

use Midtrans\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Midtrans\Notification;

class MidtransController extends Controller
{
    public function callback(Request $request)
    {
        // Set Midtrans Configuration
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$clientKey = config('services.midtrans.clientKey');
        Config::$isSanitized = config('services.midtrans.isSantized');
        Config::$is3ds = config('services.midtrans.is3ds');

        // Create Instance Midtrans Notification
        $notification = new Notification();

        // Assign to Variable for Easier Coding
        $status = $notification->transaction_status;
        $type = $notification->payment_type;
        $fraud = $notification->fraud_status;
        $order_id = $notification->order_id;

        // Search Transaction by ID
        $transaction = Transaction::findOrFail($order_id);

        // Handle Midtrans Status Notification
        if($status == 'capture'){
            if($type == 'credit_card'){
                if($fraud == 'challenge'){
                    $transaction->status = 'PENDING';
                }else{
                    $transaction->status = 'SUCCESS';
                }
            }
        }else if($status == 'settlement'){
            $transaction->status = 'SUCCESS';
        }else if($status == 'pending'){
            $transaction->status = 'PENDING';
        }else if($status == 'deny'){
            $transaction->status = 'CANCELLED';
        }else if($status == 'expire'){
            $transaction->status = 'CANCELLED';
        }else if($status == 'cancel'){
            $transaction->status = 'CANCELLED';
        }

        // Save Transaction

        $transaction->save();
    }

    public function success()
    {
        return view('midtrans.success');
    }
    
    public function unfinish()
    {
        return view('midtrans.unfinish');
    }
    
    public function error()
    {
        return view('midtrans.error');
    }
}
