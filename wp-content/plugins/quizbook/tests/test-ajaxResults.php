<?php
/**
 * Class TestquizbookAjaxResults
 *
 * @package Quizbook
 */

/**
 * Test the main logic of Quizbook plugin
 */
class TestQuizbookAjaxResults extends WP_UnitTestCase {

	public function setUp():void
    {
		parent::setUp();        
		$this->QuizbookAjaxResults= new quizbookAjaxResults(QUIZBOOK_MINIMUN_SCORE, QUIZBOOK_MIN_VALID_SCORE, QUIZBOOK_MAX_VALID_SCORE);
       
    }
	public function testSetNotaMinima() 
	{                       	
		$this->assertEquals( $this->QuizbookAjaxResults->getNotaMinima(), QUIZBOOK_MINIMUN_SCORE, 'Quizbook minimun score doesnt match' );
	}
    public function testValidNotaMinima() 
	{		
		$this->assertEquals($this->QuizbookAjaxResults->setValidNotaMinima(-5), QUIZBOOK_MIN_VALID_SCORE);
        $this->assertEquals($this->QuizbookAjaxResults->setValidNotaMinima(200), QUIZBOOK_MAX_VALID_SCORE);
	}
    public function testValidMessageAproved()
    {
        $scoreNotPass=QUIZBOOK_MINIMUN_SCORE-1;
        $scorePass=QUIZBOOK_MINIMUN_SCORE+1;
        $this->assertEquals( $this->QuizbookAjaxResults->messageAproved($scoreNotPass), 'desaprobado', 'Not Pass Score message result doesnt match' );
        $this->assertEquals( $this->QuizbookAjaxResults->messageAproved($scorePass), 'aprobado', 'Pass Score message result doesnt match' );
    }
    
	
}