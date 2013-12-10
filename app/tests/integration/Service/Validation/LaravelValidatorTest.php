<?php

/*
 * Test uses the LaravelValidatorStub class
 * for the integration test
 *
 * Rules:
 *
 * protected $rules = array(
 *     'name' => 'required',
 *     'email' => 'email|required',
 *     'message' => 'required',
 * );
 */

use \Impl\Service\Validation\LaravelValidatorStub;

class LaravelValidatorTest extends TestCase {

    /**
     * Test a passing test passes
     *
     */
    public function testPassingValidator()
    {
        $stub = new LaravelValidatorStub( App::make('validator') );

        $data = $this->getPassingData();

        $this->assertTrue( $stub->with( $data )->passes() );
    }

    /**
     * Test a failing test fails
     *
     */
    public function testFailingValidator()
    {
        $stub = new LaravelValidatorStub( App::make('validator') );

        $data = $this->getFailingData();

        $this->assertFalse( $stub->with( $data )->passes() );
    }

    /**
     * Test a failing test returns error messages
     *
     */
    public function testFailingValidatorHasErrors()
    {
        $stub = new LaravelValidatorStub( App::make('validator') );

        $data = $this->getFailingData();

        // False, will have errors, assuming
        // test 'testFailingValidator' passes
        $stub->with( $data )->passes();

        // @link Illuminate\Support\MessageBag
        $errors = $stub->errors();

        // We need to know that there are 2 errors, but
        // don't care what they are for this test.
        // Laravel's testing class is already unit tested
        $this->assertEquals(2, count($errors));
    }

    protected function getPassingData()
    {
        return array(
            'name' => 'Chris',
            'email' => 'fideloper@gmail.com',
            'message' => 'Only you can prevent forest fires',
        );
    }

    protected function getFailingData()
    {
        return array(
            'name' => null, // Incorrect, required
            'email' => 'this is not an email', // Incorrect, this is not an email
            'message' => 'Only you can prevent forest fires', // Correct
        );
    }

}