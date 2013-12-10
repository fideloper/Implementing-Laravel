<?php namespace Impl\Service\Validation;

/**
 * A stub for integration-testing LaravelValidator
 */

class LaravelValidatorStub extends AbstractLaravelValidator {

    /**
     * Validation rules
     *
     * @var Array
     */
    protected $rules = array(
        'name' => 'required',
        'email' => 'email|required',
        'message' => 'required',
    );

}