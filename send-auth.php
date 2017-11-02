<?php
namespace dondon;

include("xmlrpc/lib/xmlrpc.inc");
include("xmlrpc/lib/xmlrpcs.inc");

class Response
{

}

class SendAuth
{
    public $login_id;
    public $login_pass;
    public $end_point;

    public $server_url;
    public $dir;

    public function send_request()
    {
        $lid='';
    
        $val = array(
            new \xmlrpcval($this->login_id, 'string'),
            new \xmlrpcval($this->login_pass, 'string'),
            new \xmlrpcval($this->end_point, 'string'),
            new \xmlrpcval($lid, 'string')
        );
        
        $xmlrpc_message = new \xmlrpcmsg("login_check", $val);
    
        $dir = $this->dir."/admin/login_check2.php";

        $client=new \xmlrpc_client($dir, $this->server_url, 80);
    
        $resp = $client->send($xmlrpc_message, 20);

        var_dump($resp->value());
    
        $fault_code = $resp->faultCode();
    }
    
}

?>