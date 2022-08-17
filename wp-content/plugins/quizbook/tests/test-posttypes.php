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
		$this->assertFalse( $this->QuizbookPosttype->labelsExists() );
        $this->QuizbookPosttype->setLabels(); 
		$this->assertTrue( $this->QuizbookPosttype->labelsExists() );
	}
    public function testPostTypeSetArguments() 
	{		
		$this->QuizbookPosttype->setLabels();
        $this->assertFalse($this->QuizbookPosttype->argumentsExists() );
        $this->QuizbookPosttype->setArguments(); 
		$this->assertTrue($this->QuizbookPosttype->argumentsExists() );
	}
    public function testCorrectArgumentsSet(){
        $this->QuizbookPosttype->setLabels();
        $this->QuizbookPosttype->setArguments();
        $arguments=$this->QuizbookPosttype->getArguments();
        $this->assertEquals($this->QuizbookPosttype->getLabels(), $arguments['labels'], 'Labels doesnt match' );
        
    }
	
}