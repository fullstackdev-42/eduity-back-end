<?php

namespace App\EventSubscriber\Security;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\EventListener\EventPriorities;
use App\Services\Mailer\UserAuthMailer;
use App\DTO\Security\ForgotPasswordRequest;
use App\DTO\Security\ForgotPasswordConfirm;
use App\Repository\UserRepository;
use App\Entity\User;

final class ForgotPasswordSubscriber implements EventSubscriberInterface
{
    /* @var EntityManagerInterface $entityManager */
    private $entityManager;
    /* @var UserPasswordEncoderInterface $passwordEncoder */
    private $passwordEncoder;
    /* @var UserAuthMailer $mailer */
    private $mailer;


    public function __construct(EntityManagerInterface $entityManager, 
        UserPasswordEncoderInterface $passwordEncoder, 
        UserAuthMailer $mailer)
    {
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
        $this->mailer = $mailer;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['handleForgotPasswordRequest', EventPriorities::PRE_WRITE],
            KernelEvents::VIEW => ['handleForgotPasswordConfirm', EventPriorities::PRE_WRITE],
        ];
    }

    public function handleForgotPasswordRequest(ViewEvent $event)
    {
        /* @var ForgotPasswordRequest $fpr */
        $fpr = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$fpr instanceof ForgotPasswordRequest || Request::METHOD_POST !== $method) {
            return;
        }

        /** @var UserRepository $userRepo */
        $userRepo = $this->entityManager->getRepository(User::class);
        /** @var User $user */
        $user = $userRepo->findOneByEmail($fpr->getEmail());     
        if ($user) {
            $user->generateResetPasswordCode()
                    ->setResetPasswordCodeExpirationDate(new \DateTime());
            
            $this->entityManager->flush();
            
            if ($user->getIsEmailConfirmed()) {
                $this->mailer->sendForgotPasswordRequestEmail($user);
            } else {
                //if the user's email is unconfirm, send them a confirm email again
                $this->mailer->sendRegisterationConfirmationEmail($user);
            }
        }
        // Do not do anything special if the user does not exist. 
        // As we don't want people to know *if* an email exists in the system
    }

    public function handleForgotPasswordConfirm(ViewEvent $event)
    {
        /* @var ForgotPasswordConfirm $fpc */
        $fpc = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$fpc instanceof ForgotPasswordConfirm || Request::METHOD_POST !== $method) {
            return;
        }

        /** @var UserRepository $userRepo */
        $userRepo = $this->entityManager->getRepository(User::class);
        /** @var User $user */
        $user = $userRepo->findOne($fpc->getId());     

        if ($user->isResetPasswordCodeValid() && $user->getResetPasswordCode() === $fpc->getCode()) {
            $user->setResetPasswordCode(null)
                    ->setResetPasswordCodeExpirationDate(null)
                    ->setPassword(
                        $this->passwordEncoder->encodePassword($user, $fpc->getPassword())
                    );
        
            $this->entityManager->flush();
        } else {
            throw new NotFoundHttpException('Email or code is invalid or has expired');
        }

    }
}