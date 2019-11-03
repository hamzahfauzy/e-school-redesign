<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Payment;

class PaymentController extends Controller
{

    function __construct()
    {
        $this->payment = new Payment;
    }

    public function index()
    {
        //
        $payments = $this->payment->paginate(20);
        return view('payment.index',[
            'payments' => $payments
        ]);
    }

    public function show($id)
    {
        //
    }

    public function pending($id){
        return $this->change($id, 0, "Pending");
    }

    public function accept($id){
        return $this->change($id, 1, "Accepted");
    }
    
    public function decline($id){
        return $this->change($id, 2, "Declined");
    }

    function change($id, $status, $des)
    {
        $payment = $this->payment->find($id);
        if($payment){
            $payment->status = $status; 
            if($payment->save()){
                return redirect()->route('payment.index')->with(['success' => 'Payment of "'.$payment->customer['name'].'" has been '.$des.'.']);
            }
        }else{
            return redirect()->route('payment.index')->with(['success' => 'Sorry, Customer not found!']);
        }
    }

    public function destroy($id)
    {
        $payment = $this->payment->find($id);
        $p = $payment;
        $payment->delete();
        return redirect()->route('payment.index')->with(['success' => 'Payment of "'.$p->customer->name.'" has deleted !']);
    }
}
