<?php
namespace App\Services\DoctrineExtensions;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\Security;
use App\Entity\User;
use App\Entity\Interfaces\OwnerableInterface;


final class OwnerCollectionExtension implements QueryCollectionExtensionInterface
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null): void
    {
        $this->addWhere($queryBuilder, $resourceClass);
    }

    private function addWhere(QueryBuilder $queryBuilder, string $resourceClass): void
    {

        /**
         * @var User $user
         */
        //skip object if it doesn't has owner or user properties
        //TODO: this needs to handle ACL
        if ((!is_subclass_of($resourceClass, OwnerableInterface::class) && !method_exists($resourceClass, 'getUser')) 
            || $this->security->isGranted('ROLE_ADMIN')  || null === $user = $this->security->getUser()) {
            return;
        }

        $rootAlias = $queryBuilder->getRootAliases()[0];
        $queryBuilder->andWhere(sprintf('%s.user = :current_user', $rootAlias));
        $queryBuilder->setParameter('current_user', $user->getId());
    }
}