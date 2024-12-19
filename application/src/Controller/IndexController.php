<?php

namespace App\Controller;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

final class IndexController extends AbstractController
{
    /**
    * @Route("/{vueRouting}", requirements={"vueRouting"="^(?!v1|_(profiler|wdt)).*"}, 
    *   name="index", methods={"GET"})
    */
    public function index($vueRouting = null) {  
        throw $this->createNotFoundException();              
    }
   
}

