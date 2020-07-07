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
                if ($payment_status === 'Percentage'){
                    // To artisan
                    $this->genSendJobOrder($payment);
                    // To Client
                    $this->genSendReceipt($payment);
                }
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
                ->subject('Invoice Payment Confirmation: #'.$payment->invoice->id);
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

    public function checkout($id = null){
        if ( ! $id){
            abort(404);
        }

        $title = __('app.checkout');
        $package = Pricing::find($id);
        return view('checkout', compact('title', 'package'));
    }


    public function checkoutPost(Request $request, $package_id){

        $user = Auth::user();
        $package = Pricing::find($package_id);
        $gateway = $request->gateway;
        $currency = get_option('currency_sign');

        $transaction_id = 'tran_'.time().str_random(6);
        // get unique recharge transaction id
        while( ( Payment::whereLocalTransactionId($transaction_id)->count() ) > 0) {
            $transaction_id = 'reid'.time().str_random(5);
        }
        $transaction_id = strtoupper($transaction_id);

        $paymentData = [
            'user_id'           => $user->id,
            'name'              => $user->name,
            'email'             => $user->email,
            'package_name'      => $package->package_name,
            'package_id'        => $package_id,
            'amount'            => $package->price,
            'premium_job'       => $package->premium_job,
            'payment_method'    => $gateway,
            'status'            => 'initial',
            'currency'          => $currency,
            'local_transaction_id'  => $transaction_id,
        ];

        $payment = Payment::create($paymentData);
        return redirect(route('payment', $payment->local_transaction_id));
    }


    public function payment($transaction_id = null){
        if ( ! $transaction_id){
            abort(404);
        }
        $payment = Payment::whereLocalTransactionId($transaction_id)->whereStatus('initial')->first();
        if ( ! $payment){
            $title = "Invalid payment request or has been used";
            $msg = "You are trying to a payment request that has been already paid or an invalid payment, please try checkout again by selecting any package.";
            return view('notice', compact('title', 'msg'));
        }

        $title = __('app.pay');
        return view('payment', compact('title', 'payment'));
    }


    public function paymentSuccess($transaction_id = null){
        if ( ! $transaction_id){
            abort(404);
        }
        $title = "Thank you";
        $type = 'success';
        $msg = "Your payment has been success";
        return view('notice', compact('title', 'type','msg'));
    }
    public function paymentCancelled($transaction_id = null){
        if ( ! $transaction_id){
            abort(404);
        }
        $title = "Payment has been cancelled";
        $msg = "Your payment has been cancelled";
        return view('notice', compact('title', 'msg'));
    }


    /**
     * @param Request $request
     * @return mixed
     *
     * Payment gateway PayPal
     */
    public function paypalRedirect(Request $request, $transaction_id){
        $payment = Payment::whereLocalTransactionId($transaction_id)->whereStatus('initial')->first();

        $currency = get_option('currency_sign');

        // PayPal settings
        $paypal_action_url = "https://www.paypal.com/cgi-bin/webscr";
        if (get_option('enable_paypal_sandbox') == 1){
            $paypal_action_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
        }

        $paypal_email = get_option('paypal_receiver_email');
        $return_url = route('payment_success', $transaction_id);
        $cancel_url = route('payment_cancel');
        $notify_url = route('paypal_notify', $transaction_id);

        $item_name = __('app.package').' '. $payment->package_name;

        // Check if paypal request or response
        $querystring = '';

        // Firstly Append paypal account to querystring
        $querystring .= "?business=".urlencode($paypal_email)."&";

        // Append amount& currency (£) to quersytring so it cannot be edited in html
        //The item name and amount can be brought in dynamically by querying the $_POST['item_number'] variable.
        $querystring .= "item_name=".urlencode($item_name)."&";
        $querystring .= "amount=".urlencode($payment->amount)."&";
        $querystring .= "currency_code=".urlencode($currency)."&";

        $querystring .= "first_name=".urlencode(session('cart.full_name'))."&";
        //$querystring .= "last_name=".urlencode($ad->user->last_name)."&";
        $querystring .= "payer_email=".urlencode(session('cart.email') )."&";
        $querystring .= "item_number=".urlencode($transaction_id)."&";

        //loop for posted values and append to querystring
        foreach(array_except($request->input(), '_token') as $key => $value){
            $value = urlencode(stripslashes($value));
            $querystring .= "$key=$value&";
        }

        // Append paypal return addresses
        $querystring .= "return=".urlencode(stripslashes($return_url))."&";
        $querystring .= "cancel_return=".urlencode(stripslashes($cancel_url))."&";
        $querystring .= "notify_url=".urlencode($notify_url);

        // Append querystring with custom field
        //$querystring .= "&custom=".USERID;

        // Redirect to paypal IPN
        header('location:'.$paypal_action_url.$querystring);
        exit();
    }

    /**
     * @param Request $request
     * @param $transaction_id
     *
     * Check paypal notify
     */
    public function paypalNotify(Request $request, $transaction_id){
        //todo: need to  be check
        $payment = Payment::whereLocalTransactionId($transaction_id)->where('status','!=','success')->first();

        $verified = paypal_ipn_verify();
        if ($verified){
            //Payment success, we are ready approve your payment
            $payment->status = 'success';
            $payment->charge_id_or_token = $request->txn_id;
            $payment->description = $request->item_name;
            $payment->payer_email = $request->payer_email;
            $payment->payment_created = strtotime($request->payment_date);
            $payment->save();

            //Crediting Balance
            $payment->addJobBalance($payment->premium_job);
        }else{
            $payment->status = 'declined';
            $payment->description = trans('app.payment_declined_msg');
            $payment->save();
        }
        // Reply with an empty 200 response to indicate to paypal the IPN was received correctly
        header("HTTP/1.1 200 OK");
    }


    /**
     * @return array
     *
     * receive card payment from stripe
     */
    public function paymentStripeReceive(Request $request, $transaction_id){
        $payment = Payment::whereLocalTransactionId($transaction_id)->where('status','!=','success')->first();

        $stripeToken = $request->stripeToken;
        \Stripe\Stripe::setApiKey(get_stripe_key('secret'));
        // Create the charge on Stripe's servers - this will charge the user's card
        try {
            //Charge from card
            $charge = \Stripe\Charge::create(array(
                "amount"        => get_stripe_amount($payment->amount), // amount in cents, again
                "currency"      => $payment->currency,
                "source"        => $stripeToken,
                "description"   => $payment->package_name." Package"
            ));

            if ($charge->status == 'succeeded'){
                //Save payment into database
                $data = [
                    //Card Info
                    'card_last4'        => $charge->source->last4,
                    'card_id'           => $charge->source->id,
                    'card_brand'        => $charge->source->brand,
                    'card_country'      => $charge->source->US,
                    'card_exp_month'    => $charge->source->exp_month,
                    'card_exp_year'     => $charge->source->exp_year,
                    'status'            => 'success',
                ];

                $payment->update($data);
                $payment->addJobBalance($payment->premium_job);

                return ['success'=>1, 'msg'=> trans('app.payment_received_msg')];
            }
        } catch(\Stripe\Error\Card $e) {
            // The card has been declined
            return ['success'=>0, 'msg'=> trans('app.payment_declined_msg'), 'response' => $e];
        }
    }


    public function paymentBankTransferReceive(Request $request, $transaction_id){
        $payment = Payment::whereLocalTransactionId($transaction_id)->where('status','!=','success')->first();

        $rules = [
            'bank_swift_code'   => 'required',
            'account_number'    => 'required',
            'branch_name'       => 'required',
            'branch_address'    => 'required',
            'account_name'      => 'required',
        ];
        $this->validate($request, $rules);

        $payments_data = [
            'amount'                => $payment->amount,
            'payment_method'        => 'bank_transfer',
            'status'                => 'pending',
            'currency'              => $payment->currency,

            'bank_swift_code'   => $request->bank_swift_code,
            'account_number'    => $request->account_number,
            'branch_name'       => $request->branch_name,
            'branch_address'    => $request->branch_address,
            'account_name'      => $request->account_name,
            'iban'              => $request->iban,
        ];
        $payment->update($payments_data);

        return redirect(route('payment_success', $transaction_id));

    }


}
