<?php Impl\Service\Notification;

use Twilio\Sms;

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
     * @var \Twilio\Sms
     */
    protected $twilio;

    public function __construct(Sms $twilio)
    {
        $this->twilio = $twilio;
    }

    /**
     * Recipients of notification
     * @param  string $to The recipient
     * @return Impl\Service\Notificaton\SmsNotifier  $this  Return self for chainability
     */
    public function to($to)
    {
        $this->to = $to;

        return $this;
    }

    /**
     * Sender of notification
     * @param  string $from The sender
     * @return Impl\Service\Notificaton\NotifierInterface  $this  Return self for chainability
     */
    public function from($from)
    {
        $this->from = $from;

        return $this;
    }

    public function notify($subject, $message)
    {
        $this->twilio->send( array(
            'to' => $this->to,
            'from' => $this->from,
            'text' => $this->subject."\n".$this->message,
        ) );
    }

}