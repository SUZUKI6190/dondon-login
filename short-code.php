<?php
require_once('create-menu.php');
require_once('send-auth.php');

class AddLoginShortCode {
    
    public static function input_check()
    {
        $param = PluginController::get_config_param();
        $auth = new SendAuth();

        $auth->login_id = $param->UserId;
        $auth->login_pass = $param->PassWord;
        $auth->end_point = $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'];
        $auth->server_url = $param->ServerUrl;
    }

    public static function add_shortcode() {
        add_shortcode( 'login_form', 'AddLoginShortCode::login_form_code');
    }
    
    public static function login_form_code( $atts, $content='' ) {
        ?>
<form methid='post'>
    <button type="submit"><?php echo $content; ?></button>
</form>        
        <?php
    }
}



?>