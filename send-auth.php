<?php
namespace dondon;

include("xmlrpc/lib/xmlrpc.inc");
include("xmlrpc/lib/xmlrpcs.inc");

class Response
{
    public $err_id;
    public $status;
    public $err_mes; 
    public $agent_id; 
}

class SendAuth
{
    public $login_id;
    public $login_pass;
    public $end_point;

    public $server_url;
    public $dir;
    public $response;

    public function __construct()
    {
        $this->response = new Response();
    }

    public function is_free_page()
    {
        return $this->$this->response->status = "0";
    }

    public function is_authenticated()
    {
        return  $this->response->err_id == "0";
    }

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
        
        $val = $resp->value();
        
        $val->structreset();

        $resp_list = [];

        while (list($key, $v) = $val->structEach())
        {
            $resp_list[$key] = $v->serialize();
        }

        if(!$resp->faultCode()){
            $this->response->err_id = $resp_list["err_id"];
            $this->response->status = $resp_list["status"];
            $this->response->err_mes = $resp_list["err_mes"];
            $this->response->agent_id = $resp_list["agent_id"];
           // exit;
        }
    }
    
}

?>