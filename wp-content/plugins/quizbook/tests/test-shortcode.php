<?php
/**
 * Class TestQuizbookShortcode
 *
 * @package Quizbook
 */

/**
 * Test logic of Shortcode class
 */
class TestQuizbookShortcode extends WP_UnitTestCase {

	public function setUp():void
    {
		parent::setUp();        
		$this->QuizbookShortcode=new quizbookShortcode(QUIZBOOK_POSTTYPE_NAME,QUIZBOOK_SHORTCODE_TEMPLATE_PATH);        
       
    }
	
    public function testSetPostType()
    {
        $this->assertEquals( $this->QuizbookShortcode->getpostType(), QUIZBOOK_POSTTYPE_NAME, 'Shortcode Posttypes doesnt match' );
    }
    public function testTemplatePath()
    {
        $this->assertEquals( $this->QuizbookShortcode->getTemplatePath(), QUIZBOOK_SHORTCODE_TEMPLATE_PATH, 'Shortcode template paths doesnt match' );
        $this->assertFileExists($this->QuizbookShortcode->getTemplatePath(),'Shortcode Template file doesnt exist');
    }
    
	
}