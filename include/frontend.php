<?php
if ( ! defined( 'ABSPATH' ) ) exit;


add_action('wp_enqueue_scripts', 'irdonateay_load_user_asstes');

function irdonateay_load_user_asstes()
{

    wp_register_style('irdonateay_user_style', IRDONATE_CSS_URL . 'irdonateay_user_style.css');

    wp_enqueue_style('irdonateay_user_style');


}



function irdonate_zarinpal_request($data = array())
{

    $MerchantID =get_option('irdonate_zarinpal_username');  //Required
    $Amount =$data['amount']/10; //Amount will be based on Toman  - Required
    $Description = $data['description'];  // Required
    $Email = $data['email']; // Optional
    $Mobile = $data['mobile']; // Optional
    $CallbackURL = add_query_arg(array('bank'=>'zarinpal','order_id'=>$data['order_id'],'ID'=>$data['ID'],'amount'=>$data['amount']),get_permalink());  // Required

    // URL also can be ir.zarinpal.com or de.zarinpal.com
    $client = new SoapClient('https://www.zarinpal.com/pg/services/WebGate/wsdl', array('encoding' => 'UTF-8'));

    $result = $client->PaymentRequest(array(
        'MerchantID' => $MerchantID,
        'Amount' => $Amount,
        'Description' => $Description,
        'Email' => $Email,
        'Mobile' => $Mobile,
        'CallbackURL' => $CallbackURL,
    ));

    //Redirect to URL You can do it also by creating a form
    if ($result->Status == 100) {
        echo '<script type="text/javascript">';
        $Paymentzr_UR='https://www.zarinpal.com/pg/StartPay/'.$result->Authority;
        echo 'window.location="';
        echo $Paymentzr_UR;
        echo '";';
        echo '</script>';
        exit;

    } else {
        echo 'ERR: ' . $result->Status;
    }


}

