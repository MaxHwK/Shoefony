<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Contact
{
    /**
     * @var string
     * 
     * @Assert\NotBlank(message="Ce champ ne peut pas être vide.")
     */
    private $firstName;

    /**
     * @var string
     * 
     * @Assert\NotBlank(message="Ce champ ne peut pas être vide.")
     */
    private $lastName;

    /**
     * @var string
     * 
     * @Assert\NotBlank(message="Ce champ ne peut pas être vide.")
     * @Assert\Email(message="L'email {{ value }} n'est pas valide.")
     */
    private $email;

    /**
     * @var string
     * 
     * @Assert\NotBlank(message="Ce champ ne peut pas être vide.")
     * @Assert\Length(min="25", minMessage="Votre message doit contenir au minimum {{ limit }} caractères.")
     */
    private $message;

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message): self
    {
        $this->message = $message;
        return $this;
    }

}
