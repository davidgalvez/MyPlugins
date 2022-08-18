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
require_once plugin_dir_path(__FILE__).'/includes/metaboxes.php';

define("QUIZBOOK_POSTTYPE_NAME","quizes");
define("QUIZBOOK_METABOX_ID","quizbook_meta_box");
define("QUIZBOOK_METABOX_TITLE","Respuestas");
define("QUIZBOOK_METABOX_TEMPLATE_PATH",plugin_dir_path(__FILE__)."assets/templates/quizbook-metabox.php");
define("QUIZBOOK_METABOX_NONCE","quizbook_nonce");

/**
 * Clase principal del plugin para añadir preguntas con opciones multiples
 */
class quizzbookPlugin
{

  /**
   * Postype object to be injected to the plugin
   */
  private quizbookPostType $postType;
  private quizzbookMetabox $metaBox;

  function __construct(quizbookPostType $postType)
  {
    $this->postType = $postType;
  }

  /**
   * Añade el postype del plugin
   */
  function registerPostType()
  {
    if($this->postType->argumentsExists() and $this->postType->labelsExists())
    {
      register_post_type( $this->postType->getName(), $this->postType->getArguments() );
    }     
  }

  /**
   * Limpia los rewriete rules en la activacion del plugin
   */
  function rewriteFlushPostType()
  {
    $this->postType->rewriteFlushPostype();
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

  /**
   * agrega el metabox al plugin
   */
  function addMetaBox()
  {      
    call_user_func_array('add_meta_box',$this->metaBox->getArguments());
  }

  /**
   * Asocia la accion add_meta_boxes al metodo para registrar el metabox
   */
  function addMetaBoxes(string $metaboxId, string $metaboxTitle, string $metaboxTemplatePath, string $metaboxNonce){
    $this->metaBox=new quizzbookMetabox($metaboxId, $metaboxTitle, $metaboxTemplatePath, $metaboxNonce); 
    add_action( 'add_meta_boxes', array($this,'addMetaBox'));
  }

  /**
   * Invoca al metodo de guardar del metabox
   */
  private function getSaveMetaBox(int $postID)
  {
    $this->metaBox->saveMetabox($postID);
  }

  /**
   * Asocia la accion save_post al metodo para actualizar los datos del metabox
   */
  function addSaveMetaBoxes(){
    add_action( 'save_post', array($this,'getSaveMetaBox'),10);
  }
}
 
$quizbookPostType = new quizbookPostType(QUIZBOOK_POSTTYPE_NAME);
$quizbook = new quizzbookPlugin($quizbookPostType);
$quizbook->initPlugin();
$quizbook->registerActivationHook();
$quizbook->addMetaBoxes(QUIZBOOK_METABOX_ID,QUIZBOOK_METABOX_TITLE, QUIZBOOK_METABOX_TEMPLATE_PATH, QUIZBOOK_METABOX_NONCE);
$quizbook->addSaveMetaBoxes();



/**
 * Añade metaboxes a los quizes
 */
//require_once plugin_dir_path(__FILE__).'/includes/metaboxes.php';

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