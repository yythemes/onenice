<?php

namespace vessel;

define( 'HOME_URL', home_url( '', empty( $_SERVER['HTTPS'] ) ? 'http' : 'https' ) );
define( 'AUTHOR_URI', wp_get_theme()->get('AuthorURI'));
define( 'THEME_URI', wp_get_theme()->get('ThemeURI'));
define( 'THEME_NAME', 'onenice' );
define( 'THEME_TITLE', 'OneNice' );
define( 'THEME_VER', wp_get_theme()->get( 'Version' ) );
define( 'THEME_DIR', get_template_directory() );
define( 'THEME_URL', get_template_directory_uri());
define( 'STATIC_DIR', THEME_DIR . '/static' );
define( 'STATIC_URL', THEME_URL . '/static' );
define( 'EXT_KEY', apply_filters('yy_ext_key', ''));
define( 'EXT_DIR', THEME_DIR . '/ext/' . EXT_KEY );
define( 'EXT_URL', THEME_URL . '/ext/' . EXT_KEY );
define( 'EXT_STATIC_DIR', EXT_DIR . '/static' );
define( 'EXT_STATIC_URL', EXT_URL . '/static' );
define( 'AJAX_URL', admin_url( 'admin-ajax.php' ) );

isset($_SESSION) || session_start();
load_theme_textdomain('onenice', THEME_DIR . '/languages/' );
spl_autoload_register('vessel\__autoload');

add_action('after_setup_theme', 'vessel\active_theme');
add_action('admin_menu', 'vessel\admin_menu');
add_filter('admin_footer_text', 'vessel\left_admin_footer_text'); 
add_filter('update_footer', 'vessel\right_admin_footer_text', 11);

get('enable_theme_widgets') && new widgets\Widgets;
get('enable_theme_login_interface') && new login\Login;
get('enable_like') && new ajax\LikeAjax;
new optimize\Optimize;
new mail\Mail;
EXT_KEY && new \ext\Ext;


/**
 * Autoload class
 *
 * @param string $classname class name.
 */
function __autoload($classname){
    $classname = str_replace('\\','/',$classname);
    $vessel = 'vessel';
    $ext = 'ext';
    if(strpos($classname, $vessel) === 0){
        $filename = str_replace($vessel, '', $classname);
        require  __DIR__ .  $filename . '.php';
    }
    elseif(strpos($classname, $ext) === 0){
        $filename = str_replace($ext, '', $classname);
        require  EXT_DIR . $filename . '.php';
    }
}

/**
 * Active theme
 * 
 */
function active_theme(){
    
    global $pagenow;
    if('themes.php' == $pagenow && isset( $_GET['activated'])){
        $config = apply_filters('yy_config', null);
        if(!$config){
            $config = new Config;
        }
        $config->active();
        (new optimize\Config)->active();
        wp_redirect( admin_url( 'admin.php?page=yythemes'));
        exit;
    }
}


/**
 * Get option
 * 
 * @param string $name option name.
 */
function get($name, $key='xenice_yy'){
    static $option = [];
    if(!$option){
        $options = get_option($key)?:[];
        foreach($options as $o){
            $option = array_merge($option, $o);
        }
    }
    return $option[$name]??'';
}

/**
 * Get optimize option
 *
 * @param string $name option name.
 */
function optimize_get($name, $key='xenice_yy_optimize'){
    static $option = [];
    if(!$option){
        $options = get_option($key)?:[];
        foreach($options as $o){
            $option = array_merge($option, $o);
        }
    }
    return $option[$name]??'';
}

/**
 * Get mail option
 *
 * @param string $name option name.
 */
function mail_get($name, $key='xenice_yy_mail'){
    static $option = [];
    if(!$option){
        $options = get_option($key)?:[];
        foreach($options as $o){
            $option = array_merge($option, $o);
        }
    }
    return $option[$name]??'';
}

/**
 * Set option
 * 
 * @param string $name option name.
 * @param string $value option value.
 */
function set($name, $value, $key='xenice_yy'){
    $options = get_option($key)?:[];
    foreach($options as $id=>&$o){
        if(isset($o[$name])){
            $o[$name] = $value;
            update_option($key, $options);
            return;
        }
    }
}


/**
 * Admin menu
 * 
 */
function admin_menu(){
    add_menu_page('YYThemes', 'YYThemes', 'manage_options', 'yythemes', '', 'dashicons-admin-customizer', 58);
    add_submenu_page('yythemes', esc_html__('Settings','onenice'), esc_html__('Settings','onenice'), 'manage_options', 'yythemes', function(){
        $config = apply_filters('yy_config', null);
        if(!$config){
            $config = new Config;
        }
        $config->show();
    });
    add_submenu_page('yythemes', esc_html__('Optimize','onenice'), esc_html__('Optimize','onenice'), 'manage_options', 'yythemes_optimize', function(){
        (new optimize\Config)->show();
    });
    add_submenu_page('yythemes', esc_html__('Mail','onenice'), esc_html__('Mail','onenice'), 'manage_options', 'yythemes_mail', function(){
        (new mail\Config)->show();
    });
    add_submenu_page('yythemes', esc_html__('About','onenice'), esc_html__('About','onenice'), 'manage_options', 'yythemes_about', function(){
        (new about\Config)->show();
    });
}


function left_admin_footer_text($text) {
    if (strpos($_SERVER['REQUEST_URI'], 'wp-admin/admin.php?page=yythemes') !== false){
	    $text = sprintf('<span id="footer-thankyou">%s</span>',__('Developed by <a href="https://www.yythemes.com/">YYThemes</a>.', 'onenice'));
    }
	return $text;
}

 
function right_admin_footer_text($text) {
    if (strpos($_SERVER['REQUEST_URI'], 'wp-admin/admin.php?page=yythemes') !== false){
	    $text = THEME_VER;
    }
	return 'v'.$text;
}