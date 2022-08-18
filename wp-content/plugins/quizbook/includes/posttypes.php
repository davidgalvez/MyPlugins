<?php

use function PHPUnit\Framework\returnSelf;

if(! defined('ABSPATH')) exit();

/**
 * Definición de los argumentos y etiquetas del postype a registrar en el plugin
 */
class quizbookPostType{
    /**
     * Arreglo de etiquetas para el posttype
     */
    private ?array $labels=NULL;

    /**
     * Arreglo de argumentos para el posttype
     */
    private ?array $args =NULL;

    /**
     * Nombre del posttype
     */
    private string $postypeName;

    /**
     * Se crea un nuevo objeto enviandule el nombre para el postype
     */
    function __construct(string $postypeName){
        $this->postypeName=$postypeName;
        $this->setLabels();
        $this->setArguments();
    }

    /**
     * Devuelve las etiquetas del posttype
     */
    function getLabels(){
        return $this->labels;
    }

    /**
     * Devuelve los argumentos del posttype
     */
    function getArguments(){
        return $this->args;
    }
    
    /**
     * Devuelve el nombre unico del postype
     */
    function getName(){
        return $this->postypeName;
    } 

    /**
     * Registra el posttype con las etiquetas y argumentos
     */
    function registerPostype(){        
        if($this->argumentsExists() and $this->labelsExists()){
            register_post_type( $this->postypeName, $this->args );
        }        
    }

    function rewriteFlushPostype(){
        //$this->registerPostype($this->postype);
	    flush_rewrite_rules();
    }

    /**
     * Verifica si se han definido las etiquetas
     */
    function labelsExists(){
        return ($this->labels!=NULL);
    }

    /**
     * Verifica si el posttype está registrado
     */
    function isRegisteredPostType(){
        return post_type_exists( $this->postypeName );
    }

    /**
     * Verifica si se han definido los argumentos para el posttype
     */
    function argumentsExists(){
        return ($this->args!=NULL);
    }

    /**
     * Asigna las etiquetas para el posttpe
     */
    function setLabels(){
       $this->labels =array(
            'name'                  => _x( 'Quiz', 'Post type general name', 'quizbook' ),
            'singular_name'         => _x( 'Quiz', 'Post type singular name', 'quizbook' ),
            'menu_name'             => _x( 'Quizes', 'Admin Menu text', 'quizbook' ),
            'name_admin_bar'        => _x( 'Quiz', 'Add New on Toolbar', 'quizbook' ),
            'add_new'               => __( 'Add New', 'quizbook' ),
            'add_new_item'          => __( 'Add New Quiz', 'quizbook' ),
            'new_item'              => __( 'New Quiz', 'quizbook' ),
            'edit_item'             => __( 'Editar Quiz', 'quizbook' ),
            'view_item'             => __( 'Ver Quiz', 'quizbook' ),
            'all_items'             => __( 'Todos Quizes', 'quizbook' ),
            'search_items'          => __( 'Buscar Quizes', 'quizbook' ),
            'parent_item_colon'     => __( 'Padre Quizes:', 'quizbook' ),
            'not_found'             => __( 'No encontrados.', 'quizbook' ),
            'not_found_in_trash'    => __( 'No encontrados.', 'quizbook' ),
            'featured_image'        => _x( 'Imagen Destacada', '', 'quizbook' ),
            'set_featured_image'    => _x( 'Añadir imagen destacada', '', 'quizbook' ),
            'remove_featured_image' => _x( 'Borrar imagen', '', 'quizbook' ),
            'use_featured_image'    => _x( 'Usar como imagen', '', 'quizbook' ),
            'archives'              => _x( 'Quizes Archivo', '', 'quizbook' ),
            'insert_into_item'      => _x( 'Insertar en Quiz', '', 'quizbook' ),
            'uploaded_to_this_item' => _x( 'Cargado en este Quiz', '', 'quizbook' ),
            'filter_items_list'     => _x( 'Filtrar Quizes por lista', '”. Added in 4.4', 'quizbook' ),
            'items_list_navigation' => _x( 'Navegación de Quizes', '', 'quizbook' ),
            'items_list'            => _x( 'Lista de Quizes', '', 'quizbook' ),
        );
    }

    /**
     * Asigna los argumentos para el posttype
     */
    function setArguments(){
        $this->args= array(
            'labels'             => $this->labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'quizes' ),
            'capability_type'    => array('quiz','quizes'),
            'menu_position'      => 6,
            'menu_icon'          => 'dashicons-welcome-learn-more',
            'has_archive'        => false,
            'hierarchical'       => false,
            'supports'           => array( 'title', 'editor'),
            'map_meta_cap'       => true,
        );
    }

    
}

?>