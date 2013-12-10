<?php

use Mockery as m;
use \Impl\Service\Validation\LaravelValidatorStub;

class ValidatorTest extends PHPUnit_Framework_TestCase {

    public function tearDown()
    {
        m::close();
    }

    /**
     * Test we need Laravel's Validation
     *  Factory as a dependency
     *
     *  @expectedException Exception
     */
    public function testLaravelValidatorThrowsExceptionOnWrongDependency()
    {
        $wrongDependency = new StdClass(); // Not Illuminate\Validation\Factory
        $stub = new LaravelValidatorStub( $wrongDependency );
    }

    /**
     * Test that the with() method
     *  throws an exception if not passed an array
     *
     *  @expectedException Exception
     */
    public function testWithMethodThrowsExceptionIfNotArray()
    {
        $stub = new LaravelValidatorStub( $this->getMockValidatorFactory() );

        $stub->with( "I'm not an array" );
    }

    protected function getMockValidatorFactory()
    {
        return m::mock('Illuminate\Validation\Factory');
    }
}