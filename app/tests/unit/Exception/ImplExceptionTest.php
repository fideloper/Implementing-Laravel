<?php

class ImplException extends PHPUnit_Framework_TestCase {

    /**
     * Make sure our ImplException is actually an exception.
     * Because...test everything.
     *
     * Remember kids, not all unit tests are necessary. 100% code
     * coverage isn't always a worthy goal.
     *
     */
    public function testExceptionisException()
    {
        $implException = new \Impl\Exception\ImplException;

        $this->assertInstanceOf('Exception', $implException);
    }

}