<?php

/*
Plugin Name: Iran-Donate
Plugin URI: http://vipers.me
Description: پلاگین حمایت از سایت با درگاه های فراگیت و زرین پال
Version: 1.0.4
Author: Mehrnoosh Shabani
Author URI: http://vipers.me
*/

define('IRDONATE_DB_VERIZON',1 );

defined ('ABSPATH') || exit('No Direct Access.');

define('IRDONATE_DIR',  plugin_dir_path(__FILE__));

define('IRDONATE_URL', plugin_dir_url(__FILE__));

define('IRDONATE_CSS_URL',  trailingslashit(IRDONATE_URL.'assets/css'));

define('IRDONATE_JS_URL',  trailingslashit(IRDONATE_URL.'assets/js'));

define('IRDONATE_IMG_URL',  trailingslashit(IRDONATE_URL.'assets/mg'));

define('IRDONATE_INC_DIR',  trailingslashit(IRDONATE_DIR.'include'));

define('IRDONATE_ADMIN_DIR',  trailingslashit(IRDONATE_DIR.'admin'));

define('IRDONATE_TPL_DIR',  trailingslashit(IRDONATE_DIR.'tamplate'));

register_activation_hook(__FILE__,'irdonate_activation' );
register_deactivation_hook(__FILE__,'irdonate_deactivation' );


include IRDONATE_INC_DIR.'shortcodes.php';

include IRDONATE_INC_DIR.'frontend.php';

include IRDONATE_INC_DIR.'widgets.php';

if(is_admin()){

    require IRDONATE_ADMIN_DIR.'page.php';
    
    require IRDONATE_ADMIN_DIR.'menu.php';

    include IRDONATE_INC_DIR.'backend.php';
    
}

function irdonate_activation(){

    $current_db_verizon=get_option('irdonate_db_verizon');

    if (IRDONATE_DB_VERIZON>intval($current_db_verizon)){

        require IRDONATE_INC_DIR.'upgarade.php';
        update_option('irdonate_db_verizon',IRDONATE_DB_VERIZON );

    }

}
function irdonate_deactivation(){



}
