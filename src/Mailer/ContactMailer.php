<?php

namespace App\Mailer;

use App\Entity\Contact;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class ContactMailer
{
    private const TEMPLATE = 'email/contact.html.twig';
    private string $contactEmailAddress;
    private MailerInterface $mailer;
    private Environment $twig;

    public function __construct(MailerInterface $mailer, Environment $twig, string $contactEmailAddress)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->contactEmailAddress = $contactEmailAddress;
        dd($mailer, $twig, $contactEmailAddress);
    }

    public function send(Contact $contact): void
    {
        $email = (new Email())
            ->from($contact->getEmail())
            ->to($this->contactEmailAddress)
            ->subject('Un message de contact sur Shoefony')
            ->html($this->twig->render(self::TEMPLATE, [
                'contact' => $contact
            ]));

        $this->mailer->send($email);
    }

}