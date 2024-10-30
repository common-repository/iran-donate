<?php
if ( ! defined( 'ABSPATH' ) ) exit;

add_action('admin_menu','irdonate_admin_menu');

function irdonate_admin_menu(){
    
    $main=add_menu_page('حمایت از سایت', 'حمایت از سایت','manage_options','irdonate_main','irdonate_main_function');
    $main_sub=  add_submenu_page('irdonate_main','پرداخت ها','پرداخت ها', 'manage_options','irdonate_main');
    $setting=add_submenu_page('irdonate_main','تنظیمات','تنظیمات', 'manage_options','irdonate_setting','irdonate_settilng_page');

}