<?php
namespace App\DataTransformer\ACL;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Security\Exception\InvalidIdentityException;
use App\DataTransformer\Traits\SafeClassnameTrait;
use App\DTO\ACL\SecurityResourceDTO;
use App\Entity\ACL\Interfaces\IdentityInterface;
use App\Entity\ACL\SecurityResource;

final class SecurityResourceOutputDataTransformer implements DataTransformerInterface
{
    use SafeClassnameTrait;

    /** @var EntityManagerInterface $em */
    private $em;


    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param SecurityResource $data
     * {@inheritdoc}
     */
    public function transform($data, string $to, array $context = [])
    {

        //var_dump([$data->getIdentityClass(), $data->getIdentityId()]);

        /** @var IdentityInterface */
        $identityObj = $this->em->getRepository($data->getIdentityClass())
            ->findOneById(6);//)$data->getIdentityId());
    
        if (!$identityObj) {
            throw new InvalidIdentityException('Identity can not be null!');
        } else if (!$identityObj instanceof IdentityInterface) {
            throw new InvalidIdentityException($identityObj->getUuid() .' is not an identity!');
        }

        $subjectObj = $this->em->getRepository($data->getSubjectClass())
            ->findOneById($data->getSubjectId());

        $secResourceDTO = new SecurityResourceDTO();
        $secResourceDTO
            ->setId($data->getUuid())
            ->setIdentity($identityObj)
            ->setSubject($subjectObj)
            ->setPermissions($data->getPermissions());
        
        return $secResourceDTO;
    }

    /**
     * @param SecurityResource $data
     * {@inheritdoc}
     */
    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return $data instanceof SecurityResource && SecurityResourceDTO::class === $to;
    }

}