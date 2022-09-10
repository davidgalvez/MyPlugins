<?php
/**
 * Class TestQuizbookPosttypes
 *
 * @package Quizbook
 */
use \Quizbook\PostType;
/**
 * Test the main logic of Quizbook plugin
 */
class TestQuizbookPosttypes extends WP_UnitTestCase {

	public function setUp():void
    {
		parent::setUp();        
		$this->QuizbookPosttype= new PostType(QUIZBOOK_POSTTYPE_NAME);
       
    }
	public function testPostTypeSetLabels() 
	{		
		$this->assertTrue( $this->QuizbookPosttype->labelsExists() );
	}
    public function testPostTypeSetArguments() 
	{		
		$this->assertTrue($this->QuizbookPosttype->argumentsExists() );
	}
    public function testCorrectArgumentsSet(){       
        $arguments=$this->QuizbookPosttype->getArguments();
        $this->assertEquals($this->QuizbookPosttype->getLabels(), $arguments['labels'], 'Labels doesnt match' );
        
    }
	
}