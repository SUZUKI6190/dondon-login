<?php
namespace dondon;

require_once('create-menu.php');
require_once('send-auth.php');

class AddLoginShortCode {   
    const SendBtnName = "AuthSendBtnName";
   
    public static function send_request()
    {
        $param = LoginMenuController::get_config_param();
        $auth = new SendAuth();

        $auth->login_id = $param->UserId;
        $auth->login_pass = $param->PassWord;
        $auth->end_point = $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'];
        $auth->server_url = $param->ServerUrl;

        $auth->send_request();
    }

    public static function input_check()
    {
        if(isset($_POST[self::SendBtnName])){
            $param = LoginMenuController::get_config_param();
            
            $auth = new SendAuth();           
            $auth->login_id = $param->UserId;
            $auth->login_pass = $param->PassWord;
            $auth->end_point = $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'];
            $auth->server_url = $param->ServerUrl;
            $auth->dir = $param->ServerDir;
            $auth->send_request();
            if($auth->is_authenticated()){
                $next_url;
                if($auth->is_free_page()){
                    $next_url= $param->FreePage;
                }else{
                    $next_url= $param->FreePage;
                }
                header("Location: $next_url");
            }else{
                
            }
        }
    }

    public static function add_shortcode() {
        add_shortcode( 'login_form', 'dondon\AddLoginShortCode::login_form_code');
    }
    
    public static function login_form_code( $atts, $content='' ) {
        ?>
<form method="post">
    <button type="submit" name='<?php echo self::SendBtnName; ?>'><?php echo $content; ?></button>
</form>        
        <?php
    }

    
}



?>