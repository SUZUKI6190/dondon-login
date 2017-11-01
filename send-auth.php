<?php
namespace dondon;

include("xmlrpc/lib/xmlrpc.inc");
include("xmlrpc/lib/xmlrpcs.inc");

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
            new xmlrpcval($this->login_id, 'string'),
            new xmlrpcval($this->login_pass, 'string'),
            new xmlrpcval($this->end_point, 'string'),
            new xmlrpcval($lid, 'string')
        );
        
        //$msg = new XML_RPC_Message('login_check', $val);
        $xmlrpc_message = new xmlrpcmsg("login_check", $val);
    
        $dir = $this->dir."/admin/login_check2.php";

        //$cli = new XML_RPC_Client('/vd/admin/login_check2.php', 'www.exsample.com');
        //$client=new xmlrpc_client("dl/admin/login_check2.php", "tpl-zanmai.com", 80);
        $client=new xmlrpc_client($dir, $this->sever_url, 80);
    
        //$resp = $cli->send($msg);
        $resp = $client->send($xmlrpc_message, 20);
        
        var_dump($resp->serialize());
    
        $fault_code = $resp->faultCode();
    }
    
}

?>