function irdonate_faragate_request($data = array())
{


    $SandBox 			 =false;
    $MerchantCode        = get_option('irdonate_faragatepal_username');
    $PriceValue 		 = $data['amount']; //Rial
    $ReturnUrl 			 = add_query_arg(array('bank'=>'faragate','order_id'=>$data['order_id'],'ID'=>$data['ID']),get_permalink());
    $InvoiceNumber 		 = $data['order_id'];
    $PaymenterName 		 = $data['name'];
    $PaymenterEmail 	 = $data['email'];
    $PaymenterMobile 	 = $data['mobile'];
    $PluginName 		 = 'test';
    $PaymentNote		 = 'جهت حمایت از سایت';
    $CustomQuery		 = array("query1^test1", "query2^test2");
    $CustomPost 		 = array("field1^test1", "field2^test2");
    $ExtraAccountNumbers = array("FG1001^10", "FG1002^20");
    $Bank 				 = '';	//leave empty or Study Docs



    $Parameters = array(
        'SandBox'			  => $SandBox,
        'MerchantCode'  	  => $MerchantCode,
        'PriceValue'   		  => $PriceValue,
        'ReturnUrl'    		  => $ReturnUrl,
        'InvoiceNumber'		  => $InvoiceNumber,
        'CustomQuery'   	  => $CustomQuery,
        'CustomPost'          => $CustomPost,
        'PaymenterName'       => $PaymenterName,
        'PaymenterEmail' 	  => $PaymenterEmail,
        'PaymenterMobile' 	  => $PaymenterMobile,
        'PluginName' 		  => $PluginName,
        'PaymentNote'		  => $PaymentNote,
        'ExtraAccountNumbers' => $ExtraAccountNumbers,
        'Bank'				  => $Bank,
    );

    $Parameters['PaymenterEmail'] = !filter_var($Parameters['PaymenterEmail'], FILTER_VALIDATE_EMAIL) === false ? $Parameters['PaymenterEmail'] : '';
    $Parameters['PaymenterMobile'] = preg_match('/^09[0-9]{9}/i', $Parameters['PaymenterMobile']) ? $Parameters['PaymenterMobile'] : '';

    if ( extension_loaded('soap') ) {
        try {

            $client  = new SoapClient('http://faragate.com/services/soap?wsdl', array('encoding' => 'UTF-8') );
            $Request = $client->PaymentRequest( $Parameters );

            if ( isset($Request->Status) && $Request->Status == 1 ){

                $Token = isset($Request->Token) ? $Request->Token : '';
                $Payment_URL = sprintf( 'http://faragate.com/services/payment%s/%s', (!empty($Parameters['SandBox']) && $Parameters['SandBox'] ? '_test' : ''), $Token );


                if ( ! headers_sent() ) { header('Location: ' . $Payment_URL ); exit; }
                echo '<script type="text/javascript">window.location="' .$Payment_URL. '";</script>'; exit;


            }
            else {
                $Fault  = isset($Request->Status) ? $Request->Status : '';
                $Message = isset($Request->Message) ? $Request->Message : ''; //not already , maybe later
            }
        }
        catch(Exception $ex){
            $Message = $ex->getMessage();
        }
    }
    else {
        $Fault = '-26';
    }


    if ( !empty($Fault) && $Fault ) {
        return 'خطایی رخ داده است . علت خطا : ' ;
    }

    function irdonate_Faragate_Request_Results( $Fault ) {

        switch ($Fault) {

            case '-1' :
                $Response =	'نوع درخواست معتبر نیست .';
                break;

            case '-2' :
                $Response =	'مرچنت کد پذیرنده معتبر نیست .';
                break;

            case '-3' :
                $Response =	'شماره فاکتور معتبر نیست .';
                break;

            case '-4' :
                $Response =	'مقدار مبلغ معتبر نیست .';
                break;

            case '-5' :
                $Response =	'پست الکترونیکی پرداخت کننده معتبر نیست .';
                break;

            case '-6' :
                $Response =	'شماره موبایل پرداخت کننده معتبر نیست .';
                break;

            case '-7' :
                $Response =	'فیلدهای  Query String معتبر نیستند .';
                break;

            case '-8' :
                $Response =	'فیلدهای Post معتبر نیستند .';
                break;

            case '-9' :
                $Response =	'اطلاعات واریز به شماره حساب ها معتبر نیست .';
                break;

            case '-10' :
                $Response =	'کد درگاه معتبر نیست یا درگاه پذیرنده فعال نیست .';
                break;

            case '-11' :
                $Response =	'آدرس بازگشت به درگاه پذیرنده معتبر نیست .';
                break;

            case '-12' :
                $Response =	'مرچنت کد وارد شده برای این سایت نمی باشد .';
                break;

            case '-13' :
                $Response =	'آی پی درخواست کننده معتبر نیست .';
                break;

            case '-14' :
                $Response =	'بانک عامل معتبر نیست .';
                break;

            case '-15' :
                $Response =	'متاسفانه مشکلی در شبکه بانکی وجود دارد .';
                break;

            case '-16' :
                $Response =	'مقدار کلید پرداخت اشتباه است .';
                break;

            case '-17' :
                $Response =	'پرداخت قبلا استعلام شده و توسط بانک تایید نشده است .';
                break;

            case '-18' :
                $Response =	'پرداخت انجام نشده است .';
                break;

            case '-19' :
                $Response =	'پرداخت برگشت خورده است .';
                break;

            case '-20' :
                $Response =	'پرداخت توسط بانک تایید نشد .';
                break;

            case '-21' :
                $Response =	'پرداخت توسط بانک واریز نشد .';
                break;

            case '-22' :
                $Response =	'پرداخت برگشت زده شد .';
                break;

            case '-23' :
                $Response =	'پاسخی از بانک دریافت نشد .';
                break;

            case '-24' :
                $Response =	'اطلاعات پرداخت کننده معتبر نیست  (برای حالتی که با حساب فراگیت پرداخت انجام میشود) .';
                break;

            case '-25' :
                $Response =	'خطا در پایگاه داده درگاه رخ داده است .';
                break;

            case '-26' :
                $Response =	'ماژول SOAP بر روی هاست فعال نمی باشد .';
                break;

            default :
                $Response =	'تراکنش انجام نشد .';
                break;
        }
        return $Response;
    }


}

