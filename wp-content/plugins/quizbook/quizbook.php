<?php
/**
 * Class Quizbook
 *
 * @package Quizbook
 */
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
defined('ABSPATH') or die("Acceso restringido");

if(file_exists(dirname(__FILE__)."/vendor/autoload.php"))
{
  require_once(dirname(__FILE__)."/vendor/autoload.php");
}
require_once("quizbook-config.php");

use \Quizbook\PostType;
use \Quizbook\Metabox;
use \Quizbook\Shortcode;
use \Quizbook\Scripts;
use \Quizbook\AjaxResults;
use Quizbook\Activate;
use Quizbook\Deactivate;


/**
 * Metodo que se ejecuta en la activación del plugin
 */
function activar_quizbook_plugin() {
  $activate=new Activate();
	$activate->activate();
}

/**
 * Metodo que se ejecuta en la desactivación del plugin
 */
function desactivar_quizbook_plugin() {
  $deactivate=new Deactivate();
	$deactivate->deactivate();
}
register_activation_hook(__FILE__,'activar_quizbook_plugin');
register_deactivation_hook(__FILE__,'desactivar_quizbook_plugin');

/**
 * Clase principal del plugin para añadir preguntas con opciones multiples
 */
class quizzbookPlugin
{

    /**
     * objects to be injected to the plugin
     */
    public PostType $postType;
    private Metabox $metaBox;
    private Shortcode $shortcode;
    private Scripts $scripts;
    private AjaxResults $ajaxResults;

    /**
     * atributes of the plugin
     */
    private string $postypeName;
    private int $minimunScore;

    function __construct()
    {
      $this->postypeName=QUIZBOOK_POSTTYPE_NAME;  
      $this->postType = new PostType($this->postypeName);  
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
      $this->metaBox=new Metabox($metaboxId, $metaboxTitle, $metaboxTemplatePath, $metaboxNonce); 
      add_action( 'add_meta_boxes', array($this,'addMetaBox'));
    }

    /**
     * Invoca al metodo de guardar del metabox
     */
    function getSaveMetaBox(int $postID)
    {
      $this->metaBox->saveMetabox($postID);
    }

    /**
     * Asocia la accion save_post al metodo para actualizar los datos del metabox
     */
    function addSaveMetaBoxes(){
      add_action( 'save_post', array($this,'getSaveMetaBox'),10);
    }

    /**
     * Asigna el parametro shorcode a una nueva instancia de la clase quizbookShortcode
     */
    function setShortcode(string $shortcodePath){
      $this->shortcode= new Shortcode($this->postypeName, $shortcodePath);
      
    }

    /**
     * Invoca al método para crear el shortcode
     */
    function createShortCode(array $attributes){
      $this->shortcode->createShortcode($attributes);
      
    }

    /**
     * Registra el shortcode en el plugin
     */
    function registerShortcode(){
      add_shortcode("quizbook", array($this->shortcode, "createShortCode"));
    }

    /**
     * Asigna el parametro scripts a una instancia de la clase postypeScripts
     */
    function setScripts(string $jsFilePath, string $cssFrontPath, string $cssAdminPath){
      $this->scripts= new Scripts($this->postypeName, $jsFilePath, $cssFrontPath, $cssAdminPath);
    }

    /**
     * Registra los scripts del front end para el plugin
     */
    function addActionRegisterFrontEndScripts()
    {
      add_action('wp_enqueue_scripts', array($this->scripts,'addFrontJsCssFiles'));
    }

    /**
     * Registra los scripts del admin para el plugin
     */
    function addActionRegisterAdminScripts()
    {
      add_action('admin_enqueue_scripts', array($this->scripts,'addAdminJsCssFiles'));
    }

    /**
     * Asigna el parametro ajaxresults a una instancia de la clase quizbookAjaxResults
     */
    function setAjaxResults(int $minimunScore, int $minvalidScore, int $maxValidScore){
      $this->ajaxResults= new AjaxResults($minimunScore,$minvalidScore, $maxValidScore);
    }

    function addActionAjaxQuizbookResultados(){
      add_action( 'wp_ajax_nopriv_quizbook_resultados', array($this->ajaxResults,'getQuizbookResult')); //hook ajax cuando estas logueado
      add_action( 'wp_ajax_quizbook_resultados', array($this->ajaxResults,'getQuizbookResult'));//hook ajax cuando no estas logueado
    }
    
}
 
$quizbook = new quizzbookPlugin();
$quizbook->postType->addToPlugin();
$quizbook->addMetaBoxes(QUIZBOOK_METABOX_ID,QUIZBOOK_METABOX_TITLE, QUIZBOOK_METABOX_TEMPLATE_PATH, QUIZBOOK_METABOX_NONCE);
$quizbook->addSaveMetaBoxes();
$quizbook->setShortcode(QUIZBOOK_SHORTCODE_TEMPLATE_PATH);
$quizbook->registerShortcode();
$quizbook->setScripts(QUIZBOOK_SCRIPTS_PATH,QUIZBOOK_CSS_FRONT_PATH,QUIZBOOK_CSS_ADMIN_PATH);
$quizbook->addActionRegisterAdminScripts();
$quizbook->addActionRegisterFrontEndScripts();
$quizbook->setAjaxResults(QUIZBOOK_MINIMUN_SCORE,QUIZBOOK_MIN_VALID_SCORE, QUIZBOOK_MAX_VALID_SCORE);
$quizbook->addActionAjaxQuizbookResultados();
?>