<?php
/**
 * @package Quizbook
 */
namespace Quizbook;
use \WP_Query;
if(! defined('ABSPATH')) exit();

class Shortcode{
    private string $posttype;
    private string $templatePath;
    //private array $attributes;

    function __construct(string $posttype, string $templatePath)
    {
        $this->posttype=$posttype;
        $this->templatePath=$templatePath;        
    }

    /**
     * Add shortcode to plugin
     */
    public function addToPlugin()
    {
        add_shortcode("quizbook", array($this->shortcode, "createShortCode"));
    }

     /**
     * Crea un shortcode, uso [quizbook preguntas="" orden=""]
     */
    function createShortcode($attributes){
        $args = array(
            'post_type' => $this->posttype,
            'posts_per_page' => $attributes["preguntas"],
            'orderby' => $attributes["orden"]
        );
        
        $quizbook =new WP_Query($args);
        ob_start();
        
        $this->renderTemplate($quizbook);

        $output = ob_get_clean();
        return $output;
    }

    function renderTemplate(WP_Query $quizbook){
        include $this->templatePath;        
    }

    function getTemplatePath(){
        return $this->templatePath;
    }

    function getPosttype(){
        return $this->posttype;
    }
}

?>