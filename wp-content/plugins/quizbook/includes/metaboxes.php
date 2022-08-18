<?php

use function PHPUnit\Framework\isReadable;

if(! defined('ABSPATH')) exit();

class quizzbookMetabox{
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

    function __construct(string $id, string $tittle, string $template, string $nonce, string $screen='quizes', string $context='normal', string $priority='high')
    {
        $this->id=$id;
        $this->tittle=$tittle;
        $this->template=rtrim($template, '/');  
        $this->nonce=$nonce;      
        $this->screen=$screen;
        $this->context=$context;
        $this->priority=$priority;
    }

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