<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use App\Services\Mailer\UserAuthMailer;
use App\Repository\UserRepository;
use App\Entity\User;

class LoginGuardAuthenticator extends AbstractGuardAuthenticator
{
    private $entityManager;
    private $passwordEncoder;
    private $params;
    private $mailer;
    private $jwtManager;
    
    public function __construct(Security $security,
            EntityManagerInterface $entityManager,
            UserPasswordEncoderInterface $passwordEncoder,
            ParameterBagInterface $params, 
            UserAuthMailer $mailer,
            JWTTokenManagerInterface $jwtManager)
    {
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
        $this->params = $params;
        $this->mailer = $mailer;
        $this->jwtManager = $jwtManager;
    }

    public function supports(Request $request)
    {
        return 'security_user_login' === $request->attributes->get('_route')
            && $request->isMethod('POST');
    }

    public function getCredentials(Request $request)
    {
        return ['email' => $request->get('email'),
                'password' => $request->get('password'),
        ];;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $credentials['email']]);

        if (!$user) {
            // fail authentication with a custom error
            throw new CustomUserMessageAuthenticationException('Email could not be found.');
        } else if ($user->getIsLocked()) {
            throw new CustomUserMessageAuthenticationException('This account has exceeded the allowed login attempts and has been locked for 24 hours.');
        }

        return $user;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {        
        return $this->passwordEncoder->isPasswordValid($user, $credentials['password']);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return new JsonResponse([
            'token' => $this->jwtManager->create($token->getUser()),
            'success' => true
        ]);
    }
    
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception) 
    {
        $credentials = $exception->getToken()->getCredentials();

        /** @var UserRepository $userRepo */
        $userRepo = $this->entityManager->getRepository(User::class);
        /** @var User $user */
        $user = $userRepo->findOneByEmail($credentials['email']);
        if ($user) {         
            $user->incrementLockoutAttempts($this->params->get('account_lockout_interval'));
            if ($user->getLoginAttempts() >= $this->params->get('max_account_login_attempts')) {
                if (!$user->getIsLocked()) {
                    $user->generateUnlockCode();
                    $this->mailer->sendLockoutEmail($user);
                }
                $user->setIsLocked(true);
                
            }
            $user->setLastLoginAttempt(new \DateTime());
            
            $this->entityManager->flush();
        }
        
        $data = [
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())
        ];
        
        return new JsonResponse($data, Response::HTTP_FORBIDDEN);
    }

    public function start(Request $request, AuthenticationException $authException = null) 
    {
        return new JsonResponse(['message' => 'Authentication Required'], Response::HTTP_UNAUTHORIZED);
    }

    public function supportsRememberMe()
    {
        return false;
    }
}
