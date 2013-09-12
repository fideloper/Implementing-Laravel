<?php namespace Impl\Service\Notification;

use Services_Twilio;

class SmsNotifier implements NotifierInterface {

    /**
     * Recipient of notification
     * @var string
     */
    protected $to;

    /**
     * Sender of notification
     * @var string
     */
    protected $from;

    /**
     * Twilio SMS SDK
     * @var \Services_Twilio
     */
    protected $twilio;

    public function __construct(Services_Twilio $twilio)
    {
        $this->twilio = $twilio;
    }

    /**
     * Recipients of notification
     * @param  string $to The recipient
     * @return Impl\Service\Notification\SmsNotifier  $this  Return self for chainability
     */
    public function to($to)
    {
        $this->to = $to;

        return $this;
    }

    /**
     * Sender of notification
     * @param  string $from The sender
     * @return Impl\Service\Notification\NotifierInterface  $this  Return self for chainability
     */
    public function from($from)
    {
        $this->from = $from;

        return $this;
    }

    public function notify($subject, $message)
    {
        $sms = $this->twilio
            ->account
            ->sms_messages
            ->create(
                $this->from,
                $this->to,
                $subject."\n".$message
            );
    }

}