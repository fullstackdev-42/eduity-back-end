<?php
namespace App\DTO\Security;

use Symfony\Component\Validator\Constraints as Assert;

class ForgotPasswordRequest 
{
    /**
     * @var string
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     mode = "strict"
     * )
     * @Assert\NotBlank(
     *      message = "The email can not be blank"
     * )
     */
    private $email;

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
        return $this;
    }
}