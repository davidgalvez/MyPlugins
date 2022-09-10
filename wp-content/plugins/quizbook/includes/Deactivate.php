<?php
/**
 * @package Quizbook
 */
namespace Quizbook;

class Deactivate{

    /**
     * Executes actions ons plugin deactivation
     */
    public static function deactivate() 
    {
    
        flush_rewrite_rules();
    }
}