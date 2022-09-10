<?php
/**
 * @package Quizbook
 */
namespace Quizbook;
if(! defined('ABSPATH')) exit();

/**
 * Class to admin scripts and styles of the plugin
 */
class Scripts
{
    private string $posttype;
    private string $jsFilePath;
    private string $cssFrontPath; 
    private string $cssAdminPath;

    function __construct(string $posttype,string $jsFilePath, string $cssFrontPath, string $cssAdminPath)
    {
        $this->posttype=$posttype;
        $this->jsFilePath=$jsFilePath;
        $this->cssFrontPath=$cssFrontPath;
        $this->cssAdminPath=$cssAdminPath;
    }

    /**
     * Agrega estilos y js al front end
     */
    function addFrontJsCssFiles(){
        wp_enqueue_style( 'quizbook_css', $this->cssFrontPath);
        wp_enqueue_script( 'quizbook_js', $this->jsFilePath,array('jquery'), 1.0, true);
        wp_localize_script('quizbook_js','admin_url',  array(
            'ajax_url' => admin_url('admin-ajax.php')
        ));
    }

    /**
     * Agrega estilos al admin cuando se crea un quiz
     */
    function addAdminJsCssFiles(string $hook){
        global $post;

        if($this->isValidHook($hook) and $this->isValidPosttype())
        {
            wp_enqueue_style( 'quizbookcss', $this->cssAdminPath );                  
        }
    }

    /**
     * Valida si el hook que invoca la función es un post o post-new
     */
    function isValidHook(string $hook){
        return ($hook == 'post-new.php' || $hook == 'post.php');
    }


    /**
     * Verifica si es el posttype correcto (quizbook)
     */
    function isValidPosttype(){
        global $post;
        return ($post->post_type===$this->posttype);
    }

    function getPostTypeName(){
        return $this->posttype;
    }

    function getJsFilePath(){
        return $this->jsFilePath;
    }

    function getCssFrontPath(){
        return $this->cssFrontPath;
    }

    function getCssAdminPath(){
        return $this->cssAdminPath;
    }
}

