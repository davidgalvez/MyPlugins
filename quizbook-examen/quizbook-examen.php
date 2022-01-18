<?php
/*
Plugin Name:  Quiz Book Examen
Plugin URI:
Description:  Añade la posibilidad de crear exámenes para tus Quiz (Addon)
Version:      1.0
Author:       David Galvez Valverde
Author URI:
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  quizbook
 */
if(! defined('ABSPATH')) exit();

/**
 * Revisa que el plugin principal exista
 */
 function quizbook_examen_revisar(){
     if(!function_exists('quizbook_post_type')){
        add_action( 'admin_notices', 'quizbook_examen_error_activar');
        deactivate_plugins(plugin_basename(__FILE__) );
     }
 }

 /**
  * Mensaje de error en caso de no tener el plugin
  */
 add_action( 'admin_init', 'quizbook_examen_revisar' );

 function quizbook_examen_error_activar(){
    $clase ='notice notice-error';
    $mensaje ='Un error ocurrió, necesitas instalar Quizz';

    printf('<div class="%1s"><p>%2s</p></div>',esc_attr($clase), esc_html($mensaje) );

 }

 /*
* Registrar Post Types
*/
require_once plugin_dir_path(__FILE__) . 'includes/posttypes.php';
register_activation_hook(__FILE__, 'quizbook_examen_rewrite_flush'); 

/*
 * Agrega Roles y Permisos a Quizbook Examen
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/roles.php';
register_activation_hook( __FILE__, 'quizbook_examen_agregar_capabilities' );
register_deactivation_hook( __FILE__, 'quizbook_examen_remover_capabilities' );


/*
 * Agrega Metaboxes
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/metaboxes.php';

/*
 * Agrega Js y Css al plugin
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/scripts.php';

/*
 * Agrega un shortcode al plugin
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/shortcode.php';

/*
 * Agrega columnas al postype
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/columnas.php';