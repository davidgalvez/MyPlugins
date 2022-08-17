<?php
/*
Plugin Name:  Quiz Book
Plugin URI:
Description:  Plugin para añadir Quizes o Cuestionarios con opción múltiple
Version:      2.0
Author:       David Galvez Valverde
Author URI:   https://davidgalvezv.wordpress.com/
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  quizbook
 */

require_once plugin_dir_path(__FILE__).'/includes/posttypes.php';

/**
 * Clase principal del plugin para añadir preguntas con opciones multiples
 */
class quizzbook
{

  /**
   * Postype object to be injected to the plugin
   */
  private quizbookPostType $quizbookPostType;

  function __construct(quizbookPostType $quizbookPostType)
  {
    $this->quizbookPostType = $quizbookPostType;
  }

  /**
   * Añade el postype del plugin
   */
  function registerPostType()
  {
    $this->quizbookPostType->registerPostype();
  }

  /**
   * Limpia los rewriete rules en la activacion del plugin
   */
  function rewriteFlushPostType()
  {
    $this->quizbookPostType->rewriteFlushPostype();
  }

  /**
   * Invoca al método para registrar el Posttype en el evento init de wordpress
   */
  function initPlugin()
  {
    add_action('init', array($this, 'registerPostType'));
  }

  /**
   * Regenera los permalinks al activar el plugin
   */
  function registerActivationHook()
  {
    register_activation_hook(__FILE__, array($this, 'rewriteFlushPostType'));
  }
}
 
$quizbookPostType = new quizbookPostType('quizes');
$quizbook = new quizzbook($quizbookPostType);
$quizbook->initPlugin();
$quizbook->registerActivationHook();




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