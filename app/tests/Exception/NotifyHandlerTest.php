<?php

use Mockery as m;

class NotifyHandlerTest extends PHPUnit_Framework_TestCase {

    public function tearDown()
    {
        m::close();
    }

    /**
     * @expectedException Exception
     */
    public function testHandlerOnlyHandlesImplException()
    {
        $wrongExceptionType = new \Exception('Some Message');
        $mockNotifier = $this->getMockNotifier();
        $notifyHandler = new \Impl\Exception\NotifyHandler( $mockNotifier );

        $notifyHandler->handle( $wrongExceptionType );
    }

    public function testHandlerCallsNotifier()
    {
        $mockNotifier = $this->getMockNotifier();

        // Error if "notify" is not called on this test.
        // Technically, this is testing if NotifierInterface follows
        //   its interface, so it might be an inappropriate test here.
        //   But at least we know NotifyHandler::sendException() is called!
        $mockNotifier->shouldReceive('notify')->once()->andReturn(null);

        $correctExceptionType = new \Impl\Exception\ImplException('A notify message');
        $notifyHandler = new \Impl\Exception\NotifyHandler( $mockNotifier );

        $notifyHandler->handle( $correctExceptionType );
    }

    protected function getMockNotifier()
    {
        $mockNotifier = m::mock('Impl\Service\Notification\NotifierInterface');

        return $mockNotifier;
    }

}