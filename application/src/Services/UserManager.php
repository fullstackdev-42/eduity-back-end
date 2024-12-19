<?php

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use Exception;

class UserManager {
    protected $entityManager;
    protected $passwordEncoder;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator, UserPasswordEncoderInterface $passwordEncoder) {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * Creates user
     */
    public function createUser(User $user, bool $validate = true, bool $flush = true): self {
        if ($validate) {
            $violations = $this->validator->validate($user);
            if (count($violations) > 0) {
                $errors = [];
                foreach ($violations as $violation) {
                    $errors[] = $violation->getMessage();
                }

                $err = implode("\n", $errors);
                throw new \Exception($user->getEmail() .": User failed validation. \n". $err);
            }
        }

        if ($user->getPlainPassword() !== null) {
            $user->setPassword(
                $this->passwordEncoder->encodePassword(
                    $user,
                    $user->getPlainPassword()
                )
            );
        }

        $this->entityManager->persist($user);
        if ($flush) {
            $this->entityManager->flush();
        }

        return $this;
    }

    public function updateUser(User $user, bool $validate = true, bool $flush = true): self {
        /** @var User $newuser */
        $newuser = $this->entityManager->getRepository(User::class)->findOneByEmail($user->getEmail());
        if (!$newuser) {
            throw new \Exception('Can not find user by email');
        }

        $newuser->setPlainPassword($user->getPlainPassword());
        $this->createUser($newuser, $validate, $flush);

        return $this;
    }

}