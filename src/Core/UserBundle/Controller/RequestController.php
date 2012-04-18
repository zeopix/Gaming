<?php

namespace Core\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

use Core\UserBundle\Entity\User;
use Core\UserBundle\Entity\Request;
/**
* @Route("/request")
*/
class RequestController extends Controller
{
    /**
     * @Route("/create",name="user_request_create")
     */
    public function createAction()
    {
    	$em = $this->getDoctrine()->getEntityManager();
    	$request = $this->getRequest();
    	
    	$email = $request->query->get('email');
    	$security = $this->get('security.context');

    	$user = $security->getToken()->getUser();
    	$target = $em->getRepository('CoreUserBundle:User')->findOneByEmail($email);
    	
    	
    	$checkQuery = $em->createQuery('SELECT u FROM Core\UserBundle\Entity\User u LEFT JOIN u.myFriends f LEFT JOIN u.friendsWithMe w WHERE f.id = :target OR w.id = :target')->setParameter('target',$target->getId())->setMaxResults(1)->getResult();
    	
    	if($checkQuery){
    		$status = 300;
    	}else{
    	
    		$status = 404;
    		
    	if($user && $target){
    		$solicitud = new \Core\UserBundle\Entity\Request();
    		$solicitud->setSender($user);
    		$solicitud->setReciver($target);
    		$solicitud->setSentAt(new \DateTime());
    		
    		$em->persist($solicitud);
    		$em->flush();
    		
    		$status = 200;
    		return $this->redirect($this->generateUrl('game_default_friends'));
    		
    	}
    	}
    	
    	$response = Array(
    		'status' => $status
    	);
    	
    	return new Response(json_encode($response));
    	
    
    }

    /**
     * @Route("/accept/{id}",name="user_request_accept")
     */
    public function acceptAction($id)
    {
    	$em = $this->getDoctrine()->getEntityManager();
    	$request = $this->getRequest();
    	$security = $this->get('security.context');
    	$userManager = $this->get('fos_user.user_manager');


    	$user = $security->getToken()->getUser();
    	$target = $em->getRepository('CoreUserBundle:Request')->find($id);
    	
    	
    		$status = 404;
    	if($user && $target){
    	
    		if($target->getReciver()->getUsername() == $user->getUsername()){
    		$sender = $target->getSender();
    		$user->addFriend($sender);
    		$target->setPromptedAt(new \DateTime());
    		$target->setAccepted(true);
    		
    		//$userManager->updateUser($user);
    		$em->persist($target);
    		$em->persist($user);
			
			$em->flush();
    		
    		$status = 200;
    		}
    		
    	}
    	
    	$response = Array(
    		'status' => $status
    	);
    	
    	return new Response(json_encode($response));
    	
    
    }

    /**
     * @Route("/decline/{id}",name="user_request_decline")
     */
    public function declineAction($id)
    {
    	$em = $this->getDoctrine()->getEntityManager();
    	$request = $this->getRequest();
    	$security = $this->get('security.context');

    	$user = $security->getToken()->getUser();
    	$target = $em->getRepository('CoreUserBundle:Request')->find($id);
    	
    	
    		$status = 404;
    	if($user && $target){
    	
    		if($target->getReciver()->getUsername() == $user->getUsername()){
    		
			
    		$target->setPromptedAt(new \DateTime());
    		$target->setAccepted(false);
    		
    		$em->persist($target);

    		$em->flush();
    		
    		$status = 200;
    		}
    		
    	}
    	
    	$response = Array(
    		'status' => $status
    	);
    	
    	return new Response(json_encode($response));
    	
    
    }
}
