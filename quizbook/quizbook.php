<?php
/*
Plugin Name:  Quiz Book
Plugin URI:
Description:  Plugin para añadir Quizes o Cuestionarios con opción múltiple
Version:      1.0
Author:       David Galvez Valverde
Author URI:
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  quizbook
 */

 /**
  * Añade el postype del plugin
  */
require_once plugin_dir_path(__FILE__).'/includes/posttypes.php';

/**
 * Regenera los permalinks al activar el plugin
 */
register_activation_hook(__FILE__, 'quizbook_rewrite_flush');

/**
 * Añade metaboxes a los quizes
 */
require_once plugin_dir_path(__FILE__).'/includes/metaboxes.php';

/**
 * Añade roles y capabilities a los quizes
 */
require_once plugin_dir_path(__FILE__).'/includes/roles.php';
register_activation_hook(__FILE__, 'quizbook_crear_role');
register_deactivation_hook(__FILE__, 'quizbook_remover_role');

register_activation_hook(__FILE__,'quizbook_agregar_capabilities');
register_deactivation_hook(__FILE__, 'quizbook_remover_capabilities');

/**
 * Añade un shortcode
 */
require_once plugin_dir_path(__FILE__).'/includes/shortcode.php';

/**
 * Añade archivo de funciones
 */
require_once plugin_dir_path(__FILE__).'/includes/funciones.php';

/**
 * Añade hojas de estilo y archivos js
 */
require_once plugin_dir_path(__FILE__).'/includes/scripts.php';

/**
 * Devuelve los resultados del examen
 */
require_once plugin_dir_path(__FILE__).'/includes/resultados.php';

?>