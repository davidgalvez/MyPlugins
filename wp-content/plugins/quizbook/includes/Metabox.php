<?php
/**
 * @package Quizbook
 */
use function PHPUnit\Framework\isReadable;
namespace Quizbook;

if(! defined('ABSPATH')) exit();
use \WP_Post;
/**
 * Definición de los argumentos y etiquetas del postype a registrar en el plugin
 */
class Metabox{
    /**
     * Nombre unico del metabox
     * 
     * @var string
     */
    private string $id;

    /**
     * Título del metabox
     */
    private string $tittle;    
    

    /**
     * Ruta del template a usar para mostrar el contenido del metabox
     */
    private string $template;

    /**
     * Id del Nonce para validar los formularios
     */
    protected string $nonce;

    /**
     * Pantalla en la que se mostrará el metabox
     */
    private ?string $screen='quizes';

    /**
     * Contexto en el cual se mostrará el contenido del metabox
     */
    private string $context;

    /**
     * Prioridad en la que se mostrará el metabox
     */
    private string $priority;

    /**
     * @param array $args  Arreglo asociativo de argumentos para crear el metabox el array debería tener los siguientes argumentos:
     * ("id", "title","template_path", "nonce", "screen", "priority"); 
     */
    function __construct(array $args)
    {
        $this->setArguments($args);
    }

    /**
     * Asigna los argumentos al metabox
     */
    function setArguments($args)
    {
        $this->id=$args["id"];
        $this->tittle=$args["title"];
        $this->template=rtrim($args["template_path"], '/');  
        $this->nonce=$args["nonce"];      
        $this->screen=$args["screen"];
        $this->context=$args["context"];
        $this->priority=$args["priority"];
    }

    /**
     * Add Metabox actions to plugin using actions add_meta_boxes y save_post
     */
    public function addToPlugin()
    {
        add_action( 'add_meta_boxes', array($this,'addToMetaboxList'));
        add_action( 'save_post', array($this,'saveMetabox'),10);

    }

    /**
     * Add Metabox to metabox list
     */
    function addToMetaboxList()
    {
        call_user_func_array('add_meta_box',$this->getArguments());
    }

    /**
     * Devuelve todos los argumentos necesarios para agregar el metabox al plugin
     */
    function getArguments()
    {
        return array(
            $this->id,
            $this->tittle,
            $this->getCallback(),
            $this->screen,
            $this->context,
            $this->priority
        );
    }

    function getId()
    {
        return $this->id;

    }

    function getTittle()
    {
        return $this->tittle;
    }

    function getScreen()
    {
        return $this->screen;
    }
    
    function getContext()
    {
        return $this->context;
    }

    function getPriority()
    {
        return $this->priority;
    }

    function getTemplate()
    {
        return $this->template;
    }

    /**
     * Obtiene el metodo Callback para renderizar el metabox, se usa como argumento al momento de agregar el metabox al plugin
     */
    function getCallback()
    {
        return array($this,'renderTemplate');
    }

    /**
     * Renderiza el formulario html de los metaboxes usando el template
     */
    function renderTemplate(WP_Post $post){        
        wp_nonce_field(basename(__FILE__), $this->nonce);
        include $this->template;
    }

    /**
     * Valida si el nonce de seguridad creado en el metabox está incluido en el request.
     */
    function validateNonceIsInRequest(){
        if(!isset($_POST[$this->nonce]) || !wp_verify_nonce( $_POST[$this->nonce],basename(__FILE__)))
        {
            return false;
        }
        return true;
    }

    /**
     * Valida si el usuario tienen permisos para editar el post
     */
    function validateUserIsAllowed(int $postId){
        if(!current_user_can('edit_post',$postId)){
            return false;
        }
        return true;
    }

    /**
     * Valida si está activo el autosave para evitar actualizar dos veces
     */
    function validateAutosave()
    {
        if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
            return false;
        }
        return true;
    }

    

    function saveMetabox(int $postID){

        if(!$this->validateNonceIsInRequest()||!$this->validateUserIsAllowed($postID)||!$this->validateAutosave())
        {
            return $postID;
        }

        $respuesta_a = $respuesta_b = $respuesta_c = $respuesta_d = $respuesta_e = '';


        if(isset( $_POST['qb_respuesta_a'] ) ) {
        $respuesta_a = sanitize_text_field($_POST['qb_respuesta_a']);
        }
        update_post_meta($postID, 'qb_respuesta_a', $respuesta_a );

        if(isset($_POST['qb_respuesta_b'])) {
        $respuesta_b = sanitize_text_field($_POST['qb_respuesta_b']);
        }
        update_post_meta($postID, 'qb_respuesta_b', $respuesta_b );

        if(isset($_POST['qb_respuesta_c'])) {
        $respuesta_c = sanitize_text_field($_POST['qb_respuesta_c']);
        }
        update_post_meta($postID, 'qb_respuesta_c', $respuesta_c );

        if(isset($_POST['qb_respuesta_d'])) {
        $respuesta_d = sanitize_text_field($_POST['qb_respuesta_d']);
        }
        update_post_meta($postID, 'qb_respuesta_d', $respuesta_d );

        if(isset($_POST['qb_respuesta_e'])) {
        $respuesta_e = sanitize_text_field($_POST['qb_respuesta_e']);
        }
        update_post_meta($postID, 'qb_respuesta_e', $respuesta_e );

        if(isset($_POST['quizbook_correcta'])) {
        $correcta = sanitize_text_field($_POST['quizbook_correcta']);
        }
        update_post_meta($postID, 'quizbook_correcta', $correcta );

    }
}

?>