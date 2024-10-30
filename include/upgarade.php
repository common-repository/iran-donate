<?php

global $wpdb,$table_prefix;

$table_name=$table_prefix.'irdonate_payments';


$irdonate_sql="CREATE TABLE IF NOT EXISTS `$table_name` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `bank` varchar(50) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `mobile` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `amount` bigint(20) NOT NULL,
  `order_id` varchar(100) NOT NULL,
  `ref_id` varchar(100) NOT NULL,
  `date` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";


require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

dbDelta($irdonate_sql);


