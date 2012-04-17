<?php

namespace Core\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;
use Core\GameBundle\Entity\Game;
/**
* @Route("/game")
*/    
class GameController extends Controller
{
	private $flag = false;
    /**
     * @Route("/", name="game")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
    
    /**
     * @Route("/fast", name="game_fast")
     * @Template()
     */
    public function fastAction()
    {
        return array();
    }
    
    /**
     * @Route("/join", name="game_join")
     */
    public function joinAction()
    {
    	$em = $this->getDoctrine()->getEntityManager();
    	$request = $this->getRequest();
    	$security = $this->get('security.context');

    	$user = $security->getToken()->getUser();    	
    	$blocks = json_decode($request->request->get('blocks'));
    	
    	$games = $em->createQuery('SELECT g FROM CoreGameBundle:Game g WHERE g.player is null AND g.owner != :user')->setParameter('user',$user)->setMaxResults(1)->getResult();
			$array_blocks = Array();
			foreach($blocks as $block){
				$key = $block[0].$block[1];
				$array_blocks[$key] = Array(
					'c' => $block[0],
					'f' => $block[1]
				);
			}

    	if(count($games) > 0){
    		
    		$game = $games[0];
    		$game->setPlayer($user);
    		$game->setPlayerBlocks($array_blocks);
    		$game->setPlayerAt(new \DateTime());
    		
    	}else{
			
			$game = new Game('8');
			$game->setOwner($user);
			$game->setOwnerBlocks($array_blocks);
			$game->setCreatedAt(new \DateTime());

    	}
    	
    	$em->persist($game);
    	$em->flush();
    	
        return new Response(json_encode(Array('game'=>$game->getId())));
    }
    /**
     * @Route("/games", name="game_games")
     * @Template()
     */
    public function gamesAction()
    {
    	$em = $this->getDoctrine()->getEntityManager();
    	$request = $this->getRequest();
    	$security = $this->get('security.context');

    	$user = $security->getToken()->getUser();    	
    	$games = $em->createQuery("SELECT g FROM CoreGameBundle:Game g WHERE (g.owner = :user OR g.player = :user) AND g.finished_at is null AND g.player_at is not null")
    	->setParameter('user',$user)
    	->getResult();
    	
        return array('games' => $games);
    }
    
    /**
     * @Route("/play/{game}", name="game_play")
     * @Template()
     */
    public function playAction($game)
    {

    	$em = $this->getDoctrine()->getEntityManager();
    	$request = $this->getRequest();
    	$security = $this->get('security.context');

    	$user = $security->getToken()->getUser();    	
		$game = $em->getRepository('CoreGameBundle:Game')->find($game);

		if($game->getOwner()->getId() == $user->getId()){
			$tu = $game->getPlayer();
		}else if($game->getPlayer()->getId() == $user->getId()){
			$tu = $game->getOwner();
		}else{
			die("Not your game!");
		}
		
        return array('yo'=>$user, 'tu' =>$tu, 'game'=>$game);
    }
    
    /**
     * @Route("/shot", name="game_shot")
     * @Template()
     */
    public function shotAction(){
	
		$em = $this->getDoctrine()->getEntityManager();
    	$request = $this->getRequest();
		$security = $this->get('security.context');
		    	
    	$gameid = $request->request->get('game');
    	$shot_c = $request->request->get('c');
    	$shot_f = $request->request->get('f');
    	$imOwner = false;
    	$imPlayer = false;
    	
    	$user = $security->getToken()->getUser();    	
		$game = $em->getRepository('CoreGameBundle:Game')->find($gameid);
		
		if($game){
		
		if($game->getFinishedAt() == null){
		if($game->getOwner()->getId() == $user->getId()){
			$tu = $game->getPlayer();
			$imOwner = true;
		}else if($game->getPlayer()->getId() == $user->getId()){
			$tu = $game->getOwner();
			$imPlayer = true;
		}else{
			$response = Array('status'=>300,'message'=>'forbidden');
		}
		if(($game->getOwnerTurn() && $imOwner) || (!$game->getOwnerTurn() && $imPlayer)){
			if($imOwner){ $moves = $game->getOwnerMoves(); }else{ $moves = $game->getPlayerMoves(); }
			$key = $shot_c . $shot_f;
			if(!isset($moves[$key])){
				$move = Array('c'=>$shot_c,'f'=>$shot_f,'date' => time());
				$moves[$key] = $move;
			}
			
			//check if game is ended
			//check if count(moves) == count(blocks);
			
			if($imOwner){ 
				$game->setOwnerMoves($moves); 
				$game->setOwnerTurn(false);
			}else{ 
				$game->setPlayerMoves($moves); 
				$game->setOwnerTurn(true);	
			}
			
			$em->persist($game);
			$em->flush();
			$this->flag = true;
			return $this->statusAction($gameid);
			
		}else{
			$response = Array('status'=>310,'message'=>'forbidden');
		}
		
		}else{
			$response = Array('status'=>320,'message'=>'ended');
	
		}
		
		}else{
			$response = Array('status'=>404,'message'=>'forbidden');
		}
    	return new Response(json_encode($response));
    }
    
    
    
    /**
     * @Route("/status/{gameid}", name="game_status")
     */
    public function statusAction($gameid){
    	
    	$em = $this->getDoctrine()->getEntityManager();
    	$request = $this->getRequest();
		$security = $this->get('security.context');
		    	
    	$imOwner = false;
    	$imPlayer = false;
    	$change = false;
    	$oponent = false;
    	$turn = false;
			
		if($this->flag){
			$change = true;
		}
    	
    	$user = $security->getToken()->getUser();    	
		$game = $em->getRepository('CoreGameBundle:Game')->find($gameid);
		
		if($game){
		if($game->getOwner()->getId() == $user->getId()){
			if($game->getPlayer()){
				$oponent = $game->getPlayer()->getUsername();
			}
			$me = $game->getOwnerMap(true);
			$tu = $game->getPlayerMap(false);
			if($game->getOwnerTurn()){
				$turn = true;
			}
		}else if($game->getPlayer()->getId() == $user->getId()){

			$tu = $game->getOwnerMap(false);
			$me = $game->getPlayerMap(true);
			$oponent = $game->getOwner()->getUsername();
			if(!$game->getOwnerTurn()){
				$turn = true;
			}
			
		}else{
			$response = Array('status'=>300,'message'=>'forbidden');
		}
		
			$response = Array('status'=>200,'tu'=>$tu,'me'=>$me,'game'=>$game,'turn'=>$turn, 'change' => $change, 'oponent' => $oponent);
		
		}else{
			$response = Array('status'=>404,'message'=>'notfound');
		}
		
		
		return new Response(json_encode($response));
		
		
    }

}
