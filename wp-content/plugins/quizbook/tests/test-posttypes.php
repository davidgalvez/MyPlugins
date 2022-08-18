<?php
/**
 * Class TestQuizbookPosttypes
 *
 * @package Quizbook
 */

/**
 * Test the main logic of Quizbook plugin
 */
class TestQuizbookPosttypes extends WP_UnitTestCase {

	public function setUp():void
    {
		parent::setUp();        
		$this->QuizbookPosttype= new quizbookPostType('quizes');
       
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