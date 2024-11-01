<?php
/**
 * Plugin Name: Simply Slider
 * Plugin URI: http://simplyslider.com/
 * Description: Simply Slider is a responsive Slider for Wordpress
 * Author: Themewerk
 * Author URI: http://themewerk.com
 * Version: 1.0
 * License: GPLv2 
 */
 add_action('init','simplyslider_slides');
function simplyslider_slides(){
  wp_enqueue_style( 'simplyslider_styles', plugins_url('/css/simplyslider.css', __FILE__), array(), '1.0.0', 'all' );
  wp_enqueue_script( 'simplyslider_easing', plugins_url('/js/jquery.easing.1.3.js', __FILE__), array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'simplyslider', plugins_url('/js/simplyslider.js', __FILE__), array('jquery'), '1.0.0', true ); 
}
require_once dirname( __FILE__ ) . '/class.simplyslide.php';
class SimplySlide_Options_Page {
    private $simplyslide_page;
    public function __construct() {
        //create a options page
        //make sure to read the code below
        $this->simplyslide_page = new SimplySlide_Settings_Page('simplyslide_page');
        //by default,  simplyslide_page will be used as option name and you can retrieve all options by using get_option('simplyslide_page')
        //if you want use a different option_name, you can pass it to set_option_name method as below
        //$this->simplyslide_page->set_option_name('my_new_option_name');
        //now all the options for example_page will be stored in the 'my_new_option_name' option and you can get it by using get_option('my_new_option_name')
        //if you don't want to group all the fields in single option and want to store each field individually in the option table, you can set that too as below
        // if you cann use_unique_option method, all the fields will be stored in individual option(the option name will be field name ) and 
        //you can retrieve them using get_option('field_name')
       // $this->simplyslide_page->use_unique_option();
        //incase your mood changed and you want to use single option to store evrything, you can call this use_single_option method again
        //use single option is the default 
        //$this->simplyslide_page->use_single_option();
        //if it pleases you, you can set the optgroup too, if you don't set,. it is same as the page name
        //$this->simplyslide_page->set_optgroup('buddypress');
        //now, let us create an options page, what do you say
        add_action( 'admin_init', array($this, 'admin_init'));
        add_action( 'admin_menu', array($this, 'admin_menu') );
    }
    function admin_init() {
        //set the settings
        $page = $this->simplyslide_page;
        //add_section
        //you can pass section_id, section_title, section_description, the section id must be unique for this page, section descriptiopn is optional
        $page->add_section('basic_section', __( 'Simply Slider Settings' ), __('This Slider supports upto 5 Images. To show only 3 Slides in the slider, upload only 3 images, leave the rest blank. Shortcode: [simplyslider]'));
        $page->add_section('advance_section', __( 'Simply Slider Advanced Settings'),__('Some overall Advanced Settings'));

        //since option buddy allows method chaining, you can start adding field in the same line above using ad_field or add_fields to add multiple field
        //or you can add fields later to a section by calling get_section('section_id');
        //now, if we want, we can fetch a section and add some fields to it
        //I am not feeling adventurous, so I will simpley copy the example from Tareq's code
        //link https://github.com/tareq1988/wordpress-settings-api-class/blob/master/settings-api.php#L68
        //and use here
        // 
        //add fields
        $page->get_section('basic_section')->add_fields(array( //remember, we registered basic section earlier
                array(
                    'name' => 'hr1',
                    'label' => __( '<div><h2 style="color:#0074A2;">SLIDE 1</h2></div>' ),
                    'desc' => __( '' ),
                    'type' => '',//right, it will allow you to use the wp media uploader to selec an image
                ), 
                array(
                    'name' => 'text_color_1',
                    'label' => __( 'Text Color' ),
                    'desc' => __( ' Click in the Field to open Colorpicker' ),
                    'type' => 'color',//right, it will allow you to use the wp colorpicker to select the text color
                    'default' => '#FFFFFF'//and this is the default value
                ),
                array(
                    'name' => 'slider_image_1',
                    'label' => __( 'Background Image' ),
                    'desc' => __( ' First Image' ),
                    'type' => 'image',//right, it will allow you to use the wp media uploader to selec an image
                    'default' => ''//you can specify a url to existing image if you want
                ),
                array(
                    'name' => 'slider_overlay_1',
                    'label' => __( 'Background Image Overlay' ),
                    'desc' => __( ' First Image Overlay' ),
                    'type' => 'image',//right, it will allow you to use the wp media uploader to selec an image
                    'default' => ''//you can specify a url to existing image if you want
                ),
               array(
                    'name' => 'slidetitle1',
                    'label' => __( 'Text Line 1' ),//you already know it from previous example
                    'desc' => __( '' ),// this is used as the description of the field
                    'type' => 'text',
                    'default' => 'Your Text',//and this is the default value
                    'sanitize_callback' => 'intval' //right, you are learning now, This is the callback used for vaidation of the field data
                ),
                array(
                    'name' => 'headline1',
                    'label' => __( 'H1 Headline' ),//you already know it from previous example
                    'desc' => __( '' ),// this is used as the description of the field
                    'type' => 'text',
                    'default' => 'Your Text or Company Name',//and this is the default value
                    'sanitize_callback' => 'intval' //right, you are learning now, This is the callback used for vaidation of the field data
                ),
                array(
                    'name' => 'logo_image_1',
                    'label' => __( 'Logo' ),
                    'desc' => __( ' Choose an Image or Logo (if you use a Logo/Image, the Headline Text disappears)' ),
                    'type' => 'image',//right, it will allow you to use the wp media uploader to selec an image
                    'default' => ''//you can specify a url to existing image if you want
                ),
                array(
                    'name' => 'headline1b',
                    'label' => __( 'Text Line 2' ),//you already know it from previous example
                    'desc' => __( '' ),// this is used as the description of the field
                    'type' => 'text',
                    'default' => 'Your Text',//and this is the default value
                    'sanitize_callback' => 'intval' //right, you are learning now, This is the callback used for vaidation of the field data
                ),
                array(
                    'name' => 'headline1c',
                    'label' => __( 'Text Line 3' ),//you already know it from previous example
                    'desc' => __( '' ),// this is used as the description of the field
                    'type' => 'text',
                    'default' => 'Your Text',//and this is the default value
                    'sanitize_callback' => 'intval' //right, you are learning now, This is the callback used for vaidation of the field data
                ),
                array(
                    'name' => 'hr2',
                    'label' => __( '<div><h2 style="color:#0074A2;">SLIDE 2</h2></div>' ),
                    'desc' => __( '' ),
                    'type' => '',//right, it will allow you to use the wp media uploader to selec an image
                ),
                array(
                    'name' => 'text_color_2',
                    'label' => __( 'Text Color' ),
                    'desc' => __( ' Click in the Field to open Colorpicker' ),
                    'type' => 'color',//right, it will allow you to use the wp colorpicker to select the text color
                    'default' => '#FFFFFF'//and this is the default value
                ),
                array(
                    'name' => 'slider_image_2',
                    'label' => __( 'Background Image' ),
                    'desc' => __( ' Second Image' ),
                    'type' => 'image',//right, it will allow you to use the wp media uploader to selec an image
                    'default' => ''//you can specify a url to existing image if you want
                ),
                array(
                    'name' => 'slider_overlay_2',
                    'label' => __( 'Background Image Overlay' ),
                    'desc' => __( ' Second Image Overlay' ),
                    'type' => 'image',//right, it will allow you to use the wp media uploader to selec an image
                    'default' => ''//you can specify a url to existing image if you want
                ),
               array(
                    'name' => 'slidetitle2',
                    'label' => __( 'Text Line 1' ),//you already know it from previous example
                    'desc' => __( '' ),// this is used as the description of the field
                    'type' => 'text',
                    'default' => 'Your Text',//and this is the default value
                    'sanitize_callback' => 'intval' //right, you are learning now, This is the callback used for vaidation of the field data
                ),
                array(
                    'name' => 'headline2',
                    'label' => __( 'H1 Headline' ),//you already know it from previous example
                    'desc' => __( '' ),// this is used as the description of the field
                    'type' => 'text',
                    'default' => 'Your Text or Company Name',//and this is the default value
                    'sanitize_callback' => 'intval' //right, you are learning now, This is the callback used for vaidation of the field data
                ),
                array(
                    'name' => 'logo_image_2',
                    'label' => __( 'Logo' ),
                    'desc' => __( ' Choose an Image or Logo (if you use a Logo/Image, the Headline Text disappears)' ),
                    'type' => 'image',//right, it will allow you to use the wp media uploader to selec an image
                    'default' => ''//you can specify a url to existing image if you want
                ),
                array(
                    'name' => 'headline2b',
                    'label' => __( 'Text Line 2' ),//you already know it from previous example
                    'desc' => __( '' ),// this is used as the description of the field
                    'type' => 'text',
                    'default' => 'Your Text',//and this is the default value
                    'sanitize_callback' => 'intval' //right, you are learning now, This is the callback used for vaidation of the field data
                ),
                array(
                    'name' => 'headline2c',
                    'label' => __( 'Text Line 3' ),//you already know it from previous example
                    'desc' => __( '' ),// this is used as the description of the field
                    'type' => 'text',
                    'default' => 'Your Text',//and this is the default value
                    'sanitize_callback' => 'intval' //right, you are learning now, This is the callback used for vaidation of the field data
                ),
                array(
                    'name' => 'hr3',
                    'label' => __( '<div><h2 style="color:#0074A2;">SLIDE 3</h2></div>' ),
                    'desc' => __( '' ),
                    'type' => '',//right, it will allow you to use the wp media uploader to selec an image
                ),
                array(
                    'name' => 'text_color_3',
                    'label' => __( 'Text Color' ),
                    'desc' => __( ' Click in the Field to open Colorpicker' ),
                    'type' => 'color',//right, it will allow you to use the wp colorpicker to select the text color
                    'default' => '#FFFFFF'//and this is the default value
                ),
                array(
                    'name' => 'slider_image_3',
                    'label' => __( 'Background Image' ),
                    'desc' => __( ' Third Image' ),
                    'type' => 'image',//right, it will allow you to use the wp media uploader to selec an image
                    'default' => ''//you can specify a url to existing image if you want
                ),
                array(
                    'name' => 'slider_overlay_3',
                    'label' => __( 'Background Image Overlay' ),
                    'desc' => __( ' Third Image Overlay' ),
                    'type' => 'image',//right, it will allow you to use the wp media uploader to selec an image
                    'default' => ''//you can specify a url to existing image if you want
                ),
               array(
                    'name' => 'slidetitle3',
                    'label' => __( 'Text Line 1' ),//you already know it from previous example
                    'desc' => __( '' ),// this is used as the description of the field
                    'type' => 'text',
                    'default' => 'Your Text',//and this is the default value
                    'sanitize_callback' => 'intval' //right, you are learning now, This is the callback used for vaidation of the field data
                ),
                array(
                    'name' => 'headline3',
                    'label' => __( 'H1 Headline' ),//you already know it from previous example
                    'desc' => __( '' ),// this is used as the description of the field
                    'type' => 'text',
                    'default' => 'Your Text or Company Name',//and this is the default value
                    'sanitize_callback' => 'intval' //right, you are learning now, This is the callback used for vaidation of the field data
                ),
                array(
                    'name' => 'logo_image_3',
                    'label' => __( 'Logo' ),
                    'desc' => __( ' Choose an Image or Logo (if you use a Logo/Image, the Headline Text disappears)' ),
                    'type' => 'image',//right, it will allow you to use the wp media uploader to selec an image
                    'default' => ''//you can specify a url to existing image if you want
                ),
                array(
                    'name' => 'headline3b',
                    'label' => __( 'Text Line 2' ),//you already know it from previous example
                    'desc' => __( '' ),// this is used as the description of the field
                    'type' => 'text',
                    'default' => 'Your Text',//and this is the default value
                    'sanitize_callback' => 'intval' //right, you are learning now, This is the callback used for vaidation of the field data
                ),
                array(
                    'name' => 'headline3c',
                    'label' => __( 'Text Line 3' ),//you already know it from previous example
                    'desc' => __( '' ),// this is used as the description of the field
                    'type' => 'text',
                    'default' => 'Your Text',//and this is the default value
                    'sanitize_callback' => 'intval' //right, you are learning now, This is the callback used for vaidation of the field data
                ),
                array(
                    'name' => 'hr4',
                    'label' => __( '<div><h2 style="color:#0074A2;">SLIDE 4</h2></div>' ),
                    'desc' => __( '' ),
                    'type' => '',//right, it will allow you to use the wp media uploader to selec an image
                ),
                array(
                    'name' => 'text_color_4',
                    'label' => __( 'Text Color' ),
                    'desc' => __( ' Click in the Field to open Colorpicker' ),
                    'type' => 'color',//right, it will allow you to use the wp colorpicker to select the text color
                    'default' => '#FFFFFF'//and this is the default value
                ),
                array(
                    'name' => 'slider_image_4',
                    'label' => __( 'Background Image' ),
                    'desc' => __( ' Fourth Image' ),
                    'type' => 'image',//right, it will allow you to use the wp media uploader to selec an image
                    'default' => ''//you can specify a url to existing image if you want
                ),
                array(
                    'name' => 'slider_overlay_4',
                    'label' => __( 'Background Image Overlay' ),
                    'desc' => __( ' Fourth Image Overlay' ),
                    'type' => 'image',//right, it will allow you to use the wp media uploader to selec an image
                    'default' => ''//you can specify a url to existing image if you want
                ),
               array(
                    'name' => 'slidetitle4',
                    'label' => __( 'Text Line 1' ),//you already know it from previous example
                    'desc' => __( '' ),// this is used as the description of the field
                    'type' => 'text',
                    'default' => 'Your Text',//and this is the default value
                    'sanitize_callback' => 'intval' //right, you are learning now, This is the callback used for vaidation of the field data
                ),
                array(
                    'name' => 'headline4',
                    'label' => __( 'H1 Headline' ),//you already know it from previous example
                    'desc' => __( '' ),// this is used as the description of the field
                    'type' => 'text',
                    'default' => 'Your Text or Company Name',//and this is the default value
                    'sanitize_callback' => 'intval' //right, you are learning now, This is the callback used for vaidation of the field data
                ),
                array(
                    'name' => 'logo_image_4',
                    'label' => __( 'Logo' ),
                    'desc' => __( ' Choose an Image or Logo (if you use a Logo/Image, the Headline Text disappears)' ),
                    'type' => 'image',//right, it will allow you to use the wp media uploader to selec an image
                    'default' => ''//you can specify a url to existing image if you want
                ),
                array(
                    'name' => 'headline4b',
                    'label' => __( 'Text Line 2' ),//you already know it from previous example
                    'desc' => __( '' ),// this is used as the description of the field
                    'type' => 'text',
                    'default' => 'Your Text',//and this is the default value
                    'sanitize_callback' => 'intval' //right, you are learning now, This is the callback used for vaidation of the field data
                ),
                array(
                    'name' => 'headline4c',
                    'label' => __( 'Text Line 3' ),//you already know it from previous example
                    'desc' => __( '' ),// this is used as the description of the field
                    'type' => 'text',
                    'default' => 'Your Text',//and this is the default value
                    'sanitize_callback' => 'intval' //right, you are learning now, This is the callback used for vaidation of the field data
                ),
                array(
                    'name' => 'hr5',
                    'label' => __( '<div><h2 style="color:#0074A2;">SLIDE 5</h2></div>' ),
                    'desc' => __( '' ),
                    'type' => '',//right, it will allow you to use the wp media uploader to selec an image
                ),
                array(
                    'name' => 'text_color_5',
                    'label' => __( 'Text Color' ),
                    'desc' => __( ' Click in the Field to open Colorpicker' ),
                    'type' => 'color',//right, it will allow you to use the wp colorpicker to select the text color
                    'default' => '#FFFFFF'//and this is the default value
                ),
                array(
                    'name' => 'slider_image_5',
                    'label' => __( 'Background Image' ),
                    'desc' => __( ' Fifth Image' ),
                    'type' => 'image',//right, it will allow you to use the wp media uploader to selec an image
                    'default' => ''//you can specify a url to existing image if you want
                ),
                array(
                    'name' => 'slider_overlay_5',
                    'label' => __( 'Background Image Overlay' ),
                    'desc' => __( ' Fifth Image Overlay' ),
                    'type' => 'image',//right, it will allow you to use the wp media uploader to selec an image
                    'default' => ''//you can specify a url to existing image if you want
                ),
               array(
                    'name' => 'slidetitle5',
                    'label' => __( 'Text Line 1' ),//you already know it from previous example
                    'desc' => __( '' ),// this is used as the description of the field
                    'type' => 'text',
                    'default' => 'Your Text',//and this is the default value
                    'sanitize_callback' => 'intval' //right, you are learning now, This is the callback used for vaidation of the field data
                ),
                array(
                    'name' => 'headline5',
                    'label' => __( 'H1 Headline' ),//you already know it from previous example
                    'desc' => __( '' ),// this is used as the description of the field
                    'type' => 'text',
                    'default' => 'Your Text or Company Name',//and this is the default value
                    'sanitize_callback' => 'intval' //right, you are learning now, This is the callback used for vaidation of the field data
                ),
                array(
                    'name' => 'logo_image_5',
                    'label' => __( 'Logo' ),
                    'desc' => __( ' Choose an Image or Logo (if you use a Logo/Image, the Headline Text disappears)' ),
                    'type' => 'image',//right, it will allow you to use the wp media uploader to selec an image
                    'default' => ''//you can specify a url to existing image if you want
                ),
                array(
                    'name' => 'headline5b',
                    'label' => __( 'Text Line 2' ),//you already know it from previous example
                    'desc' => __( '' ),// this is used as the description of the field
                    'type' => 'text',
                    'default' => 'Your Text',//and this is the default value
                    'sanitize_callback' => 'intval' //right, you are learning now, This is the callback used for vaidation of the field data
                ),
                array(
                    'name' => 'headline5c',
                    'label' => __( 'Text Line 3' ),//you already know it from previous example
                    'desc' => __( '' ),// this is used as the description of the field
                    'type' => 'text',
                    'default' => 'Your Text',//and this is the default value
                    'sanitize_callback' => 'intval' //right, you are learning now, This is the callback used for vaidation of the field data
                ),
            ));
        //let us add some fields to the advanced section 
            $page->get_section('advance_section')->add_fields(array(
                array(
                    'name' => 'arrowdown_text',
                    'label' => __( 'Arrowdown Target Section' ),
                    'desc' => __( 'Please specify the name of the arrowdown target section (suitable for onepage sites), if you leave this field blank, the arrowdown disappears' ),
                    'type' => 'text',
                    'default' => 'about'
                ),
                array(
                    'name' => 'simplyslider_select_background',
                    'label' => __( 'Set Effect for the Background Image'),
                    'desc' => __( '' ),
                    'type' => 'select',
                    'default' => 'easeInOutBack',
                    'options' => array(
                        'easeInOutBack' => __( 'Bounce'),
                        'easeInOutSine' => __( 'Slide' ),
                        'easeInOutQuad' => __( 'Quad'),
                        'easeInOutCubic' => __( 'Cubic' ),
                        'easeInOutQuart' => __( 'Quart'),
                        'easeInOutQuint' => __( 'Quint' ),
                        'easeInOutExpo' => __( 'Expo'),
                        'easeInOutCirc' => __( 'Circ' ),
                        'easeInOutElastic' => __( 'Elastic'),
                        'easeInOutBack' => __( 'Back' )
                    )
                ),
                array(
                    'name' => 'simplyslider_select_background_overlay',
                    'label' => __( 'Set Effect for the Background Image Overlay'),
                    'desc' => __( '' ),
                    'type' => 'select',
                    'default' => 'easeInOutBack',
                    'options' => array(
                        'easeInOutBack' => __( 'Bounce'),
                        'easeInOutSine' => __( 'Slide' ),
                        'easeInOutQuad' => __( 'Quad'),
                        'easeInOutCubic' => __( 'Cubic' ),
                        'easeInOutQuart' => __( 'Quart'),
                        'easeInOutQuint' => __( 'Quint' ),
                        'easeInOutExpo' => __( 'Expo'),
                        'easeInOutCirc' => __( 'Circ' ),
                        'easeInOutElastic' => __( 'Elastic'),
                        'easeInOutBack' => __( 'Back' )
                    )
                ),
                array(
                    'name' => 'simplyslider_select_logo',
                    'label' => __( 'Set Effect for the H1 Headline or Logo'),
                    'desc' => __( '' ),
                    'type' => 'select',
                    'default' => 'easeInOutBack',
                    'options' => array(
                        'easeInOutBack' => __( 'Bounce'),
                        'easeInOutSine' => __( 'Slide' ),
                        'easeInOutQuad' => __( 'Quad'),
                        'easeInOutCubic' => __( 'Cubic' ),
                        'easeInOutQuart' => __( 'Quart'),
                        'easeInOutQuint' => __( 'Quint' ),
                        'easeInOutExpo' => __( 'Expo'),
                        'easeInOutCirc' => __( 'Circ' ),
                        'easeInOutElastic' => __( 'Elastic'),
                        'easeInOutBack' => __( 'Back' )
                    )
                ),
                array(
                    'name' => 'simplyslider_select_text_line_1',
                    'label' => __( 'Set Effect for the Text Line 1'),
                    'desc' => __( '' ),
                    'type' => 'select',
                    'default' => 'easeInOutBack',
                    'options' => array(
                        'easeInOutBack' => __( 'Bounce'),
                        'easeInOutSine' => __( 'Slide' ),
                        'easeInOutQuad' => __( 'Quad'),
                        'easeInOutCubic' => __( 'Cubic' ),
                        'easeInOutQuart' => __( 'Quart'),
                        'easeInOutQuint' => __( 'Quint' ),
                        'easeInOutExpo' => __( 'Expo'),
                        'easeInOutCirc' => __( 'Circ' ),
                        'easeInOutElastic' => __( 'Elastic'),
                        'easeInOutBack' => __( 'Back' )
                    )
                ),
                array(
                    'name' => 'simplyslider_select_text_line_2',
                    'label' => __( 'Set Effect for the Text Line 2'),
                    'desc' => __( '' ),
                    'type' => 'select',
                    'default' => 'easeInOutBack',
                    'options' => array(
                        'easeInOutBack' => __( 'Bounce'),
                        'easeInOutSine' => __( 'Slide' ),
                        'easeInOutQuad' => __( 'Quad'),
                        'easeInOutCubic' => __( 'Cubic' ),
                        'easeInOutQuart' => __( 'Quart'),
                        'easeInOutQuint' => __( 'Quint' ),
                        'easeInOutExpo' => __( 'Expo'),
                        'easeInOutCirc' => __( 'Circ' ),
                        'easeInOutElastic' => __( 'Elastic'),
                        'easeInOutBack' => __( 'Back' )
                    )
                ),
                array(
                    'name' => 'simplyslider_select_text_line_3',
                    'label' => __( 'Set Effect for the Text Line 3'),
                    'desc' => __( '' ),
                    'type' => 'select',
                    'default' => 'easeInOutBack',
                    'options' => array(
                        'easeInOutBack' => __( 'Bounce'),
                        'easeInOutSine' => __( 'Slide' ),
                        'easeInOutQuad' => __( 'Quad'),
                        'easeInOutCubic' => __( 'Cubic' ),
                        'easeInOutQuart' => __( 'Quart'),
                        'easeInOutQuint' => __( 'Quint' ),
                        'easeInOutExpo' => __( 'Expo'),
                        'easeInOutCirc' => __( 'Circ' ),
                        'easeInOutElastic' => __( 'Elastic'),
                        'easeInOutBack' => __( 'Back' )
                    )
                ),              
            )); 
        
        
        $page->init();
    }
    function admin_menu() {
        add_options_page( 'SimplySlide', 'SimplySlider', 'delete_posts', 'simplyslide-options', array($this->simplyslide_page, 'render') );
    }
    /**
     * Returns all the settings fields
     *
     * @return array settings fields
     */
}
new SimplySlide_Options_Page();
//----------------------------------------------
// Slider Shortcode
//----------------------------------------------
function simply_slider_function() {
$options = get_option( 'simplyslide_page' );
    ob_start();
    ?>
	<div class="simplyslider-content">
		<div id="simplyslider-wrap">
		<div class="simplyslider" id="simplyslider"> 
    <div class="simplyslider-sections simplyslides-container sandbox">  
    			<?php
		  		$slider_flag = false;
		  		for ($i=1;$i<6;$i++) {
          if (isset( $options['slider_image_'.$i]) && $options['slider_image_'.$i] != "" ) {
              echo '<div class="simplyslide-cont">';
              echo '<div class="simplysliderimg-background" style="background: url('.$options['slider_image_'.$i].'); background-size: cover;">'; 
              echo '</div>'; 
						  $slider_flag = true;
              echo '<div class="simplysliderimg-background-overlay" style="background: url('.$options['slider_overlay_'.$i].') repeat;">'; 
              echo '</div>';					
	    				echo '<div class="simplyslide-content">';
              echo '<p class="simplyslidetextline1"><span style="color: '.$options['text_color_'.$i].';">'.$options['slidetitle'.$i].'</span></p>';
              echo '<div class="simplyslide-center">';
              $slidelogo = $options['logo_image_'.$i];
              if ($slidelogo == '') {
	    				echo '<h1 class="simplyslider"><span style="color: '.$options['text_color_'.$i].'">'.$options['headline'.$i].'</span></h1>';
              }
              else if ($slidelogo != '') { 
              echo '<img class="simplyslider" src="'.$options['logo_image_'.$i].'" alt="" />';
              }
              echo '</div>'; 
              echo '<p class="simplyslidetextline2"><span style="color: '.$options['text_color_'.$i].';">'.$options['headline'.$i.'b'].'</span></p>'; 
              echo '<p class="simplyslidetextline3"><span style="color: '.$options['text_color_'.$i].';">'.$options['headline'.$i.'c'].'</span></p>';
              $arrowdown = $options['arrowdown_text'];
              if ($arrowdown == '') {
              echo '';
              }
              else if ($arrowdown != '') { 
              echo '<a href="#'.$options['arrowdown_text'].'"><div><img class="simplyslidedown" src="'.plugins_url('/images/arrowdown64.png', __FILE__).'" alt="arrowdown"/></div></a>';
              }
              echo '</div>'; 
              echo '</div>';
              echo '<div style="clear:both;"></div>';                           
          }
         }          	    	    
			?>
      </div>
      </div>
    </div>
   </div>
<script>
jQuery(document).ready(function(){
  var $backgrounds = jQuery(".simplyslider-content").find("#simplyslider-wrap"),
      LAYER_OFFSET = 30,
      PRLX_SPEED = 1500,
      $slider;
  $slider = jQuery("#simplyslider").simplySlider({
    autoStart: true,
    animationStart: function(ev, slider, step){
      var max_steps = this.framesCount; 
      $backgrounds.each(function(idx, el){
        var pos = (step * (100 / max_steps)) + (LAYER_OFFSET * idx);
        jQuery(this).animate({"backgroundPosition": pos + "% 0"}, PRLX_SPEED);
      });
    },
    elements: {
      ".simplysliderimg-background": {delay: 10, easing: "<?php echo $options['simplyslider_select_background']?>"},
      ".simplysliderimg-background-overlay": {delay: 10, easing: "<?php echo $options['simplyslider_select_background_overlay']?>"},
      "h1.simplyslider": {delay: 800, easing: "<?php echo $options['simplyslider_select_logo']?>"},
      "img.simplyslider": {delay: 800, easing: "<?php echo $options['simplyslider_select_logo']?>"},
      ".simplyslidetextline1": {delay: 500, easing: "<?php echo $options['simplyslider_select_text_line_1']?>"},
      ".simplyslidetextline2": {delay: 1000, easing: "<?php echo $options['simplyslider_select_text_line_2']?>"},
      ".simplyslidetextline3": {delay: 1000, easing: "<?php echo $options['simplyslider_select_text_line_3']?>"},
      ".simplyslidedown": {delay: 1100, easing: "easeInOutBack"},
    }
  });
  jQuery(".simplyslider-content")
    .hover(
      function(){jQuery(this).find(".simplyslider-prev, .simplyslider-next").show();},
      function(){jQuery(this).find(".simplyslider-prev, .simplyslider-next").hide();}
    )
    .find(".simplyslider-prev").click(function(){$slider.simplySlider("go", "prev"); return false; }).end()
    .find(".simplyslider-next").click(function(){$slider.simplySlider("go", "next"); return false; });
});
</script>
	<?php 
return ob_get_clean();    
}
add_shortcode('simplyslider', 'simply_slider_function');