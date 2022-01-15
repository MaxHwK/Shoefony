<?php

namespace App\Manager;

use App\Entity\Contact;
use App\Mailer\ContactMailer;
use Doctrine\ORM\EntityManagerInterface;

class ContactManager
{
    private EntityManagerInterface $em;
    private ContactMailer $contactMailer;

    public function __construct(EntityManagerInterface $em, ContactMailer $contactMailer)
    {
        $this->em = $em;
        $this->contactMailer = $contactMailer;
    }

    public function insert(Contact $contact)
    {
        $this->em->persist($contact);
        $this->contactMailer->send($contact);
        $this->em->flush();
    }
}