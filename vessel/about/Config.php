<?php
/**
 * @name        xenice options
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-09-26
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace vessel\about;

use vessel\Options;

class Config extends Options
{
    protected $key = 'yy_about';
    protected $name = ''; // Database option name
    protected $defaults = [];
    
    public function __construct(){
        add_filter('xenice_options_button', [$this,'hideButton'], 10, 2);
        $this->name = 'xenice_' . $this->key;
        $this->defaults[] = [
            'id'=>'about',
            'name'=> esc_html__('About the theme', 'onenice'),
            'title'=> esc_html__('About the theme', 'onenice'),
            'desc'=> sprintf(__('Thanks for using the <a href="%s" target="_blank">%s</a> theme.', 'onenice'), THEME_URI, THEME_NAME),
            'fields'=>[
                [
                    'id' => 'about_version',
                    'type'  => 'label',
                    'name'  => esc_html__('Version', 'onenice'),
                    'value' => THEME_VER,
                ],
                [
                    'id' => 'about_official_website',
                    'type'  => 'label',
                    'name'  => esc_html__('Official website', 'onenice'),
                    'value' => sprintf('<a href="%s" target="_blank">%s</a>', AUTHOR_URI, AUTHOR_URI),
                ],
            ],
        ];
	    parent::__construct();
    }

    public function hideButton($buttons, $id){
        return ($id == 'about')?'':$buttons;
    }
}