<?php

namespace Core\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/route",name="user_route")
     */
    public function routeAction()
    {
    	if(true === $this->get('security.context')->isGranted('ROLE_USER')){
    		return $this->redirect($this->generateUrl('role_user'));
    	}else if(true === $this->get('security.context')->isGranted('ROLE_ADMIN')){
    		return $this->redirect($this->generateUrl('role_admin'));
    	}else{
			die("Access not granted");
    	}
    }
}
