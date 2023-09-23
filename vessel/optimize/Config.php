<?php
/**
 * @name        xenice options
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-09-26
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace vessel\optimize;

use vessel\Options;

class Config extends Options
{
    protected $key = 'yy_optimize';
    protected $name = ''; // Database option name
    protected $defaults = [];
    
    public function __construct()
    {
        $this->name = 'xenice_' . $this->key;
        $this->defaults[] = [
            'id'=>'optimize',
            //'pos'=>100,
            'name'=> esc_html__('Theme optimization', 'onenice'),
            'title'=> esc_html__('Theme optimization', 'onenice'),
            'tabs' => [
                [
                    'id' => 'general',
                    'title' => esc_html__('General', 'onenice'),
                    'fields'=>[
                        [
                            'name' => esc_html__('Global optimization', 'onenice'),
                            'fields'=>[
                                [
                                    'id'   => 'enable_classic_editor',
                                    'type'  => 'checkbox',
                                    'value' => true,
                                    'label'  => esc_html__('Enable classic editor', 'onenice')
                                ],
                                [
                                    'id'   => 'enable_classic_widget',
                                    'type'  => 'checkbox',
                                    'value' => true,
                                    'label'  => esc_html__('Enable classic widget', 'onenice')
                                ],
                                [
                                    'id'   => 'disable_widgets',
                                    'type'  => 'checkbox',
                                    'value' => false,
                                    'label'  => esc_html__('Disable all built-in widgets', 'onenice')
                                ],
                                [
                                    'id'   => 'disable_pingback',
                                    'type'  => 'checkbox',
                                    'value' => false,
                                    'label'  => esc_html__('Disable pingback', 'onenice')
                                ],
                                [
                                    'id'   => 'disable_emoji',
                                    'type'  => 'checkbox',
                                    'value' => false,
                                    'label'  => esc_html__('Disable emoji', 'onenice')
                                ],
                                [
                                    'id'   => 'disable_default_rest_api',
                                    'type'  => 'checkbox',
                                    'value' => false,
                                    'label'  => esc_html__('Disable default restapi', 'onenice')
                                ],
                                [
                                    'id'   => 'disable_open_sans',
                                    'type'  => 'checkbox',
                                    'value' => false,
                                    'label'  => esc_html__('Disable opensans', 'onenice')
                                ],
                                [
                                    'id'   => 'remove_category_pre',
                                    'type'  => 'checkbox',
                                    'value' => false,
                                    'label'  => esc_html__('Remove the category link prefix', 'onenice')
                                ],
                                [
                                    'id'   => 'remove_child_categories',
                                    'type'  => 'checkbox',
                                    'value' => false,
                                    'label'  => esc_html__('Remove the article link subcategory, leaving only the parent category', 'onenice')
                                ],
                                [
                                    'id'   => 'enable_avatar_acc',
                                    'type'  => 'checkbox',
                                    'value' => true,
                                    'label'  => esc_html__('Enable gravatar acceleration', 'onenice')
                                ],
                            ]
                        ],
                        [
                            'name' => esc_html__('Back-end optimization', 'onenice'),
                            'fields'=>[
                                [
                                    'id'   => 'disable_post_revision',
                                    'type'  => 'checkbox',
                                    'value' => true,
                                    'label'  => esc_html__('Disable revision', 'onenice')
                                ],
                                [
                                    'id'   => 'enable_empty_email_save',
                                    'type'  => 'checkbox',
                                    'value' => false,
                                    'label'  => esc_html__('Profile can also be saved when user email is empty', 'onenice')
                                ],
                                [
                                    'id'   => 'remove_w_icon',
                                    'type'  => 'checkbox',
                                    'value' => false,
                                    'label'  => esc_html__('Remove backstage at the top of the W icon in the upper left corner', 'onenice')
                                ],
                                [
                                    'id'   => 'disable_update_remind',
                                    'type'  => 'checkbox',
                                    'value' => false,
                                    'label'  => esc_html__('Disable update reminders', 'onenice')
                                ],
                                [
                                    'id'   => 'enable_link',
                                    'type'  => 'checkbox',
                                    'value' => false,
                                    'label'  => esc_html__('Enable link', 'onenice')
                                ],
                                [
                                    'id'   => 'enable_code_escape',
                                    'type'  => 'checkbox',
                                    'value' => false,
                                    'label'  => esc_html__('Convert the html within the code tag to entity before saving posts', 'onenice')
                                ],
                                [
                                    'id'   => 'remove_image_attribute',
                                    'type'  => 'checkbox',
                                    'value' => true,
                                    'label'  => esc_html__('Remove image attributes while editing posts', 'onenice')
                                ],
                                [
                                    'id'   => 'extend_class_editor_buttons',
                                    'type'  => 'checkbox',
                                    'value' => false,
                                    'label'  => esc_html__('Extend the classic editor buttons', 'onenice')
                                ],
                            ]
                        ],
                                                [
                            'name' => __('Front-end optimization', 'onenice'),
                            'fields'=>[
                                [
                                    'id'   => 'disable_admin_bar',
                                    'type'  => 'checkbox',
                                    'value' => true,
                                    'label'  => esc_html__('Disable the front admin bar', 'onenice')
                                ],
                            ]
                        ],
                    ] // #fileds
                ], // tab
                
                [
                    'id' => 'advanced',
                    'title' => esc_html__('Advanced', 'onenice'),
                    'fields'=>[
                        [
                            'id'   => 'disable_all_comments',
                            'name' => esc_html__('Comments', 'onenice'),
                            'label' => esc_html__('Disable all comments', 'onenice'),
                            'type'  => 'checkbox',
                            'value' => false,
                        ],
                        [
                            'id'   => 'enable_post_unique_slug',
                            'name' => esc_html__('Auto create post slug', 'onenice'),
                            'label'  => esc_html__('Create a unique slug the first time you save the article', 'onenice'),
                            'type'  => 'checkbox',
                            'value' => false
                        ],
                        [
                            'id'   => 'posts_link_prefix',
                            'name' => esc_html__('Posts link prefix', 'onenice'),
                            'type'  => 'text',
                            'value' => '',
                        ],
                        
                    ]
                ]
            ]
            
            
        ];
	    parent::__construct();
    }


}