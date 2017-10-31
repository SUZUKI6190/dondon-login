<?php

class AddLoginShortCode {
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