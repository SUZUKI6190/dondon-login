<?php
/*
Plugin Name:DonDonLogion
Plugin URI: 
Description: 
Author: Takashi Suzuki
Version: 1.0
Author URI:
*/
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

//require_once(dirname(__FILE__).'/ui/controller.php');
include("xmlrpc/lib/xmlrpc.inc");
include("xmlrpc/lib/xmlrpcs.inc");
require_once('create-menu.php');

function send_auth_request($login_id, $login_pass, $end_point, $license_code= "")
{
	$path=$end_point;
	$lid='';

	$val = array(
		new xmlrpcval($login_id, 'string'),
		new xmlrpcval($login_pass, 'string'),
		new xmlrpcval($path, 'string'),
		new xmlrpcval($lid, 'string')
	);
	
	//$msg = new XML_RPC_Message('login_check', $val);
	$xmlrpc_message = new xmlrpcmsg("login_check", $val);

	//$cli = new XML_RPC_Client('/vd/admin/login_check2.php', 'www.exsample.com');
	$client=new xmlrpc_client("dl/admin/login_check2.php", "tpl-zanmai.com", 80);

	//$resp = $cli->send($msg);
	$resp = $client->send($xmlrpc_message, 20);
	
	var_dump($resp->serialize());

	$fault_code = $resp->faultCode();
}

add_action( 'admin_menu', 'register_my_custom_menu_page' );

function register_my_custom_menu_page(){
	add_menu_page( 'custom menu title', 'custom menu', 'manage_options', 'custompage', 'my_custom_menu_page', plugins_url( 'myplugin/images/icon.png' ), 6 ); 
}

function my_custom_menu_page(){
	echo "Admin Page Test";	
}

PluginController::run();

//send_auth_request("nak@msc123.net", "h5W5378N", $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'])

//add_shortcode('view_menu', 'ui\YoyakuManageConroll');

?>