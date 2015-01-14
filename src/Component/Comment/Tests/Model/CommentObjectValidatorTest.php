<?php

namespace Component\Comment\Tests\Model;

use Component\Comment\Model\CommentObjectValidator;
use PHPUnit_Framework_TestCase;

/**
 * Description of CommentObjectValidatorTest
 *
 * @author Вадим
 */
class CommentObjectValidatorTest extends PHPUnit_Framework_TestCase
{

    public function testValidObject()
    {
        $object = $this->getMock( 'Object', array( 'getId' ) );
        
        $validator = new CommentObjectValidator();
        
        $this->assertEquals( $object, $validator->validObject( $object ), 'Method did not return valid object');
        
        $invalidObject = $this->getMockClass( 'Object');
        
        try{
            $validator->validObject( $invalidObject );
            $this->fail('Exception did not thrown for invalid object');
        }
        catch( \InvalidArgumentException $e ){
            $this->assertEquals(0, $e->getCode(), 'Wrong code');
            $this->assertEquals('Non correct object giving', $e->getMessage(), 'Wrong message for exception');
        }
        
        $invalidObject = '';
        
        try{
            $validator->validObject( $invalidObject );
            $this->fail('Exception did not thrown for invalid object');
        }
        catch( \InvalidArgumentException $e ){
            $this->assertEquals(0, $e->getCode(), 'Wrong code');
            $this->assertEquals('Non correct object giving', $e->getMessage(), 'Wrong message for exception');
        }
    }

}
