<?php

namespace App\EventSubscriber\Security;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\EventListener\EventPriorities;
use App\Services\Mailer\UserInvitationMailer;
use App\DTO\Security\CodeConfirm;
use App\Repository\UserInvitationRepository;
use App\Entity\UserInvitation;


final class UserInvitationSubscriber implements EventSubscriberInterface
{
    /* @var EntityManagerInterface $entityManager */
    private $entityManager;
    /* @var UserInvitationMailer $mailer */
    private $mailer;

    public function __construct(EntityManagerInterface $entityManager, UserInvitationMailer $mailer)
    {
        $this->entityManager = $entityManager;
        $this->mailer = $mailer;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['acceptUserInvitation', EventPriorities::PRE_WRITE],
            KernelEvents::VIEW => ['sendUserInvitation', EventPriorities::POST_WRITE],
        ];
    }

    public function acceptUserInvitation(ViewEvent $event) {
        /* @var CodeConfirm $codeConfirm */
        $codeConfirm = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$codeConfirm instanceof CodeConfirm || Request::METHOD_POST !== $method
            || $codeConfirm->getType() !== 'accept_user_invitation') {
            return;
        }

        /** @var UserInvitationRepository $userInvitationRepo */
        $userInvitationRepo = $this->entityManager->getRepository(UserInvitation::class);
        /** @var UserInvitation $userInvitation */
        $userInvitation = $userInvitationRepo->findOne($codeConfirm->getId());     
        
        if ($userInvitation && $userInvitation->getAcceptCode() === $codeConfirm->getCode()) {
            $userInvitation->setAccepted(true);
            
            $this->entityManager->flush();
        }
        
        throw new NotFoundHttpException('This user does not exist or confirmation code is incorrect');
    }

    public function sendUserInvitation(ViewEvent $event)
    {
        $userInvitation = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$userInvitation instanceof UserInvitation || Request::METHOD_POST !== $method) {
            return;
        }

        if (!$userInvitation->getAccepted()) {
            $this->mailer->sendUserInvitation($userInvitation);
        }
    }
}