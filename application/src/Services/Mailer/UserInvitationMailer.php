<?php
namespace App\Services\Mailer;

use App\Services\Mailer\Mailer;
use App\Entity\UserInvitation;

class UserInvitationMailer extends Mailer {

    
    public function sendUserInvitation(UserInvitation $userInvitation) {
        
        $template = 'email/security/user_invitation.html.twig';
        
        $message = new \Swift_Message('An Invitation to Eduity!');
        
        $email = $userInvitation->getEmail();
        if ($email === null) {
            $email = $userInvitation->getUser()->getEmail();
        }
        $message->setFrom($this->getDefaultSender())
                ->setTo($email)
                ->setBody($this->getTwig()->render($template, [
                    'userInvitation' => $userInvitation,
                ]), 'text/html')
        ;
        
        $this->getMailer()->send($message);
    }

}