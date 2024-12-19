<?php
namespace App\DataTransformer\ACL;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use ApiPlatform\Core\Exception\InvalidArgumentException;
use ApiPlatform\Core\Serializer\AbstractItemNormalizer;
use App\Security\Identity\UserSecurityIdentity;
use App\Security\Identity\GroupSecurityIdentity;
use App\Security\Identity\SubjectIdentity;
use App\DataTransformer\Traits\SafeClassnameTrait;
use App\DTO\ACL\SharingDTO;
use App\Entity\ACL\Group;
use App\Entity\ACL\Permission;
use App\Entity\ACL\SecurityResource;
use App\Entity\User;

final class SecurityResourceInputDataTransformer implements DataTransformerInterface
{
    use SafeClassnameTrait;

    /** @var EntityManagerInterface */
    private $em;
    /** @var ParameterBagInterface */
    private $paramsBag;

    public function __construct(EntityManagerInterface $em, ParameterBagInterface $paramsBag)
    {
        $this->em = $em;
        $this->paramsBag = $paramsBag;
    }

    /**
     * @param SecurityResourceDTO $data
     * {@inheritdoc}
     */
    public function transform($data, string $to, array $context = [])
    {
        /** @var SecurityResource */
        $secResource = null;

        if (($context['collection_operation_name'] ?? null) === 'post') {
            //create security resource object
            $identityName = $this->verifyClassname($data->getIdentityClassname(), 'ACL.identities');
            $subjectName = $this->verifyClassname($data->getSubjectClassname(), 'ACL.subjects');
            
            if ($identityName === null || $subjectName === null) {
                throw new InvalidArgumentException("Identity name: $identityName or Subject name: $subjectName is not valid." , 400);
            }
    
            $identityObj = $this->em->getRepository($identityName)
                ->findOneByUuid($data->getIdentityId());
            $subjectObj = $this->em->getRepository($subjectName)
                ->findOneByUuid($data->getSubjectId());
    
            if ($identityObj instanceof User) {
                $identity = UserSecurityIdentity::fromAccount($identityObj);
            } else if ($identityObj instanceof Group) {
                $identity = GroupSecurityIdentity::fromAccount($identityObj);
            } 
            $subjectIdentity = SubjectIdentity::fromObject($subjectObj);
    
            /** @var App/Repository/ACL/SharingRepository */
            $secResourceRepo = $this->entityManager->getRepository(Group::class);
            $secResource = $secResourceRepo->findBySubject($data->getSubjectClassname(), $data->getSubjectId());
            if ($secResource) {
                throw new UnprocessableEntityHttpException('Already sharing for subject '. $data->getSubjectId());
            } else {
            
                $secResource = new SecurityResource();
                $secResource->setSubjectClass($subjectIdentity->getType())
                    ->setSubjectId($subjectIdentity->getIdentifier())
                    ->setIdentityClass($identity->getType())
                    ->setIdentityName($identityObj->getUuid()) //use the object id itself as FXP implemention uses the identity name.
                ;
            }

        } else {
            $secResource = $context[AbstractItemNormalizer::OBJECT_TO_POPULATE];
        }

        if ($secResource && (($context['collection_operation_name'] ?? null) === 'post' ||
            ($context['item_operation_name'] ?? null) === 'patch'
        )) {
            /** @var App/Repository/ACL/PermissionRepository */
            $permissionRepo = $this->entityManager->getRepository(Permission::class);
            $permissions = $permissionRepo->findByPossibleOperations($data->getPermissionOperations);

            //set permissions
            $secResource->getPermissions()->clear();
            foreach ($permissions as $perm) {
                $secResource->addPermission($perm);
            }

            $secResource->setRoles($data->getRoles());
        }

        return $secResource;
    }

    /**
     * @param SharingDTO $data
     * {@inheritdoc}
     */
    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        // in the case of an input, the value given here is an array (the JSON decoded).
        // if it's a book we transformed the data already
        if ($data instanceof SecurityResource) {
          return false;
        }

        return SecurityResource::class === $to && null !== ($context['input']['class'] ?? null);
    }

}