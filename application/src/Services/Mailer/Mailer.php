<?php

namespace App\Services\Mailer;

use Twig\Environment;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

abstract class Mailer {
    private $mailer;
    private $twig;
    private $params;
    private $defaultSender;
     
    public function __construct(\Swift_Mailer $mailer, Environment $twig,
        ParameterBagInterface $params) {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->params = $params;
        
        $this->defaultSender = $params->get('default_sender_email');
    }
    
    public function getMailer(): \Swift_Mailer {
        return $this->mailer;
    }
    
    public function getTwig(): Environment {
        return $this->twig;
    }
    
    public function getParameters(): ParameterBagInterface {
        return $this->params;
    }
    
    public function getDefaultSender(): string {
        return $this->defaultSender;
    }
}
