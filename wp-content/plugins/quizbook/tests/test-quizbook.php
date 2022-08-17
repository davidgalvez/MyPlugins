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

		$this->QuizbookPosttype= new quizbookPostType('quizes');

        $this->Quizbook = new quizzbook($this->QuizbookPosttype);
    }
	public function testPosttypeQuizezIsCreated() 
	{
		$this->Quizbook->initPlugin();
		$this->Quizbook->rewriteFlushPostType();		
		$this->assertTrue( post_type_exists( 'quizes' ) );
	}
	public function testMetaboxesCreated() 
	{
			
		$prioridad=has_action( 'add_meta_boxes', 'quizbook_agregar_metaboxes');
		$this->assertEquals( 10,$prioridad ); //prioridad por defecto de add_action es 10
	}
}