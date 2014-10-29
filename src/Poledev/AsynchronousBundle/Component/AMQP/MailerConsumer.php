<?php

namespace Poledev\AsynchronousBundle\Component\AMQP;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\Templating\EngineInterface;
use Psr\Log\LoggerInterface;

class MailerConsumer implements ConsumerInterface
{
    private $mailer;

    private $templating;

    private $logger;

    public function __construct(\Swift_Mailer $mailer, EngineInterface $templating, LoggerInterface $logger)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->logger = $logger;
    }

    /**
     *  Main execute method
     *  Execute actiosn for a given message
     *
     *  @param (AMQPMessage) $msg       An instance of `PhpAmqpLib\Message\AMQPMessage` with the $msg->body being the data sent over RabbitMQ.
     *
     *  @return (boolean) Execution status (true if everything's of, false if message should be re-queued)
     */
    public function execute(AMQPMessage $msg)
    {
        $mailInformation = json_decode($msg->body);

        try {
            $message = \Swift_Message::newInstance()
                ->setSubject($mailInformation->subject)
                ->setFrom($mailInformation->sender)
                ->setTo($mailInformation->recipient)
                ->setContentType('text/html')
                ->setBody($this->templating->render($mailInformation->template, array('params' => $mailInformation->params)))
            ;

            $this->mailer->send($message);

            $this->logger->info(sprintf('The email has been sent to "%s"', $mailInformation->recipient));

            //return true;
        } catch (\Swift_TransportException $e) {
            $this->logger->critical(sprintf('The email was not sent for "%s". Context: "%s"', $mailInformation->recipient, $e->getMessage()));

            return false;
        }
    }
}
