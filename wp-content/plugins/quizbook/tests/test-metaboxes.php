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
		$this->QuizbookMetabox=new Metabox(QUIZBOOK_METABOX_ID,QUIZBOOK_METABOX_TITLE,QUIZBOOK_METABOX_TEMPLATE_PATH, QUIZBOOK_METABOX_NONCE);        
       
    }
	public function testSetId() 
	{        	
		$this->assertEquals( $this->QuizbookMetabox->getId(), QUIZBOOK_METABOX_ID, 'Metabox Ids doesnt match' );
	}
    public function testSetTitle()
    {
        $this->assertEquals( $this->QuizbookMetabox->getTittle(), QUIZBOOK_METABOX_TITLE, 'Metabox Tittles doesnt match' );
    }
    public function testTemplatePath()
    {
        $this->assertEquals( $this->QuizbookMetabox->getTemplate(), QUIZBOOK_METABOX_TEMPLATE_PATH, 'Metabox Tittles doesnt match' );
        $this->assertFileExists($this->QuizbookMetabox->getTemplate(),'Metabox Template file doesnt exist');
    }
    
	
}