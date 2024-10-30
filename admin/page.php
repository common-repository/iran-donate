<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function irdonate_main_function(){

    global $wpdb,$table_prefix;

    $has_error=false;

    $success=false;

    $massage='';


    if (isset($_GET['action'])){
        

        $action=$_GET['action'];
        switch ($action){

            case 'delete';

                $item_id=isset($_GET['item_id'])?intval($_GET['item_id']):0;

                if ($item_id){

                    $result=$wpdb->delete($table_prefix.'irdonate_payments',array('ID'=>$item_id),array('%d'));
                    

                    if ($result){

                        $success=true;

                        $massage='پرداخت مورد نظر با موفقیت حذف شد.';

                    }elseif(!$result){

                        $has_error=true;
                        $massage='خطایی رخ داده است.لطفا دوباره امتحان کنید.';
                    }

                }
                break;

        }

    }

    $all_payments=$wpdb->get_results("SELECT * FROM {$table_prefix}irdonate_payments ");
    

    include IRDONATE_TPL_DIR.'html-admin-main.php';
    
}
function irdonate_settilng_page(){

    $tabs=array('general'=>'عمومی' ,'massage'=>'پیام ها','banks'=>'بانک ها');

    $current_tab= isset($_GET['tab'])?$_GET['tab']:'general';

    $massage_tpl=array(
      '[name]'=>'نام و نام خانوادگی',
        '[email]'=>'ایمیل',
        '[mobile]'=>'تلفن همراه',
        '[order_id]'=>'شناسه سفارش',
        '[raf_id]'=>'شماره پیگری'
    );

    if (isset($_POST['submit'])){

        wp_verify_nonce($_POST['irdonate_nonce'],'save_irdonate_setting') || wp_die("درخواست شما نا معتبر می باشد.");

        update_option('irdonate_active',isset($_POST['irdonate_active'])?1:0);

        !empty($_POST['irdonate_admin_mobile'])?update_option('irdonate_admin_mobile',sanitize_text_field($_POST['irdonate_admin_mobile'])):null;

        !empty($_POST['irdonate_zarinpal_username'])?update_option('irdonate_zarinpal_username',sanitize_text_field($_POST['irdonate_zarinpal_username'])):null;

        !empty($_POST['irdonate_faragatepal_username'])?update_option('irdonate_faragatepal_username',sanitize_text_field($_POST['irdonate_faragatepal_username'])):null;

        !empty($_POST['irdonate_fp_username'])?update_option('irdonate_fp_username',sanitize_text_field($_POST['irdonate_fp_username'])):null;

        !empty($_POST['irdonate_fp_password'])?update_option('irdonate_fp_password',sanitize_text_field($_POST['irdonate_fp_password'])):null;

        !empty($_POST['irdonate_fp_from'])?update_option('irdonate_fp_from',sanitize_text_field($_POST['irdonate_fp_from'])):null;

        !empty($_POST['irdonate_massage_tpl'])?update_option('irdonate_massage_tpl',sanitize_text_field($_POST['irdonate_massage_tpl'])):null;


    }

    include IRDONATE_TPL_DIR.'html-setting-main.php';

}