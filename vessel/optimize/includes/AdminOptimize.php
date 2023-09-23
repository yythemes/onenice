<?php
namespace vessel\optimize\includes;

use function vessel\optimize_get as get;

class AdminOptimize
{
    public function __construct()
    {
        //Hide the Upgrade Notice to Recent Versions
        get('disable_update_remind') && add_filter( 'pre_site_transient_update_core', create_function( '$a', "return null;" ) );
		get('disable_post_revision') && remove_action('post_updated','wp_save_post_revision' );
		get('enable_empty_email_save') && add_action('user_profile_update_errors',[$this,'enableEmptyEmailSave'],10,3);
		get('remove_w_icon') && add_action('wp_before_admin_bar_render',[$this,'removeWIcon']);
		get('enable_link') && add_filter( 'pre_option_link_manager_enabled', '__return_true' );
		get('enable_code_escape') && add_filter( 'content_save_pre', [$this, 'replaceCodeTags'], 9 );
		if(get('remove_image_attribute')){
    		add_filter( 'post_thumbnail_html', [$this, 'removeImageAttribute'], 10 );
            add_filter( 'image_send_to_editor', [$this, 'removeImageAttribute'], 10 );
		}
		get('extend_class_editor_buttons') && add_action('after_wp_tiny_mce', [$this, 'tinyMceButtons']);
    }

	public function enableEmptyEmailSave($errors, $update, $user)
	{
	    if(isset($errors->errors['empty_email'])){
            unset($errors->errors['empty_email']);
            unset($errors->errors['empty_data']);
        }
	    
	}
	
	public function removeWIcon()
	{
        global $wp_admin_bar;
        $wp_admin_bar->remove_menu('wp-logo');
    }

    public function escapeCode($arr)
    {
    	$output = htmlspecialchars($arr[2], ENT_NOQUOTES, get_bloginfo('charset'), false); 
    	if (! empty($output)) {
    		return  $arr[1] . $output . $arr[3];
    	}
    	else
    	{
    		return  $arr[1] . $arr[2] . $arr[3];
    	}
    	
    }
    
    public function replaceCodeTags($data)
    {
    	$data = preg_replace_callback('@(<code.*>)(.*)(</code>)@isU', [$this,'escapeCode'], $data);
    	return $data;
    }
    
    public function removeImageAttribute( $html ) {
    	$html = preg_replace('/<img.+(src="?[^"]+"?)[^\/]+\/>/i',"<img \${1} />",$html);
    	return $html;
    }
    
    public function tinyMceButtons(){
        ?>
        <script>
            QTags.addButton( 'h4', 'h4', "<h4>", "</h4>");
            QTags.addButton( 'strong', 'strong', "<strong>", "</strong>");
        </script>
        <?php
    }
    
}