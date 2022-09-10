<?php
/**
 * @package Quizbook
 */
namespace Quizbook;

class Activate{

    /**
     * Executes actions ons plugin activation
     */
    public static function activate() 
    {
    
        flush_rewrite_rules();
    }
}