<?php namespace Impl\Exception;

use Impl\Service\Notification\NotifierInterface;

class NotifyHandler implements HandlerInterface {

    protected $notifier;

    public function __construct(NotifierInterface $notifier)
    {
        $this->notifier = $notifier;
    }

    /**
     * Handle Impl Exceptions
     *
     * @param \Impl\Exception\ImplException
     * @return void
     */
    public function handle(ImplException $exception)
    {
        $this->sendException($exception);
    }

    /**
     * Send Exception to notifier
     * @param  \Exception $exception Send notification of exception
     * @return void
     */
    protected function sendException(\Exception $e)
    {
        $this->notifier->notify('Error: '.get_class($e), $e->getMessage());
    }

}
