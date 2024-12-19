<?php
namespace App\DTO\Security;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

class CodeConfirm 
{
    /**
     * @var string
     * @Assert\NotBlank(
     *      message = "The id can not be blank"
     * )
     * @Groups({"read", "write"})
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank(
     *      message = "The reset code can not be blank"
     * )
     * @Groups({"read", "write"})
     */
    private $code;

    /**
     * @var string
     */
    private $type;

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

    public function getType()
    {
        return $this->type;
    }

    public function setType(string $type)
    {
        $this->type = $type;
        return $this;
    }
}