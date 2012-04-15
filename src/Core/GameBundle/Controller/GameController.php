<?php

namespace Core\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\SecurityContext;

/**
* @Route("/game")
*/    
class GameController extends Controller
{
    /**
     * @Route("/", name="game")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
    /**
     * @Route("/games", name="game_games")
     * @Template()
     */
    public function gamesAction()
    {
        return array();
    }
    /**
     * @Route("/play", name="game_play")
     * @Template()
     */
    public function playAction()
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
    
}
