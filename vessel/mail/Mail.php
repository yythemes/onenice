<?php

namespace vessel\mail;

use function vessel\mail_get as get;

class Mail{

    /**
	 * Constructor
	 */
	public function __construct(){
	    if(is_admin()){
	       if(get('enable_smtp_server')){
               add_action('phpmailer_init', function($phpmailer){
                    $mail_name = get('mail_from_name')?:'YYThemes';
                	$mail_host = get('mail_host')?:'smtp.qq.com';
                	$mail_port = get('mail_port')?: '465';
                	$mail_smtpsecure = get('mail_smtp_secure');
                    $phpmailer->IsSMTP();
                	$phpmailer->FromName = $mail_name; 
                	$phpmailer->Host = $mail_host;
                	$phpmailer->Port = $mail_port;
                	$phpmailer->Username = get('mail_username');
                	$phpmailer->Password = get('mail_password');
                	$phpmailer->From = get('mail_username');
                	$phpmailer->SMTPAuth = get('mail_smtp_auth');
                	$phpmailer->SMTPSecure = $mail_smtpsecure ?: 'ssl';
                    
                });
	        }
	        
	        add_filter('wp_mail_from_name', function ($old){
	            $mail_name = get('mail_from_name')?:'YYThemes';
	            return $mail_name;
	            
	        });
            
            add_action('wp_mail_failed', function ($error){
                $msg = $error->get_error_message();
                if($msg){
                    update_option('xenice_yy_mail_error', '<br/>' . $error->get_error_message());
                }
                
            });
            
            // change send action results
            add_filter('xenice_yy_mail_options_save', function($key, $tab, $data){
                if($key == 'mail' && $tab == 1){
                   global $current_user;
                    $bool = wp_mail($current_user->user_email, $data['mail_title']??'', $data['mail_content']??'');
                    if($bool){
                        $result = ['key'=>$key, 'return' => 'success', 'message'=>esc_html__('Send successfully', 'onenice')];
                        update_option('xenice_yy_mail_error', '');
                    }
                    else{
                        $msg = get_option('xenice_yy_mail_error', true);
                        $result = ['key'=>$key, 'return' => 'error', 'message'=>esc_html__('Send failure', 'onenice') . $msg];
                    }
                        
                    apply_filters('xenice_yy_mail_options_result', $result);
                }
                else{
                    return $key;
                }
            },10,3);
	        
	    }

	}
}