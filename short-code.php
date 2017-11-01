<?php
namespace dondon;

require_once('create-menu.php');
require_once('send-auth.php');

class AddLoginShortCode {
    
    const SendBtnName = "AuthSendBtnName";
    const AuthFormName = "AuthFormName";
    
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
        if(isset($_POST[self::AuthFormName])){
            $param = LoginMenuController::get_config_param();
            $free_url = $param->FreePage;
            header("Location: $free_url");
            exit;
        }
    }

    public static function add_shortcode() {
        add_shortcode( 'login_form', 'dondon\AddLoginShortCode::login_form_code');
    }
    
    public static function login_form_code( $atts, $content='' ) {
        ?>
<form methid='post' name = '<?php echo self::AuthFormName; ?>'>
    <button type="submit" name='<?php echo self::SendBtnName; ?>'><?php echo $content; ?></button>
</form>        
        <?php
    }

    
}



?>