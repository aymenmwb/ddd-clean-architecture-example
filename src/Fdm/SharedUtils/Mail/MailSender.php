<?php

namespace Fdm\SharedUtils\Mail;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class MailSender
{
    /**
     * @var MailerInterface
     */
    private $mailer;

    /**
     * @var ParameterBagInterface
     */
    private $params;

    public function __construct(MailerInterface $mailer, ParameterBagInterface $params)
    {
        $this->mailer = $mailer;
        $this->params = $params;
    }

    /**
     * @param $subject
     * @param $recipients
     * @param $body
     */
    public function send($subject, $recipients, $body)
    {
        $mailConfig = $this->params->get('mail');
        $senderMail = $mailConfig['sender_email'];
        $senderName = $mailConfig['sender_name'];

        $message = new Email();
        $message->subject($subject);
        $message->from(new Address($senderMail, $senderName));

        $message->sender(new Address($senderMail, $senderName));

        foreach ($recipients as $recipient)
        {
            $message->addTo(new Address($recipient));
        }

        $message->html($body, 'text/html');

        $this->mailer->send($message);

    }
}