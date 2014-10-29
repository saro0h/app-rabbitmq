<?php

namespace Poledev\AsynchronousBundle\Component;

use OldSound\RabbitMqBundle\RabbitMq\Producer;

class Mailer
{
    private $mailerProducer;

    private $sender;

    public function __construct($sender, Producer $mailerProducer)
    {
        $this->sender = $sender;
        $this->mailerProducer = $mailerProducer;
    }

    public function sendEmail($recipient, $subject, $emailContent, $template)
    {
        $infoEmail = array(
            'recipient' => $recipient,
            'subject'   => $subject,
            'sender'    => $this->sender,
            'template'  => $template,
            'params'    => array('message' => $emailContent),
        );

        // Publish message
        $this->mailerProducer->publish(json_encode($infoEmail));

        return true;
    }
}
