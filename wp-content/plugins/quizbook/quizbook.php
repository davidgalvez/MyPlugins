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
require_once plugin_dir_path(__FILE__).'/includes/roles.php';

define("QUIZBOOK_POSTTYPE_NAME","quizes");
define("QUIZBOOK_METABOX_ID","quizbook_meta_box");
define("QUIZBOOK_METABOX_TITLE","Respuestas");
define("QUIZBOOK_METABOX_TEMPLATE_PATH",plugin_dir_path(__FILE__)."assets/templates/quizbook-metabox.php");
define("QUIZBOOK_METABOX_NONCE","quizbook_nonce");
define("QUIZBOOK_ROLES_ROL_NAME","quizbook");
define("QUIZBOOK_ROLES_DISPLAY_NAME","Quiz");

/**
 * Clase principal del plugin para añadir preguntas con opciones multiples
 */
class quizzbookPlugin
{

  /**
   * objects to be injected to the plugin
   */
  private quizbookPostType $postType;
  private quizzbookMetabox $metaBox;
  private quizbookRoles $roles;

  /**
   * atributes of the plugin
   */
  private string $postypeName;
  private string $roleName;
  private string $roleDisplayName;

  function __construct(string $postypeName, string $roleName, string $roleDisplayName)
  {
    $this->postType = new quizbookPostType($postypeName);
    $this->roles = new quizbookRoles($roleName,$roleDisplayName);
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
   * Para crear el rol en la activacion del plugin
   */
  function createRol()
  {    
    $this->roles->createRol();
  }

  /**
   * Para remover el rol creado por el plugin al desactivarlo
   */
  function removeRol()
  {
    $this->roles->removeRol();
  }

  /**
   * Para crear los capabilities en la activacion del plugin
   */
  function addCapabilities()
  {
    $this->roles->addCapabilities();
  }

  /**
   * Para remover los capabilities creados por el plugin al desactivarlo
   */
  function removeCapabilities()
  {
    $this->roles->removeCapabilities();
  }

  /**
   * Invoca al método para registrar el Posttype en el evento init de wordpress
   */
  function initPlugin()
  {
    add_action('init', array($this, 'registerPostType'));
  }

  /**
   * Registra los hooks que se ejecutaran al activar el plugin
   */
  function registerActivationHooks()
  {
    register_activation_hook(__FILE__, array($this, 'rewriteFlushPostType'));
    register_activation_hook(__FILE__, array($this, 'createRol'));
    register_activation_hook(__FILE__, array($this, 'addCapabilities'));
  }

  /**
   * Registra los hooks que se ejecutaran al desactivar el plugin
   */
  function registerDeactivationHooks()
  {
    register_deactivation_hook(__FILE__, array($this, 'removeRol'));
    register_deactivation_hook(__FILE__, array($this, 'removeCapabilities'));
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
 
$quizbook = new quizzbookPlugin(QUIZBOOK_POSTTYPE_NAME,QUIZBOOK_ROLES_ROL_NAME,QUIZBOOK_ROLES_DISPLAY_NAME);
$quizbook->initPlugin();
$quizbook->addMetaBoxes(QUIZBOOK_METABOX_ID,QUIZBOOK_METABOX_TITLE, QUIZBOOK_METABOX_TEMPLATE_PATH, QUIZBOOK_METABOX_NONCE);
$quizbook->addSaveMetaBoxes();
$quizbook->registerActivationHooks();


/**
 * Añade roles y capabilities a los quizes
 */
/*require_once plugin_dir_path(__FILE__).'/includes/roles.php';
register_activation_hook(__FILE__, 'quizbook_crear_role');
register_deactivation_hook(__FILE__, 'quizbook_remover_role');

register_activation_hook(__FILE__,'quizbook_agregar_capabilities');
register_deactivation_hook(__FILE__, 'quizbook_remover_capabilities');*/

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