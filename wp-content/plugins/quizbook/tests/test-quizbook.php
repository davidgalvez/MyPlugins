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

        $this->Quizbook = new quizzbookPlugin(QUIZBOOK_POSTTYPE_NAME);
    }
	public function testPosttypeQuizezIsCreated() 
	{
		$this->Quizbook->postType->addToPlugin();			
		$this->assertTrue( post_type_exists( QUIZBOOK_POSTTYPE_NAME ) );
	}
	public function testMetaboxesCreated() 
	{
		$this->Quizbook->postType->addToPlugin();
		$this->Quizbook->metaBox->addToPlugin();
		$prioridad=has_action( 'add_meta_boxes', array($this->Quizbook->metaBox,'addToMetaboxList'));
		$this->assertEquals( 10,$prioridad ); //prioridad por defecto de add_action es 10
	}

	public function testSaveMetaboxesAdded() 
	{
		$this->Quizbook->postType->addToPlugin();
		$this->Quizbook->metaBox->addToPlugin();
		$prioridad=has_action( 'save_post', array($this->Quizbook->metaBox,'saveMetabox'));
		$this->assertEquals( 10,$prioridad ); //prioridad por defecto de add_action es 10
	}
}