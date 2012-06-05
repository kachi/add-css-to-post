<?php
/*
Plugin Name: Add css to post
Plugin URI: http://kachibito.net/wordpress/add-css-to-post.html
Description: Add CSS per post
Version: 0.0.0
Author: shiro
Author URI: http://kachibito.net/
*/

function add_css_to_post_custom_css_input() {
    global $post;
    echo '<input type="hidden" name="custom_css_noncename" id="custom_css_noncename" value="'.wp_create_nonce('custom-css').'" />';
    echo '<textarea name="custom_css" id="custom_css" rows="5" cols="30" style="width:100%;">'.get_post_meta($post->ID,'_custom_css',true).'</textarea>';
}

function add_css_to_post_custom_css_hooks() {
    add_meta_box('custom_css', 'add CSS', 'add_css_to_post_custom_css_input', 'post', 'normal', 'high');
    add_meta_box('custom_css', 'add CSS', 'add_css_to_post_custom_css_input', 'page', 'normal', 'high');
}

function add_css_to_post_save_custom_css($post_id) {
    if (!wp_verify_nonce($_POST['custom_css_noncename'], 'custom-css')) {
	return $post_id;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
	return $post_id;
    }
    $custom_css = $_POST['custom_css'];
    update_post_meta($post_id, '_custom_css', $custom_css);
}

function add_css_to_post_insert_custom_css() {
    if (is_page() || is_single()) {
	while (have_posts()) {
	    the_post();
	    echo '<style type="text/css">'.get_post_meta(get_the_ID(), '_custom_css', true).'</style>';
	}
	rewind_posts();
    }
}

function add_css_to_post_init() {
    add_action('admin_menu', 'add_css_to_post_custom_css_hooks');
    add_action('save_post', 'add_css_to_post_save_custom_css');
    add_action('wp_head','add_css_to_post_insert_custom_css');
}

add_action('init', 'add_css_to_post_init');


function add_js_to_post_custom_js_input() {
    global $post;
    echo '<input type="hidden" name="custom_js_noncename" id="custom_js_noncename" value="'.wp_create_nonce('custom-js').'" />';
    echo '<textarea name="custom_js" id="custom_css" rows="5" cols="30" style="width:100%;">'.get_post_meta($post->ID,'_custom_js',true).'</textarea>';
}

function add_js_to_post_custom_js_hooks() {
    add_meta_box('custom_js', 'add JS', 'add_js_to_post_custom_js_input', 'post', 'normal', 'high');
    add_meta_box('custom_js', 'add JS', 'add_js_to_post_custom_js_input', 'page', 'normal', 'high');
}

function add_js_to_post_save_custom_js($post_id) {
    if (!wp_verify_nonce($_POST['custom_js_noncename'], 'custom-js')) {
	return $post_id;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
	return $post_id;
    }
    $custom_js = $_POST['custom_js'];
    update_post_meta($post_id, '_custom_js', $custom_js);
}

function add_js_to_post_insert_custom_js() {
    if (is_page() || is_single()) {
	while (have_posts()) {
	    the_post();
	    echo '<script type="text/javascript">'.get_post_meta(get_the_ID(), '_custom_js', true).'</script>';
	}
	rewind_posts();
    }
}

function add_js_to_post_init() {
    add_action('admin_menu', 'add_js_to_post_custom_js_hooks');
    add_action('save_post', 'add_js_to_post_save_custom_js');
    add_action('wp_head','add_js_to_post_insert_custom_js');
}

add_action('init', 'add_js_to_post_init');

?>
