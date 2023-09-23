<?php
/**
 * @name        xenice options
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-09-26
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace vessel\mail;

use vessel\Options;

class Config extends Options
{
    protected $key = 'yy_mail';
    protected $name = ''; // Database option name
    protected $defaults = [];
    
    public function __construct()
    {
        $this->name = 'xenice_' . $this->key;
        $this->defaults[] = [
            'id'=>'mail',
            //'pos'=>100,
            'name'=> esc_html__('Mail Settings', 'onenice'),
            'title'=> esc_html__('Mail Settings', 'onenice'),
            'tabs' => [
                [
                    'id' => 'setting',
                    'title' => esc_html__('Mail Settings', 'onenice'),
                    'fields'=>[
                        [
                            'id'   => 'enable_smtp_server',
                            'name' => esc_html__('SMTP email server', 'onenice'),
                            'label' => esc_html__('Enable SMTP email server', 'onenice'),
                            'type'  => 'checkbox',
                            'value' => false
                        ],
                        [
                            'id'   => 'mail_from_name',
                            'name' => esc_html__('From Name', 'onenice'),
                            'type'  => 'text',
                            'value' => ''
                        ],
                        [
                            'id'   => 'mail_host',
                            'name' => esc_html__('SMTP Host', 'onenice'),
                            'type'  => 'text',
                            'value' => ''
                        ],
                        [
                            'id'   => 'mail_port',
                            'name' => esc_html__('SMTP Port', 'onenice'),
                            'type'  => 'number',
                            'value' => 465
                        ],
                        [
                            'id'   => 'mail_username',
                            'name' => esc_html__('Mail Account', 'onenice'),
                            'type'  => 'text',
                            'value' => ''
                        ],
                        [
                            'id'   => 'mail_password',
                            'name' => esc_html__('Mail Password', 'onenice'),
                            'type'  => 'text',
                            'value' => ''
                        ],
                        [
                            'id'   => 'mail_smtp_auth',
                            'name' => esc_html__('SMTP Auth', 'onenice'),
                            'label' => esc_html__('Enable SMTP Auth service', 'onenice'),
                            'type'  => 'checkbox',
                            'value' => true
                        ],
                        [
                            'id'   => 'mail_smtp_secure',
                            'name' => esc_html__('SMTP Secure', 'onenice'),
                            'desc' => esc_html__('Fill in ssl if SMTP Auth service is enabled, leave blank if not','onenice'),
                            'type'  => 'text',
                            'value' => 'ssl'
                        ],
                    ]
                ],
                [
                    'id' => 'send',
                    'title' => esc_html__('Send Mail', 'onenice'),
                    'submit'=> esc_html__('Send', 'onenice'),
                    'fields'=>[
                        [
                            'id'   => 'mail_title',
                            'name' => esc_html__('Mail Title', 'onenice'),
                            'type'  => 'text',
                            'value' => ''
                        ],
                        [
                            'id'   => 'mail_content',
                            'name' => esc_html__('Mail Content', 'onenice'),
                            'type'  => 'textarea',
                            'value' => '',
                            'style' => 'regular',
                            'rows' => 10
                        ],
                    ]
                ]
            ]
        ];
	    parent::__construct();
    }


}