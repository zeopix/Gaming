<?php

namespace Core\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{

	protected $facebook;
	protected $params;
	
    /**
     * @Route("/", name="game_default_index")
	 * @Template()
     */
    public function indexAction()
    {
        return Array();
    }
    /**
     * @Route("/redirect",name="game_default_redirect")
     */
    public function redirectAction()
    {
        return $this->redirect($this->generateUrl('game'));
    }
    
     public function loginAction()
    {
                $request = $this->container->get('request');
                /* @var $request \Symfony\Component\HttpFoundation\Request */
                $session = $request->getSession();
                /* @var $session \Symfony\Component\HttpFoundation\Session */

                // get the error if any (works with forward and redirect -- see below)
                if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
                    $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
                } elseif (null !== $session && $session->has(SecurityContext::AUTHENTICATION_ERROR)) {
                    $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
                    $session->remove(SecurityContext::AUTHENTICATION_ERROR);
                } else {
                    $error = '';
                }

                if ($error) {
                    // TODO: this is a potential security risk (see http://trac.symfony-project.org/ticket/9523)
                    $error = $error->getMessage();
                }
                // last username entered by the user
                $lastUsername = (null === $session) ? '' : $session->get(SecurityContext::LAST_USERNAME);

                $csrfToken = $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate');





                return $this->render('CoreGameBundle:Layout:login.html.twig', array(
                            'last_username' => $lastUsername,
                            'error'         => $error,
                            'csrf_token' => $csrfToken,

                        ));
    }

    public function registerAction(){
        $em = $this->getDoctrine()->getEntityManager();
        $user = new \Core\UserBundle\Entity\User();
        $form = $this->createForm(new \Core\UserBundle\Form\RegisterType(), $user);

        $pass = null;
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            if($form->isValid())
            {
				$user->setEnabled(true);
               $em->persist($user);

               $em->flush();

                return $this->redirect($this->generateUrl('game_login'));
            }
        }
        return $this->render('CoreGameBundle:Layout:register.html.twig', array(
                'form' => $form->createView(),

                'pass' => $pass,
            ));
    }
    
    public function logoutAction(){
    	return null;
    }
 
    
    /**
     * @Route("/check", name="game_check")
     */
    public function checkAction(){
    	return null;
    }
 
    
    /**
     * @Route("/facebook_login", name="game_facebook_login")
     */
    public function facebookLoginAction(){
		
        $this->params = Array(
        	'app_url' => "http://appbattleship.com/game/",
			'server_url' => "http://appbattleship.com/game/"
		);
		
		
		
		$redirect_uri = $this->getRequest()->getUriForPath("/facebook_check");
        
        if ($this->params['server_url'] && $this->params['app_url']) {
            $redirect_uri = str_replace($this->params['server_url'], $this->params['app_url'], $redirect_uri);
        }
        
        $loginUrl = $this->get('fos_facebook.api')->getLoginUrl(
           array(
                'display' => 'page',
                'scope' => 'email',
                'redirect_uri' => $redirect_uri,
        ));
        
        if ($this->params['server_url'] && $this->params['app_url']) {
            return new Response('<html><head></head><body><script>top.location.href="'.$loginUrl.'";</script></body></html>');
        }
        
        return new RedirectResponse($loginUrl);
        
		

    }
}
