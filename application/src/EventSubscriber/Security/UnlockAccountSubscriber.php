<?php

namespace App\EventSubscriber\Security;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\EventListener\EventPriorities;
use App\DTO\Security\CodeConfirm;
use App\Repository\UserRepository;
use App\Entity\User;


final class UnlockAccountSubscriber implements EventSubscriberInterface
{
    /* @var EntityManagerInterface $entityManager */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['handleUnlockAccount', EventPriorities::PRE_WRITE],
        ];
    }

    public function handleUnlockAccount(ViewEvent $event) {
        /* @var CodeConfirm $codeConfirm */
        $codeConfirm = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$codeConfirm instanceof CodeConfirm || Request::METHOD_POST !== $method
            || $codeConfirm->getType() !== 'unlock_account_confirm') {
            return;
        }

        /** @var UserRepository $userRepo */
        $userRepo = $this->entityManager->getRepository(User::class);
        /** @var User $user */
        $user = $userRepo->findOne($codeConfirm->getId());     
        
        if ($user && $user->getUnlockCode() === $codeConfirm->getCode()) {
            $user->setUnlockCode(null)
                ->setLoginAttempts(0)
                ->setIsLocked(false);
            
            $this->entityManager->flush();
        }
        
        throw new NotFoundHttpException('This user does not exist or unlock code is incorrect');
    }

}