<?php
/**
 * Class TestQuizbookScripts
 *
 * @package Quizbook
 */

/**
 * Test logic of Quizbook scrripts class
 */
class TestQuizScripts extends WP_UnitTestCase {

	public function setUp():void
    {
		parent::setUp();        
		$this->QuizbookScripts=new quizbookScripts(QUIZBOOK_POSTTYPE_NAME,QUIZBOOK_SCRIPTS_PATH,QUIZBOOK_CSS_FRONT_PATH, QUIZBOOK_CSS_ADMIN_PATH);        
       
    }
	
    public function testSetPostType()
    {
        $this->assertEquals( $this->QuizbookScripts->getPostTypeName(), QUIZBOOK_POSTTYPE_NAME, 'Scripts Posttypes doesnt match' );
    }
    public function testScriptsPath()
    {
        $this->assertEquals( $this->QuizbookScripts->getJsFilePath(), QUIZBOOK_SCRIPTS_PATH, 'Scripts Javascript paths doesnt match' );
        $this->assertTrue($this->url_exists($this->QuizbookScripts->getJsFilePath()),'Scripts Javascript file doesnt exist');        
    }

    public function testCssPaths()
    {
        $this->assertEquals( $this->QuizbookScripts->getCssFrontPath(), QUIZBOOK_CSS_FRONT_PATH, 'Scripts CSS front paths doesnt match' );
        $this->assertTrue($this->url_exists($this->QuizbookScripts->getCssFrontPath()),'Scripts  CSS front file doesnt exist');  
        
        $this->assertEquals( $this->QuizbookScripts->getCssAdminPath(), QUIZBOOK_CSS_ADMIN_PATH, 'Scripts CSS Admin paths doesnt match' );
        $this->assertTrue($this->url_exists($this->QuizbookScripts->getCssAdminPath()),'Scripts  CSS front Admin doesnt exist');
    }
    

    private function url_exists($url) {
        return curl_init($url) !== false;
    }
    
	
}