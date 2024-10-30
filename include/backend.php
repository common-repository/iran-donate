<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function irdonate_get_status($stat){

    $result='نا مشخص';

    switch ($stat){


        case 0;

            $result='نا موفق';

            break;
        case 1;

            $result='موفق';

            break;
        default;

            $result='نا مشخص';
            break;

    }

    return $result;

}