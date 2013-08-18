<?php namespace Impl\Exception;

interface HandlerInterface {

    /**
     * Handle Impl Exceptions
     *
     * @param \Impl\Exception\ImplException
     * @return void
     */
    public function handle(ImplException $exception);

}