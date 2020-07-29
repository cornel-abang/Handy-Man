<?php

namespace App\Http\Controllers;

use App\Payment;
use App\Pricing;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Paystack;
use App\Invoice;
use App\Mail\sendJobOrder;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
   
    /*########################################
        PAYSTACK PAYMENT GATEWAY INTEGRATION #
     ########################################*/
    public function redirectToGateway()
    {
        return Paystack::getAuthorizationUrl()->redirectNow(); 
    }

     public function handleGatewayCallback()
     {         
        $paymentDetails = Paystack::getPaymentData(); 
        if ($paymentDetails['data']['status'] === 'success') {
            // dd($paymentDetails);
            $payment_status = $paymentDetails['data']['metadata']['payment_status'] === 'Percentage' ? 'Percentage':'Paid';
            $invoice_id = $paymentDetails['data']['metadata']['invoice_id'];
            $invoice = Invoice::find($invoice_id);
            $invoice->status = $payment_status;
            $invoice->save();

            $data = [
                        'invoice_id'    => $invoice_id,
                        'payer_name'    => auth()->user()->name,
                        'amount_paid'   => $paymentDetails['data']['amount']/100,
                        'reference'     => $paymentDetails['data']['reference'],
                        'channel'       => $paymentDetails['data']['authorization']['channel'],
                        'card_type'     => $paymentDetails['data']['authorization']['card_type'],
                        'payer_bank'    => $paymentDetails['data']['authorization']['bank'],
                        'payment_status'=> $payment_status
                    ];
            $payment = Payment::create($data);
            if ($payment) {
                //flash so the helper can pick it up
                session()->flash('successfull_payment', true);
                // if ($payment_status === 'Percentage'){
                //     // To artisan
                //     $this->genSendJobOrder($payment);
                // }
                    // To Client
                    $this->genSendReceipt($payment);
            }else{
                session()->flash('successfull_payment', false);
            }
            return redirect(route('all')); 
        }         
        session()->flash('successfull_payment', false);     
        return redirect(route('all'));
    } 

    public function index(){
        $title = 'Payments';
        $payments = Payment::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.payments', compact('title', 'payments'));
    }

    public function genSendJobOrder($payment)
    {
        $beautymail = app()->make(\Snowfire\Beautymail\Beautymail::class);
        $beautymail->send('emails.job_order', ['data'=>$payment], function($message) use ($payment)
        {
            $message
                ->from('info@handiman.com','Handiman Services')
                ->to($payment->invoice->service->artisan->email, $payment->invoice->service->artisan->full_name)
                ->subject('New Job Order');
        });
        return true;
    }

    public function genSendReceipt($payment)
    {
        $beautymail = app()->make(\Snowfire\Beautymail\Beautymail::class);
        $beautymail->send('emails.payment_confirmation', ['payment'=>$payment], function($message) use ($payment)
        {
            $message
                ->from('info@handiman.com','Handiman Services')
                ->to($payment->invoice->service->user->email, $payment->invoice->service->user->name)
                ->subject('Invoice #'.$payment->invoice->id.' Payment Confirmation');
        });
        return true;
    }

    public function view($id){
        $title = trans('app.payment_details');
        $payment = Payment::find($id);
        return view('admin.payment_view', compact('title', 'payment'));
    }

    public function markSuccess($id, $status){
        $payment = Payment::find($id);
        $payment->status = $status;
        $payment->save();

        if ($status === 'success'){
            $payment->addJobBalance();
        }

        return back()->with('success', trans('app.payment_status_changed'));
    }


}
