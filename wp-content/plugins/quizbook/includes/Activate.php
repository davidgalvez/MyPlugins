<?php
/**
 * @package Quizbook
 */
namespace Quizbook;


class Activate{

    private Rol $rol;
    public function __construct()
    {
        $this->rol=new Rol(QUIZBOOK_ROLES_ROL_NAME,QUIZBOOK_ROLES_DISPLAY_NAME);
    }    

    /**
     * Executes actions on plugin activation
     */
    public function activate() 
    {       
        $this->rol->createRol();
        $this->rol->addCapabilities();
        flush_rewrite_rules();
    }
}