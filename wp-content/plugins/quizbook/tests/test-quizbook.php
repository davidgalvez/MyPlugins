<?php
/**
 * Class TestQuizbook
 *
 * @package Quizbook
 */

/**
 * Test the main logic of Quizbook plugin
 */
class TestQuizbook extends WP_UnitTestCase {

	public function setUp():void
    {
		parent::setUp();

		$this->QuizbookPosttype= new quizbookPostType(QUIZBOOK_POSTTYPE_NAME);

        $this->Quizbook = new quizzbookPlugin($this->QuizbookPosttype);
    }
	public function testPosttypeQuizezIsCreated() 
	{
		$this->Quizbook->initPlugin();
		$this->Quizbook->rewriteFlushPostType();		
		$this->assertTrue( post_type_exists( QUIZBOOK_POSTTYPE_NAME ) );
	}
	public function testMetaboxesCreated() 
	{
		$this->Quizbook->initPlugin();
		$this->Quizbook->addMetaBoxes(QUIZBOOK_METABOX_ID,QUIZBOOK_METABOX_TITLE, QUIZBOOK_METABOX_TEMPLATE_PATH, QUIZBOOK_METABOX_NONCE);
		$prioridad=has_action( 'add_meta_boxes', array($this->Quizbook,'addMetaBox'));
		$this->assertEquals( 10,$prioridad ); //prioridad por defecto de add_action es 10
	}

	public function testSaveMetaboxesAdded() 
	{
		$this->Quizbook->initPlugin();
		$this->Quizbook->addMetaBoxes(QUIZBOOK_METABOX_ID,QUIZBOOK_METABOX_TITLE, QUIZBOOK_METABOX_TEMPLATE_PATH, QUIZBOOK_METABOX_NONCE);
		$this->Quizbook->addSaveMetaBoxes();
		$prioridad=has_action( 'save_post', array($this->Quizbook,'getSaveMetaBox'));
		$this->assertEquals( 10,$prioridad ); //prioridad por defecto de add_action es 10
	}
}