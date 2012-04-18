<?php

namespace Core\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;

/**
* @Route("/mobile")
*/
class MobileController extends Controller
{

    /**
     * @Route("/", name="game_mobile_index")
	 * @Template()
     */
    public function indexAction()
    {
        return Array();
    }

    /**
     * @Route("/menu", name="game_mobile_menu")
	 * @Template()
     */
    public function menuAction()
    {
        return Array();
    }
  

    /**
     * @Route("/login", name="mobile_login")
     */     
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

				$response = Array(
					'status' => 200,
					'csrf' => $csrfToken
				);




                return new Response(json_encode($response));
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
 
   }
