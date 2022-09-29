<?php

/**
 * Plugin Name:       Template Chooser Widget
 * Description:       Template Chooser Widget is created by Zain.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Zain Hassan
 * Text Domain:       template-chooser-widget
*/

if(!defined('ABSPATH')){
exit;
}

require_once plugin_dir_path( __FILE__ ) .'../codestar-framework-master/classes/setup.class.php';

// Control core classes for avoid errors
if( class_exists( 'CSF' ) ) {

    //
    // Set a unique slug-like ID
    $prefix = 'template_chooser_widget';

    //
    // Create options
    CSF::createOptions( $prefix, array(
        'menu_title' => 'Frames',
        'menu_slug'  => 'frames-form',
        'framework_title' => 'Frames',
    ));

  //
  // General Form Settings
  CSF::createSection( $prefix, array(
    'title'  => 'Add Frames',
    'fields' => array(

        array(
            'id'     => 'frame_repeater',
            'type'   => 'repeater',
            'title'  => 'Add Category',
            'fields' => array(
          
                array(
                    'id'      => 'frame-category',
                    'type'    => 'text',
                    'title'   => 'Category Name',
                    'default' => '',
                    'placeholder' => 'Please Type Category First'
                ),
                array(
                    'id'          => 'frame-images',
                    'type'        => 'gallery',
                    'title'       => 'Gallery',
                    'add_title'   => 'Add Images',
                    'edit_title'  => 'Edit Images',
                    'clear_title' => 'Remove Images',
                    'dependency' => array( 'frame-category', '!=', '' ) // check for true/false by field id
                ),
          
            ),
          ),

    )
  ));



}

/**
 *  Elementor Custom Widget
*/
function register_template_chooser_widget( $widgets_manager ) {
    /** Posts Widget **/
	require_once( __DIR__ . '/widget/template.php' );
	$widgets_manager->register( new \custom_template_chooser_widget );

}
add_action( 'elementor/widgets/register', 'register_template_chooser_widget' );

function template_chooser_scripts() {
    // Register the script
    wp_register_script( 'template_widget_js', plugins_url( 'widget/assets/script.js', __FILE__ ), ['jquery'], false, true);
  
    // Localize the script with new data
    $script_data_array = array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'security' => wp_create_nonce( 'file_upload' ),
    );
    wp_localize_script( 'template_widget_js', 'blog', $script_data_array );
  
    // Enqueued script with localized data.
    wp_enqueue_script( 'template_widget_js' );
}
add_action('wp_enqueue_scripts', 'template_chooser_scripts');


add_action('wp_ajax_custom_set_form', 'custom_set_form_callback');
add_action('wp_ajax_nopriv_custom_set_form', 'custom_set_form_callback');


function custom_set_form_callback(){
    $selectedImage  = $_POST['selectedImage'];
    $selectedImageAlt  = $_POST['selectedImageAlt'];
    $Name           = $_POST['Name'];
    $bookingEmail   = $_POST['bookingEmail'];
    $eventDate      = $_POST['eventDate'];
    $phone          = $_POST['phone'];
    $message        = $_POST['message'];
    $to             = $_POST['sent_email'];
    $from           = get_option( 'admin_email' ); 

    global $wpdb;

    if ( is_email( $bookingEmail ) ){

        check_ajax_referer('file_upload', 'security');
        $arr_img_ext = array('image/png', 'image/jpeg', 'image/jpg');
        $upload = [];
        if (in_array($_FILES['file']['type'], $arr_img_ext)) {
            $upload = wp_upload_bits($_FILES["file"]["name"], null, file_get_contents($_FILES["file"]["tmp_name"]));
        }

        

        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: '.get_option( 'blogname' ).' <'.$bookingEmail.'>',
            'Reply-To: '.$Name.' <'.$bookingEmail.'>',
        );
    
        $subject = 'Template Chooser Form';

        $msg = '<!DOCTYPE html>
        <html>
            <head></head>
            <body>
                <table>
                    <tr><td>Selected Frame: </td><td><img style="width:300px; object-fit:contain;" src="' . $selectedImage . '" ></td></tr>
                    <tr><td>Image Name: </td><td>' . $selectedImageAlt . '</td></tr>
                    <tr><td>Name: </td><td>' . $Name . '</td></tr>
                    <tr><td>Email: </td><td>' . $bookingEmail . '</td></tr>
                    <tr><td>Eventdate: </td><td>' . $eventDate . '</td></tr>
                    <tr><td>phone: </td><td>' . $phone . '</td></tr>
                    <tr><td>Message: </td><td>' . $message . '</td></tr>
                    <tr><td>Attachment Image: </td><td><img style="width:300px; object-fit:contain;" src="' . $upload['url'] . '" ></td></tr>
                </table>
            </body>
        </html>';

        if(wp_mail($to, $subject, $msg, $headers)){
            echo "email sent";
        }
    }else{
        echo "incorrect";
    }
    wp_die();
}