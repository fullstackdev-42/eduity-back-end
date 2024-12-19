<?php

namespace App\DataPersister\Security;

use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\UserInvitation;

final class UserInvitationDataPersister implements DataPersisterInterface
{
    /* @var EntityManagerInterface $entityManager */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param UserInvitation $data
     */
    public function supports($data): bool
    {
        return $data instanceof UserInvitation;
    }

    /**
     * @param UserInvitation $data
     */
    public function persist($data)
    {
        if (empty($data->getAcceptCode())) {
            $data->generateAcceptCode();
        }

        $this->entityManager->persist($data);
        $this->entityManager->flush();

        return $data;
    }

    /**
     * @param UserInvitation $data
     */
    public function remove($data)
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}