function irdonate_zarinpal_verify(){

    global $wpdb,$table_prefix;

    $payment=$wpdb->get_row("SELECT * FROM ($table_prefix)irdonate_payments WHERE ID=$_GET[ID]");

    $MerchantID = get_option('irdonate_zarinpal_username');;
    $Amount = $_GET['amount']/10; //Amount will be based on Toman
    $Authority = $_GET['Authority'];


    if ($_GET['Status'] == 'OK') {
        // URL also can be ir.zarinpal.com or de.zarinpal.com
        $client = new SoapClient('https://www.zarinpal.com/pg/services/WebGate/wsdl', array('encoding' => 'UTF-8'));

        $result = $client->PaymentVerification(array(
            'MerchantID'     => $MerchantID,
            'Authority'      => $Authority,
            'Amount'         => $Amount,
        ));

        if ($result->Status == 100) {

            $wpdb->update($table_prefix.'irdonate_payments',array('status'=>1,'ref_id'=>$result->RefID),array('ID'=>$_GET['ID']));

            irdonate_send_notification($_GET['ID']);

            irdonate_send_email();

            return 'کاربر گرامی پرداخت شما با موفقیت انجام شد.شناسه پرداخت شما برابر است با :'.$result->RefID;
        } else {
            return 'Transation failed. Status:'.$result->Status;
        }
    } else {
        echo 'Transaction canceled by user';
    }
}
function irdonate_faragate_verify(){

    global $wpdb,$table_prefix;

    $payment=$wpdb->get_row("SELECT * FROM ($table_prefix)irdonate_payments WHERE ID=$_GET[ID]");

    $MerchantCode = get_option('irdonate_faragatepal_username');

    $InvoiceNumber = isset($_POST['InvoiceNumber']) ? $_POST['InvoiceNumber'] : '';
    $Transaction_ID = $Token = isset($_POST['Token']) ? $_POST['Token'] : '';

    if ( extension_loaded('soap') ) {
        if( isset($_POST['Status']) && $_POST['Status'] == 1 ) {
            try {

                $client = new SoapClient('http://faragate.com/services/soap?wsdl', array('encoding' => 'UTF-8') );
                $Request = $client->PaymentVerify( array(
                        'SandBox' 	   => !empty($_POST['SandBox']),
                        'MerchantCode' => $MerchantCode,
                        'Token' 	   => $Token
                    )
                );

                if( isset($Request->Status) && $Request->Status == 1 ){
                    $Status = 'completed';
                    $Fault = '';
                }
                else {
                    $Status  = 'failed';
                    $Fault   = isset($Request->Status) ? $Request->Status : '';
                    $Message = isset($Request->Message) ? $Request->Message : ''; //not already , maybe later
                }
            }
            catch(Exception $ex){
                $Message = $ex->getMessage();
            }
        }
        else {
            $Status = 'failed';
            $Fault = isset($_POST['Status']) ? $_POST['Status'] : '';
        }
    }
    else {
        $Status = 'failed';
        $Fault = '-26';
    }



    if ( $Status == 'completed' ) {
        $wpdb->update($table_prefix.'irdonate_payments',array('status'=>1,'ref_id'=>$Transaction_ID),array('ID'=>$_GET['ID']));

        irdonate_send_notification($_GET['ID']);

        irdonate_send_email();

        return 'پرداخت موفقت امیز'.$_GET['ID'].'شناسه :'.$Transaction_ID;

    }
    else {
        return 'وضعیت پرداخت : نا موفق ';

        if ( !empty($Fault) && !empty($Status) ) {
            return 'علت خطا : ' . Faragate_Verify_Results( $Fault );
        }
    }

    function irdonate_Faragate_Verify_Results( $Fault ) {

        switch ($Fault) {

            case '-1' :
                $Response =	'نوع درخواست معتبر نیست .';
                break;

            case '-2' :
                $Response =	'مرچنت کد پذیرنده معتبر نیست .';
                break;

            case '-3' :
                $Response =	'شماره فاکتور معتبر نیست .';
                break;

            case '-4' :
                $Response =	'مقدار مبلغ معتبر نیست .';
                break;

            case '-5' :
                $Response =	'پست الکترونیکی پرداخت کننده معتبر نیست .';
                break;

            case '-6' :
                $Response =	'شماره موبایل پرداخت کننده معتبر نیست .';
                break;

            case '-7' :
                $Response =	'فیلدهای  Query String معتبر نیستند .';
                break;

            case '-8' :
                $Response =	'فیلدهای Post معتبر نیستند .';
                break;

            case '-9' :
                $Response =	'اطلاعات واریز به شماره حساب ها معتبر نیست .';
                break;

            case '-10' :
                $Response =	'کد درگاه معتبر نیست یا درگاه پذیرنده فعال نیست .';
                break;

            case '-11' :
                $Response =	'آدرس بازگشت به درگاه پذیرنده معتبر نیست .';
                break;

            case '-12' :
                $Response =	'مرچنت کد وارد شده برای این سایت نمی باشد .';
                break;

            case '-13' :
                $Response =	'آی پی درخواست کننده معتبر نیست .';
                break;

            case '-14' :
                $Response =	'بانک عامل معتبر نیست .';
                break;

            case '-15' :
                $Response =	'متاسفانه مشکلی در شبکه بانکی وجود دارد .';
                break;

            case '-16' :
                $Response =	'مقدار کلید پرداخت اشتباه است .';
                break;

            case '-17' :
                $Response =	'پرداخت قبلا استعلام شده و توسط بانک تایید نشده است .';
                break;

            case '-18' :
                $Response =	'پرداخت انجام نشده است .';
                break;

            case '-19' :
                $Response =	'پرداخت برگشت خورده است .';
                break;

            case '-20' :
                $Response =	'پرداخت توسط بانک تایید نشد .';
                break;

            case '-21' :
                $Response =	'پرداخت توسط بانک واریز نشد .';
                break;

            case '-22' :
                $Response =	'پرداخت برگشت زده شد .';
                break;

            case '-23' :
                $Response =	'پاسخی از بانک دریافت نشد .';
                break;

            case '-24' :
                $Response =	'اطلاعات پرداخت کننده معتبر نیست  (برای حالتی که با حساب فراگیت پرداخت انجام میشود) .';
                break;

            case '-25' :
                $Response =	'خطا در پایگاه داده درگاه رخ داده است .';
                break;

            case '-26' :
                $Response =	'ماژول SOAP بر روی هاست فعال نمی باشد .';
                break;

            default :
                $Response =	'تراکنش انجام نشد .';
                break;
        }
        return $Response;
    }
}

