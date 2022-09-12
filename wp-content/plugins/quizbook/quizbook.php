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
use \Quizbook\EnqueueScripts;
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
    public Metabox $metaBox;
    public Shortcode $shortcode;
    public EnqueueScripts $enqueueScripts;
    public AjaxResults $ajaxResults;

    /**
     * atributes of the plugin
     */
    private string $postypeName;    
    private array $metaboxArgs;
    private string $shortcodePath; 
    private string $jsFilePath; 
    private string $cssFrontPath; 
    private string $cssBackPath; 
    private int $minimunScore;
    private int $minValidScore;
    private int $maxValidScore;

    function __construct()
    {
      $this->postypeName=QUIZBOOK_POSTTYPE_NAME;  
      $this->metaboxArgs=QUIZBOOK_METABOX_ARGS;
      $this->shortcodePath=QUIZBOOK_SHORTCODE_TEMPLATE_PATH; 
      $this->jsFilePath=QUIZBOOK_SCRIPTS_PATH;
      $this->cssFrontPath=QUIZBOOK_CSS_FRONT_PATH;
      $this->cssBackPath=QUIZBOOK_CSS_ADMIN_PATH;  
      $this->minimunScore=QUIZBOOK_MINIMUN_SCORE;
      $this->minValidScore=QUIZBOOK_MIN_VALID_SCORE;
      $this->maxValidScore=QUIZBOOK_MAX_VALID_SCORE;   
      $this->postType = new PostType($this->postypeName);  
      $this->metaBox=new Metabox($this->metaboxArgs); 
      $this->shortcode= new Shortcode($this->postypeName, $this->shortcodePath);
      $this->enqueueScripts = new EnqueueScripts($this->postypeName,$this->jsFilePath,$this->cssFrontPath,$this->cssBackPath);
      $this->ajaxResults= new AjaxResults($this->minimunScore,$this->minValidScore,$this->maxValidScore);
    } 
    
}
 
$quizbook = new quizzbookPlugin();
$quizbook->postType->addToPlugin();
$quizbook->metaBox->addToPlugin();
$quizbook->shortcode->addToPlugin();
$quizbook->enqueueScripts->addToPlugin();
$quizbook->ajaxResults->addToPlugin();
?>