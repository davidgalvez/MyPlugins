<?php
if(! defined('ABSPATH')) exit();
/**
 * Agrega estilos y javascript al front
 */
function quizbook_frontend_styles(){
    wp_enqueue_style( 'quizbook_css', plugins_url('../assets/css/quizbook.css', __FILE__));
    wp_enqueue_script( 'quizbook_js', plugins_url('../assets/js/quizbook.js', __FILE__),array('jquery'), 1.0, true);
    wp_localize_script('quizbook_js','admin_url',  array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}

add_action( 'wp_enqueue_scripts', 'quizbook_frontend_styles');

/**
 * Agrega estilos y javascript al admin cuando se crea un Quiz
 */
function quizbook_admin_styles($hook){

    global $post;

    if($hook == 'post-new.php' || $hook == 'post.php'){
        if($post->posst_type==='quizbook'){
            wp_enqueue_style( 'quizbookcss', plugins_url('../assets/css/admin-quizbook.css', __FILE__) );
        }        
    }
    

}

add_action('admin_enqueue_scripts', 'quizbook_admin_styles');