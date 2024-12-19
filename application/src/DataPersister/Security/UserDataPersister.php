<?php

namespace App\DataPersister\Security;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\User;

final class UserDataPersister implements DataPersisterInterface
{
    /* @var EntityManagerInterface $entityManager */
    private $entityManager;
    /* @var UserPasswordEncoderInterface $passwordEncoder */
    private $passwordEncoder;

    public function __construct(EntityManagerInterface $entityManager, 
        UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param User $data
     */
    public function supports($data): bool
    {
        return $data instanceof User;
    }

    /**
     * @param User $data
     */
    public function persist($data)
    {
        if (!empty($data->getPlainPassword())) {
            $data->setPassword(
                $this->passwordEncoder->encodePassword($data, $data->getPlainPassword())
            );
            $data->eraseCredentials();
        }

        //generate email confirm
        if (empty($data->getEmailConfirmationCode())) {
            $data->generateEmailConfirmationCode();
        }

        $this->entityManager->persist($data);
        $this->entityManager->flush();

        return $data;
    }

    /**
     * @param User $data
     */
    public function remove($data)
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}