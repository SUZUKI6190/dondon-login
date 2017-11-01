<?php
namespace dondon;

class ConfigParam
{
    public $PaidPage;
    public $FreePage;
    public $UserId;
    public $PassWord;
    public $ServerUrl;
    public $ServerDir;
}

class LoginMenuController
{
    private function __construct(){}
    const SettingGroup = "DonDonLoginGroup";
    const PaidPage = 'PaidPageName';
    const FreePage = 'FreePageName';
    const UserId = 'UserIdName';
    const PassWord = 'PassWordName';
    const ServerUrl = 'ServerUrlName';
    const ServerDir = 'ServerDirName';

    public static function get_config_param()
    {
        $ret = new ConfigParam();
        $ret->PaidPage = self::get_option_inner(self::PaidPage);
        $ret->FreePage = self::get_option_inner(self::FreePage);
        $ret->UserId = self::get_option_inner(self::UserId);
        $ret->PassWord = self::get_option_inner(self::PassWord);
        $ret->ServerUrl = self::get_option_inner(self::ServerUrl);
        $ret->ServerDir = self::get_option_inner(self::ServerDir);

        return $ret;
    }

    private static function get_option_inner($opname)
    {
        return get_option($opname);
    }

    /** ステップ1 */
    public static function my_plugin_menu() {
        add_options_page( 'My Plugin Options', 'My Plugin', 'manage_options', 'my-unique-identifier', 'dondon\LoginMenuController::my_plugin_options' );
    }
    
    /** ステップ3 */
    public static function my_plugin_options() {
        if ( !current_user_can( 'manage_options' ) )  {
            wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
        }
        echo '<div class="wrap">';
        echo '<p>オプション用のフォームをここに表示する。</p>';
        echo '</div>';
    }

    //管理画面にメニューを追加
    public static function add_pages(){
        add_menu_page('ログイン設定管理', 'ログイン設定管理', 'level_8', __FILE__, 'dondon\LoginMenuController::view_setup', 'dashicons-upload',26);
    }
    
   //プラグインの表示
    public static function view_setup(){
?>
<form method="post" action="options.php">
<?php 
settings_fields(self::SettingGroup);
do_settings_sections(self::SettingGroup);
?>
<?php submit_button(); ?>
    <div class='input_line'>
        <span>有料会員ページURL:<span>
        <input type='text' name='<?php echo self::PaidPage; ?>' value='<?php echo get_option(self::PaidPage); ?>'>
    </div>
    <div class='input_line'>
        <span>無料会員ページURL:<span>
        <input type='text' name='<?php echo self::FreePage; ?>' value='<?php echo get_option(self::FreePage); ?>'>
    </div>
    <div class='input_line'>
        <span>ユーザーID:<span>
        <input type='text' name='<?php echo self::UserId; ?>' value='<?php echo get_option(self::UserId); ?>'>
    </div>
    <div class='input_line'>
        <span>パスワード:<span>
        <input type='text' name='<?php echo self::PassWord; ?>' value='<?php echo get_option(self::PassWord); ?>'>
    </div>
    <div class='input_line'>
        <span>サーバーURL:<span>
        <input type='text' name='<?php echo self::ServerUrl; ?>' value='<?php echo get_option(self::ServerUrl); ?>'>
    </div>
    <div class='input_line'>
        <span>サーバー内ディレクトリ:<span>
        <input type='text' name='<?php echo self::ServerDir; ?>' value='<?php echo get_option(self::ServerDir); ?>'>
    </div>
</form>

<?php
    }

    public static function register_settings() {
        register_setting( self::SettingGroup , self::PaidPage );
        register_setting( self::SettingGroup , self::FreePage );
        register_setting( self::SettingGroup , self::UserId );
        register_setting( self::SettingGroup , self::PassWord );
        register_setting( self::SettingGroup , self::ServerUrl );
        register_setting( self::SettingGroup , self::ServerDir );
    }

    public static function run()
    {
        add_action('admin_init', 'dondon\LoginMenuController::register_settings' );
    
        /** 上のテキストのステップ2 */
        add_action('admin_menu', 'dondon\LoginMenuController::my_plugin_menu' );
     
        // 管理メニューに追加するフック
        add_action('admin_menu', 'dondon\LoginMenuController::add_pages');

    }
}


?>