<?php
namespace vessel\optimize\includes;

use function vessel\optimize_get as get;

class GlobalOptimize
{
    public function __construct()
    {
        // wordpress
        get('enable_classic_editor') && add_filter('use_block_editor_for_post', '__return_false');
        if(get('enable_classic_widget')){
            add_filter( 'gutenberg_use_widgets_block_editor', '__return_false' );
            add_filter( 'use_widgets_block_editor', '__return_false' );
        }
        get('disable_pingback') && $this->disablePingback();
        get('disable_emoji') && $this->disableEmoji();
        get('disable_default_rest_api') && remove_action( 'rest_api_init', 'create_initial_rest_routes', 99 );
        get('disable_open_sans') && add_action( 'init', [$this, 'disableOpenSans']);
        get('disable_widgets') && add_action('widgets_init', [$this, 'disableWidgets']);
        
        // xenice
        get('enable_avatar_acc') && add_filter('get_avatar_url', [$this,'getAvatarUrl']);
        get('remove_category_pre') && new NoCategory;
        get('remove_child_categories') && add_filter( 'post_link_category', [$this,'removeChildCategories']);
    }
    
    /**
	 * disable Pingback
	 */
	private function disablePingback()
	{
		//close pingback
		add_filter('xmlrpc_methods',function($methods){
			$methods['pingback.ping'] = '__return_false';
			$methods['pingback.extensions.getPingbacks'] = '__return_false';
			return $methods;
		});

		//disable pingbacks, enclosures, trackbacks 
		remove_action( 'do_pings', 'do_all_pings', 10 );

		//remove _encloseme 和 do_ping 操作。
		remove_action( 'publish_post','_publish_post_hook',5 );
	}
	
	private function disableEmoji()
	{
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script');
		remove_action( 'admin_print_styles',  'print_emoji_styles');

		remove_action( 'wp_head',       'print_emoji_detection_script', 7);
		remove_action( 'wp_print_styles',   'print_emoji_styles');

		remove_action('embed_head',       'print_emoji_detection_script');

		remove_filter( 'the_content_feed',    'wp_staticize_emoji');
		remove_filter( 'comment_text_rss',    'wp_staticize_emoji');
		remove_filter( 'wp_mail',       'wp_staticize_emoji_for_email');

		add_filter( 'tiny_mce_plugins', function ($plugins){ return array_diff( $plugins, array('wpemoji') ); });

		add_filter( 'emoji_svg_url', '__return_false' );

	}
	
	public function disableOpenSans() {
		wp_deregister_style( 'open-sans' );
		wp_register_style( 'open-sans', false );
		wp_enqueue_style('open-sans', '');
	}
	
	// 替换Gavatar头像地址
    public function getAvatarUrl($url){
        $pos = strpos($url,'/avatar/');
        if($pos>0){
            $new_url = 'https://gravatar.wp-china-yes.net';
            $slug = substr($url, $pos);
            return $new_url . $slug;
        }
        return $url;
    }
	
	public function disableWidgets()
	{
		unregister_widget ('WP_Widget_Search');
		unregister_widget ('WP_Nav_Menu_Widget');
		unregister_widget ( 'WP_Widget_Calendar' );
		unregister_widget ( 'WP_Widget_Pages' );
		unregister_widget ( 'WP_Widget_Archives' );
		unregister_widget ( 'WP_Widget_Links' );
		unregister_widget ( 'WP_Widget_Meta' );
		unregister_widget ( 'WP_Widget_Text' );
		unregister_widget ( 'WP_Widget_Categories' );
		unregister_widget ( 'WP_Widget_Recent_Posts' );
		unregister_widget ( 'WP_Widget_Recent_Comments' );
		unregister_widget ( 'WP_Widget_RSS' );
		unregister_widget ( 'WP_Widget_Tag_Cloud' );
		unregister_widget ( 'WP_Widget_Media_Audio' );
		unregister_widget ( 'WP_Widget_Media_Video' );
		unregister_widget ( 'WP_Widget_Media_Image' );
		unregister_widget ( 'WP_Widget_Media_Gallery' );
		unregister_widget ( 'WP_Widget_Custom_HTML' );
	}

    public function removeChildCategories( $category )
    {
		while ( $category->parent ) {
			$category = get_term( $category->parent, 'category' );
		}
		return $category;
	}
}