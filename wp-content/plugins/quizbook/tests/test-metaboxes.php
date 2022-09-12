<?php
/**
 * Class TestQuizbookMetaboxes
 *
 * @package Quizbook
 */

use Quizbook\Metabox;

/**
 * Test logic of Metaboxes class
 */
class TestQuizbookMetaboxes extends WP_UnitTestCase {

	public function setUp():void
    {
		parent::setUp();        
		$this->QuizbookMetabox=new Metabox(QUIZBOOK_METABOX_ARGS);        
       
    }
	public function testSetId() 
	{        	
		$this->assertEquals( $this->QuizbookMetabox->getId(), QUIZBOOK_METABOX_ARGS["id"], 'Metabox Ids doesnt match' );
	}
    public function testSetTitle()
    {
        $this->assertEquals( $this->QuizbookMetabox->getTittle(), QUIZBOOK_METABOX_ARGS["title"], 'Metabox Tittles doesnt match' );
    }
    public function testTemplatePath()
    {
        $this->assertEquals( $this->QuizbookMetabox->getTemplate(), QUIZBOOK_METABOX_ARGS["template_path"], 'Metabox Template Path doesnt match' );
        $this->assertFileExists($this->QuizbookMetabox->getTemplate(),'Metabox Template file doesnt exist');
    }
    
	
}