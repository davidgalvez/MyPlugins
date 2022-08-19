<?php
if(! defined('ABSPATH')) exit();

class quizbookShortcode{
    private string $posttype;
    private string $templatePath;
    //private array $attributes;

    function __construct(string $posttype, string $templatePath)
    {
        $this->posttype=$posttype;
        $this->templatePath=$templatePath;        
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
        //$output= "Funciona";
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