<?php
/**
 * @package Quizbook
 */
namespace Quizbook;

class Deactivate{

    private Rol $rol;
    public function __construct()
    {
        $this->rol=new Rol(QUIZBOOK_ROLES_ROL_NAME,QUIZBOOK_ROLES_DISPLAY_NAME);
    }
    
    /**
     * Executes actions ons plugin deactivation
     */
    public function deactivate() 
    {
        $this->rol->removeRol();
        $this->rol->removeCapabilities();
        flush_rewrite_rules();
    }
}