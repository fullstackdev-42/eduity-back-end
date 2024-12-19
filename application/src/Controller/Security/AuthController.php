<?php

namespace App\Controller\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class AuthController extends AbstractController
{

    /**
     * @Route("/v1/login", name="security_user_login", methods={"POST"})
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        throw $this->createAccessDeniedException();
    }
    
    /** @Route("/v1/logout", name="security_user_logout") **/
    public function logout() 
    {
        //Symfony automatically handles this action, but we still need the route defined.
        throw $this->createAccessDeniedException();
    }
    
    /** 
     * This allows for a non api way to grab a JWT token
     * @Route("/v1/admin/getJWT", name="security_user_get_jwt") 
     **/
    public function getJWT(Request $request, HttpClientInterface $client) {
        $responseData = null;

        $form = $this->createFormBuilder()
            ->add('email', Type\EmailType::class)
            ->add('password', Type\PasswordType::class)
            ->add('send', Type\SubmitType::class)
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $response = $client->request(
                'POST',
                $this->generateUrl('security_user_login', [], UrlGeneratorInterface::ABSOLUTE_URL),
                ['json' => ['email' => $data['email'], 'password' => $data['password']]]
            );
	    
	   $responseData = $response->toArray(false);
        }
            
        return $this->render('admin/get_jwt.html.twig', ['form' => $form->createView(), 'data' => $responseData]);
    }
}
