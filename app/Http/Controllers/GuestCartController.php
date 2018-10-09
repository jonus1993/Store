<?php

namespace App\Http\Controllers;

use App\CartGst;
use App\Items;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use NotificationChannels\Smsapi\SmsapiChannel;
use NotificationChannels\Smsapi\SmsapiSmsMessage;
use App\ GusService;

    use GusApi\Exception\InvalidUserKeyException;
    use GusApi\GusApi;
    use GusApi\ReportTypes;
    use SoapClient;

    //kontroler do obsługi koszyka w sesji

class GuestCartController extends Controller
{
    public function getAddToCart(Request $request, Items $item, $qty = 1)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new CartGst($oldCart);
        $cart->add($item, $item->id, $qty);
        $request->session()->put('cart', $cart);

        return redirect()->back();
    }

    public function delFromCart(Request $request, Items $item)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new CartGst($oldCart);
        $cart->del($item);

        if ($cart->totalQty == 0) {
            Session::forget('cart');
        } else {
            $request->session()->put('cart', $cart);
        }

        return redirect()->back();
    }

    public function getCart()
    {
        if (!Session::has('cart')) {
            return view("cart.index");
        }
        $oldCart = Session::get('cart');
        $cart = new CartGst($oldCart);

        return view('cart.index', ['items' => $cart->items, 'totalQty' => $cart->totalQty, 'totalPrice' => $cart->totalPrice]);
    }

    public function getCheckout()
    {
        if (!Session::has('cart')) {
            return view("cart.index");
        }
        $oldCart = Session::get('cart');
        $cart = new CartGst($oldCart);
        $total = $cart->totalPrice;

        return view('items.checkout', ['total' => $total]);
    }
    
    public function getTest()
    {
        return view('test');
    }
    
    public function sendSMS(Request $request)
    {
        $input = $request->all();
        $sms = new SmsapiSmsMessage();
        $sms->to($input['phone'])->content($input['msg']);
        return [SmsapiChannel::class];
        return back();
    }
    


    public function apiGUS(Request $request)
    {
//        $gus = new GusApi('your api key here');
        //for development server use:
        $gus = new GusApi('abcde12345abcde12345', 'dev');

        try {
            $nipToCheck = '9662114948'; //change to valid nip value
            $gus->login();

            $gusReports = $gus->getByNip($nipToCheck);

            foreach ($gusReports as $gusReport) {
                //you can change report type to other one
                $reportType = ReportTypes::REPORT_PUBLIC_LAW;
                echo $gusReport->getName();
                $fullReport = $gus->getFullReport($gusReport, $reportType);
                var_dump($fullReport);
            }
        } catch (InvalidUserKeyException $e) {
            echo 'Bad user key';
        } catch (\GusApi\Exception\NotFoundException $e) {
            echo 'No data found <br>';
            echo 'For more information read server message below: <br>';
            echo $gus->getResultSearchMessage();
        }
    }
    
    public function apiGUS2(Request $request)
    {
        $gus = new GusService();
        $nip = "5420000245";
        $odp = $gus->checkNip($nip);
        
        dd($odp);
    }
    
}
