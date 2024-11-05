<?php

namespace App\Bundles\MainBundle\Entity;

class WebsiteUser
{
    /**
     *
     * Temporary, not tracked
     *
     * @var string
     */
    public $plainPassword;

    /**
     *
     * Temporary, not tracked
     *
     * @var string
     */
    public $passwordResetLink;

    protected $username;


    public function __construct()
    {
        $this->username = 'demo-user@mail.com';
        $this->plainPassword = '1234567891';
        $this->passwordResetLink = 'https://website.com/user/resetpassword/afc2d123412608508c9cec8b';
    }

    public function getPlainPassword(): string
    {
        return $this->plainPassword;
    }

    public function getPasswordResetLink(): string
    {
        return $this->passwordResetLink;
    }

    public function getUsername()
    {
        return $this->username;
    }
}