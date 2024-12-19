<?php

namespace App\DTO\ACL;

use ApiPlatform\Core\Annotation\ApiProperty;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\UuidInterface;
use App\Entity\ACL\Interfaces\IdentityInterface;

class SecurityResourceDTO
{
    /**
     * @var UuidInterface
     *  @ApiProperty(identifier=true)
     */
    private $id;

    /** 
     * @var object 
     *  @ApiProperty(readableLink=false, writableLink=false)
     */
    private $subject;

    /** 
     * @var IdentityInterface 
     *  @ApiProperty(readableLink=false, writableLink=false)
     */ 
    private $identity;

    /**
     * @var Collection 
     */
    private $permissions;

    public function getId(): UuidInterface
    {
        return $this->id;
    }
    
    public function setId(UuidInterface $id): self 
    {
        $this->id = $id;
        return $this;
    }
        
    public function getSubject(): object 
    {
        return $this->subject;
    }
            
    public function setSubject(object $subject): self 
    {
        $this->subject = $subject;
        return $this;
    }
        
    public function getIdentity(): IdentityInterface 
    {
        return $this->identity;
    }
            
    public function setIdentity(IdentityInterface $identity): self 
    {
        $this->identity = $identity;
        return $this;
    }
        
    public function getPermissions(): Collection
    {
        return $this->permissions;
    }
            
    public function setPermissions(Collection $permissions): self 
    {
        $this->permissions = $permissions;
        return $this;
    }
}