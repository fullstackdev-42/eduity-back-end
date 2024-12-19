<?php
namespace App\DTO\Security;

use Symfony\Component\Validator\Constraints as Assert;
use App\DTO\Security\CodeConfirm;

class ForgotPasswordConfirm
{
    
     /**
     * @var string
     * @Assert\NotBlank(
     *      message = "The id can not be blank"
     * )
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank(
     *      message = "The reset code can not be blank"
     * )
     */
    private $code;

    /**
     * @var string
     * @Assert\NotBlank(
     *      message = "The password can not be blank"
     * )
     * @Assert\Length(
     *      min = 8,
     *      minMessage = "Password length must be at least {{ limit }} characters long",
     * )
     */
    private $password;

    public function getId()
    {
        return $this->id;
    }

    public function setId(string $id)
    {
        $this->id = $id;
        return $this;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setCode(string $code)
    {
        $this->code = $code;
        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
        return $this;
    }
}