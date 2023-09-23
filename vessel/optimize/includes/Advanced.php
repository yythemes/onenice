<?php
namespace vessel\optimize\includes;

use function vessel\optimize_get as get;

class Advanced
{
    public function __construct()
    {
        if(is_admin()){
            get('enable_post_unique_slug') && add_filter( 'wp_unique_post_slug', [$this, 'createUniqueSlug'], 10, 6 );
        }
        add_filter( 'post_link', [$this, 'postLink'], 999, 3);
        get('disable_all_comments') && add_filter( 'comments_open', [$this, 'disableComments'], 10, 2 );
        //new ShowUserIP;
    }
    
    public function postLink($permalink, $post, $leavename)
    {
        $prefix = get('posts_link_prefix');
        if($prefix){
            $prefix = '/' . trim($prefix, '/') . '/';
            return home_url($prefix . $post->post_name);
        }
        return $permalink;
    }
    
    public function createUniqueSlug( $slug, $post_ID, $post_status, $post_type, $post_parent, $original_slug )
    {
        // if this is revision
		if (wp_is_post_revision($post_ID)){
			return;
		}
		
        $real_status = get_post_status($post_ID); 
        if (in_array($post_type, ['post']) && in_array( $real_status, ['draft', 'pending', 'auto-draft'])) {
            return $this->cid();
        } else {
            return $slug;
        }
    }
    
    // Create a unique ID
	public function cid()
	{
		usleep(1); // Pause for a microsecond
		list($usec, $sec) = explode(" ", microtime());
		return $this->noTots(((float)$usec)*1000000 + ((float)$sec)*1000000);
	}

	// Change from 10 to 36
	public function noTots($no)
	{	
		$char_array=array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9",
		"a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", 
		"n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
		$ret = '';
		while($no >= 36) {
			$ret = $char_array[fmod($no, 36)].$ret;
			$no = floor($no/36);
		}
		return $char_array[$no].$ret;
	}
	
	public function disableComments( $open, $post_id ) 
	{
    	return false;
    }

}