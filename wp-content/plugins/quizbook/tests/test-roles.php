<?php
/**
 * Class TestQuizbookRoles
 *
 * @package Quizbook
 */

/**
 * Test logic of Roles class
 */
class TestQuizbookRoles extends WP_UnitTestCase {

	public function setUp():void
    {
		parent::setUp();        
		$this->QuizbookRoles=new quizbookRoles(QUIZBOOK_ROLES_ROL_NAME,QUIZBOOK_ROLES_DISPLAY_NAME);      
       
    }
	public function testSetRolName() 
	{   
        //$this->QuizbookRoles->createRol();             	
		$this->assertEquals( $this->QuizbookRoles->getRolName(), QUIZBOOK_ROLES_ROL_NAME, 'Rol names doesnt match' );
	}
    public function testSetRolDisplayName()
    {
        $this->assertEquals( $this->QuizbookRoles->getRolDisplayName(), QUIZBOOK_ROLES_DISPLAY_NAME, 'Role Display Names doesnt match' );
    }
	
}