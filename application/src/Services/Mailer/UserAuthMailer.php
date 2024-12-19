<?php
namespace App\Services\Mailer;

use App\Services\Mailer\Mailer;
use App\Entity\User;

class UserAuthMailer extends Mailer {

    
    public function sendRegisterationConfirmationEmail(User $user) {
        
        $template = 'email/security/registration_confirmation.html.twig';
        
        $message = new \Swift_Message('Welcome to Eduity!');
        
        $message->setFrom($this->getDefaultSender())
                ->setTo($user->getEmail())
                ->setBody($this->getTwig()->render($template, [
                    'user' => $user
                ]), 'text/html')
        ;
        
        $this->getMailer()->send($message);
        
    }
    
    public function sendForgotPasswordRequestEmail(User $user) {
        $template = 'email/security/reset_password.html.twig';
        
        $message = new \Swift_Message('Reset password to your Eduity account.');
        
        $message->setFrom($this->getDefaultSender())
                ->setTo($user->getEmail())
                ->setBody($this->getTwig()->render($template, [
                    'user' => $user
                ]), 'text/html')
        ;
        
        $this->getMailer()->send($message);
    }
    
    public function sendLockoutEmail(User $user) {
        $template = 'email/security/account_locked.html.twig';
        
        $message = new \Swift_Message('Account has been locked out from Eduity!');
        
        $message->setFrom($this->getDefaultSender())
                ->setTo($user->getEmail())
                ->setBody($this->getTwig()->render($template, [
                    'user' => $user
                ]), 'text/html')
        ;
        
        $this->getMailer()->send($message);
    }
}
