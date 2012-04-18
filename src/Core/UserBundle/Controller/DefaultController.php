<?php

namespace Core\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/",name="user")
     */
    public function indexAction()
    {
    	return new Response("under construction");
    }
    /**
     * @Route("/ajax",name="user_ajax")
     */
    public function ajaxAction()
    {
    
    	$em = $this->getDoctrine()->getEntityManager();
    	$request = $this->getRequest();
    	
    	$email = $request->query->get('email');
    	$security = $this->get('security.context');

    	$user = $security->getToken()->getUser();
    	
    	$requests = $em->getRepository("CoreUserBundle:Request")->findOneBy(Array('reciver'=>$user->getId(),'accepted'=>null));
    	
    	$response = Array(
    		'status' => 200,
    		'content' => null
    	);
    	
    	if($requests){
    		$response['status'] = 210;
    		$response['content'] = Array(
    			'sender' => $requests->getSender()->getUsername(),
    			'sender_id' => $requests->getSender()->getId(),
    			'request_id' => $requests->getId(),
    		);
    		
    	}

    	
    	return new Response(json_encode($response));
    }
    
    
}
