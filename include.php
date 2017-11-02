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

function send_auth_request($login_id, $login_pass, $end_point, $license_code= "")
{
	$path=$end_point;
	$lid='';

	$val = array(
		new \xmlrpcval($login_id, 'string'),
		new \xmlrpcval($login_pass, 'string'),
		new \xmlrpcval($path, 'string'),
		new \xmlrpcval($lid, 'string')
	);
	
	//$msg = new XML_RPC_Message('login_check', $val);
	$xmlrpc_message = new \xmlrpcmsg("login_check", $val);

	//$cli = new XML_RPC_Client('/vd/admin/login_check2.php', 'www.exsample.com');
	$client=new \xmlrpc_client("dl/admin/login_check2.php", "tpl-zanmai.com", 80);

	//$resp = $cli->send($msg);
	$resp = $client->send($xmlrpc_message, 20);
	
	var_dump($resp->serialize());

	$fault_code = $resp->faultCode();
}

LoginMenuController::setup_menu();

AddLoginShortCode::add_shortcode();

send_auth_request("nak@msc123.net", "h5W5378N", $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']);

//add_shortcode('view_menu', 'ui\YoyakuManageConroll');

//プラグイン側から特定のURLでアクセスできるように設定を追加
add_action( 'template_redirect', 'dondon\AddLoginShortCode::input_check' );

?>