function irdonate_send_notification($pid){

    global $wpdb,$table_prefix;

    $table_name=$table_prefix.'irdonate_payments';

    $payment=$wpdb->get_row("SELECT * FROM $table_name WHERE ID=($pid)");


    $msg_tpl=get_option('irdonate_massage_tpl');

    $massage_tpl=array(
        '[name]'=>'نام و نام خانوادگی',
        '[email]'=>'ایمیل',
        '[mobile]'=>'تلفن همراه',
        '[order_id]'=>'شناسه سفارش',
        '[raf_id]'=>'شماره پیگری'
    );

    $msg_tpl=str_replace(array_keys($massage_tpl),array($payment->name,$payment->email,$payment->mobile,$payment->order_id,$payment->ref_id) ,$msg_tpl);


    irdonate_send_sms(array('msg'=>$msg_tpl,'mobile'=>$payment->mobile));


}
function irdonate_send_sms($data){

    ini_set("soap.wsdl_cache_enabled", "0");
    try {
        $client = new SoapClient("http://87.107.121.54/post/send.asmx?wsdl");
        $parameters['username'] = get_option('irdonate_fp_username');
        $parameters['password'] = get_option('irdonate_fp_password');
        $parameters['from'] = get_option('irdonate_fp_from');
        $parameters['to'] = array($data['mobile']);
        $parameters['text'] =$data['msg'];
        $parameters['isflash'] = false;
        $parameters['udh'] = "";
        $parameters['recId'] = array(0);
        $parameters['status'] = 0x0;
        return $client->SendSms($parameters)->SendSmsResult;
    } catch (SoapFault $ex) {
        return false;
    }

}
function irdonate_send_email(){

    $to=get_option('admin_email');
    $subject='حمایت از سایت شما';
    $messageem='پرداخت جدیدی در سایت شما ثبت شده.جهت اطلاع از آن به سایت مراجعه کنید';

    wp_mail( $to, $subject, $messageem );


}