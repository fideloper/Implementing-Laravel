<?php

class ImplException extends PHPUnit_Framework_TestCase {

    public function testExceptionisException()
    {
        $implException = new \Impl\Exception\ImplException;

        $this->assertInstanceOf('Exception', $implException);
    }

}