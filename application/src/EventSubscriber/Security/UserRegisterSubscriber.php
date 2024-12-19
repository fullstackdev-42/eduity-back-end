<?php

namespace App\EventSubscriber\Security;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\EventListener\EventPriorities;
use App\Services\Mailer\UserAuthMailer;
use App\DTO\Security\CodeConfirm;
use App\Repository\UserRepository;
use App\Entity\User;


final class UserRegisterSubscriber implements EventSubscriberInterface
{
    /* @var EntityManagerInterface $entityManager */
    private $entityManager;
    /* @var UserAuthMailer $mailer */
    private $mailer;

    public function __construct(EntityManagerInterface $entityManager, UserAuthMailer $mailer)
    {
        $this->entityManager = $entityManager;
        $this->mailer = $mailer;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['confirmUserRegisteration', EventPriorities::PRE_WRITE],
            KernelEvents::VIEW => ['sendRegisterationConfirmationEmail', EventPriorities::POST_WRITE],
        ];
    }

    public function confirmUserRegisteration(ViewEvent $event) {
        /* @var CodeConfirm $codeConfirm */
        $codeConfirm = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$codeConfirm instanceof CodeConfirm || Request::METHOD_POST !== $method
            || $codeConfirm->getType() !== 'register_confirm') {
            return;
        }

        /** @var UserRepository $userRepo */
        $userRepo = $this->entityManager->getRepository(User::class);
        /** @var User $user */
        $user = $userRepo->findOne($codeConfirm->getId());     
        
        if ($user && $user->getEmailConfirmationCode() === $codeConfirm->getCode()) {
            $user->setIsEmailConfirmed(true);
            
            $this->entityManager->flush();
        }
        
        throw new NotFoundHttpException('This user does not exist or confirmation code is incorrect');
    }

    public function sendRegisterationConfirmationEmail(ViewEvent $event)
    {
        $user = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$user instanceof User || Request::METHOD_POST !== $method) {
            return;
        }

        if (!$user->getIsEmailConfirmed()) {
            $this->mailer->sendRegisterationConfirmationEmail($user);
        }
    }
}