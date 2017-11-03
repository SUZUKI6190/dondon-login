<?php
/*
Plugin Name:DonDonLogion
Plugin URI: 
Description: 
Author: Takashi Suzuki
Version: 1.0
Author URI:
*/
namespace dondon;

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

//require_once(dirname(__FILE__).'/ui/controller.php');

require_once('create-menu.php');
require_once('short-code.php');

LoginMenuController::setup_menu();

AddLoginShortCode::add_shortcode();

//プラグイン側から特定のURLでアクセスできるように設定を追加
add_action( 'template_redirect', 'dondon\AddLoginShortCode::input_check' );

?>