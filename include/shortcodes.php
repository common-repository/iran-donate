<?php
if ( ! defined( 'ABSPATH' ) ) exit;

add_shortcode('irdonateay_form','irdonateay_form' );


function irdonateay_form(){
    $has_error=false;
    $massage="";

    $status= 0;


    if(isset($_GET['bank'])){

        $bank=$_GET['bank'];
        switch ($bank){

            case 'zarinpal';

               $return_result=irdonate_zarinpal_verify();
                $status= 1;
                break;
            case 'faragate';
                $return_result=irdonate_faragate_verify();
                $status= 1;
                break;
            default;
                break;

        }
    }



    $irdonate_active=intval(get_option('irdonate_active'));
    if (!$irdonate_active){

        return 'فرم پرداخت در حال حاضر در دسترس نمی باشد.';
    }

    if(isset($_POST['irdonateay_submit'])){

        wp_verify_nonce($_POST['irdonate_nonce'],'irdonate_payment') || wp_die("درخواست شما نا معتبر می باشد.");



        $fullname=sanitize_text_field($_POST['fullname']);
        $email=sanitize_email($_POST['email']);
        $mobile=sanitize_text_field($_POST['mobile']);
        $amount=intval($_POST['amount']);
        $description=sanitize_text_field($_POST['description']);
        $bank=esc_sql($_POST['bank']);
        $date=date('y-m-d H:I:S');

        foreach($_POST as $key=>$value){
            if(empty($value)){

                $has_error=true;
                $massage="پرکردن تمامی فیلد ها الزامی می باشد!";

            }
        }
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){

            $has_error=true;
            $massage="لطفا ایمیل معتبر وارد کنید!";
        }

        if(!$amount){

            $has_error=true;
            $massage="مقدار مبلغ حتما باید به صورت عددی وارد شود!";

        }
        if(!$has_error){

            global $wpdb,$table_prefix;


            $order_id=time().rand(1000,9999);




            $data=array(
                'bank'=>$bank,

                'name'=>$fullname,

                'email'=>$email,

                'mobile'=>$mobile,

                'description'=>$description,

                'amount'=>$amount,

                'order_id'=>$order_id,

                'date'=>$date,

            );


                $result=$wpdb->insert($table_prefix.'irdonate_payments',$data,array('%s','%s','%s','%s','%s','%d') );



            if ($result){


                $data['ID']=$wpdb->insert_id;

                if($bank=='zarinpal'){


                    irdonate_zarinpal_request($data);

                }else{

                    irdonate_faragate_request($data);

                }

            }

        }


    }


    ?>

    <div class="irdonateay_wrawp">
        <?php switch ($status){
            case 0;
                include IRDONATE_TPL_DIR.'html-user-form.php';
                break;
            case 1;
               // include IRDONATE_TPL_DIR.'html-user-retutn.php';
               echo $return_result;
                break;
            default:
                include IRDONATE_TPL_DIR.'html-user-form.php';
                break;

        } ?>


        </div>

<?php
}?>