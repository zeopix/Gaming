<?php

namespace Core\GameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Core\GameBundle\Entity\Game
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Game
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Core\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="player_id", referencedColumnName="id")
     **/
	private $player;

    /**
     * @ORM\ManyToOne(targetEntity="Core\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     **/
	private $owner;
    
    /**
     * @var integer $size
     *
     * @ORM\Column(name="size", type="integer")
     */
    private $size;

    /**
     * @var array $owner_blocks
     *
     * @ORM\Column(name="owner_blocks", type="array")
     */
    private $owner_blocks;

    /**
     * @var array $player_blocks
     *
     * @ORM\Column(name="player_blocks", type="array", nullable="true")
     */
    private $player_blocks;

    /**
     * @var array $owner_blocks
     *
     * @ORM\Column(name="owner_moves", type="array")
     */
    private $owner_moves;

    /**
     * @var array $player_blocks
     *
     * @ORM\Column(name="player_moves", type="array", nullable="true")
     */
    private $player_moves;

    /**
     * @var datetime $created_at
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $created_at;

    /**
     * @var datetime $player_at
     *
     * @ORM\Column(name="player_at", type="datetime", nullable="true")
     */
    private $player_at;

    /**
     * @var datetime $moved_at
     *
     * @ORM\Column(name="moved_at", type="datetime", nullable="true")
     */
    private $moved_at;

    /**
     * @var datetime $finished_at
     *
     * @ORM\Column(name="finished_at", type="datetime", nullable="true")
     */
    private $finished_at;

    /**
     * @var boolean $owner_wins
     *
     * @ORM\Column(name="owner_wins", type="boolean")
     */
    private $owner_wins;

    /**
     * @var boolean $looser_quit
     *
     * @ORM\Column(name="looser_quit", type="boolean")
     */
    private $looser_quit;

    /**
     * @var boolean $owner_turn
     *
     * @ORM\Column(name="owner_turn", type="boolean")
     */
    private $owner_turn;

	public function __construct($size=8){
		$this->size = $size;
		$this->owner_wins = false;
		$this->looser_quit = false;
		$this->owner_turn = true;
	}

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set size
     *
     * @param integer $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * Get size
     *
     * @return integer 
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set owner_blocks
     *
     * @param array $ownerBlocks
     */
    public function setOwnerBlocks($ownerBlocks)
    {
        $this->owner_blocks = $ownerBlocks;
    }

    /**
     * Get owner_blocks
     *
     * @return array 
     */
    public function getOwnerBlocks()
    {
        return $this->owner_blocks;
    }

    /**
     * Set player_blocks
     *
     * @param array $playerBlocks
     */
    public function setPlayerBlocks($playerBlocks)
    {
        $this->player_blocks = $playerBlocks;
    }

    /**
     * Get player_blocks
     *
     * @return array 
     */
    public function getPlayerBlocks()
    {
        return $this->player_blocks;
    }

    /**
     * Set created_at
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
    }

    /**
     * Get created_at
     *
     * @return datetime 
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set player_at
     *
     * @param datetime $playerAt
     */
    public function setPlayerAt($playerAt)
    {
        $this->player_at = $playerAt;
    }

    /**
     * Get player_at
     *
     * @return datetime 
     */
    public function getPlayerAt()
    {
        return $this->player_at;
    }

    /**
     * Set moved_at
     *
     * @param datetime $movedAt
     */
    public function setMovedAt($movedAt)
    {
        $this->moved_at = $movedAt;
    }

    /**
     * Get moved_at
     *
     * @return datetime 
     */
    public function getMovedAt()
    {
        return $this->moved_at;
    }

    /**
     * Set finished_at
     *
     * @param datetime $finishedAt
     */
    public function setFinishedAt($finishedAt)
    {
        $this->finished_at = $finishedAt;
    }

    /**
     * Get finished_at
     *
     * @return datetime 
     */
    public function getFinishedAt()
    {
        return $this->finished_at;
    }

    /**
     * Set owner_wins
     *
     * @param boolean $ownerWins
     */
    public function setOwnerWins($ownerWins)
    {
        $this->owner_wins = $ownerWins;
    }

    /**
     * Get owner_wins
     *
     * @return boolean 
     */
    public function getOwnerWins()
    {
        return $this->owner_wins;
    }

    /**
     * Set looser_quit
     *
     * @param boolean $looserQuit
     */
    public function setLooserQuit($looserQuit)
    {
        $this->looser_quit = $looserQuit;
    }

    /**
     * Get looser_quit
     *
     * @return boolean 
     */
    public function getLooserQuit()
    {
        return $this->looser_quit;
    }

    /**
     * Set owner_turn
     *
     * @param boolean $ownerTurn
     */
    public function setOwnerTurn($ownerTurn)
    {
        $this->owner_turn = $ownerTurn;
    }

    /**
     * Get owner_turn
     *
     * @return boolean 
     */
    public function getOwnerTurn()
    {
        return $this->owner_turn;
    }

    /**
     * Set player
     *
     * @param Core\UserBundle\Entity\User $player
     */
    public function setPlayer(\Core\UserBundle\Entity\User $player)
    {
        $this->player = $player;
    }

    /**
     * Get player
     *
     * @return Core\UserBundle\Entity\User 
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * Set owner
     *
     * @param Core\UserBundle\Entity\Owner $owner
     */
    public function setOwner(\Core\UserBundle\Entity\User $owner)
    {
        $this->owner = $owner;
    }

    /**
     * Get owner
     *
     * @return Core\UserBundle\Entity\Owner 
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set owner_moves
     *
     * @param array $ownerMoves
     */
    public function setOwnerMoves($ownerMoves)
    {
        $this->owner_moves = $ownerMoves;
    }

    /**
     * Get owner_moves
     *
     * @return array 
     */
    public function getOwnerMoves()
    {
        return $this->owner_moves;
    }

    /**
     * Set player_moves
     *
     * @param array $playerMoves
     */
    public function setPlayerMoves($playerMoves)
    {
        $this->player_moves = $playerMoves;
    }

    /**
     * Get player_moves
     *
     * @return array 
     */
    public function getPlayerMoves()
    {
        return $this->player_moves;
    }
    
    public function getOwnerMap($ships=false){
    	return $this->getMap($this->owner_blocks,$this->player_moves,$ships);
    }
    
    public function getPlayerMap($ships=false){
    	return $this->getMap($this->player_blocks,$this->owner_moves,$ships);
    }
    
    public function getMap($blocks,$moves,$ships=false){
    	$result = Array();
		if(is_array($moves)){
    	foreach($moves as $key => $move){
	    		
    		if(isset($blocks[$key])){
    			$status = "fire";
    		}else{
    			$status = "water";
    		}
    			$result[$key] = Array(
    				'c' => $moves[$key]['c'],
    				'f' => $moves[$key]['f'],
    				'status' => $status,
    			);
    		
    	}
    	foreach($blocks as $key => $block){
    		if(isset($result[$key])){
    			$status = $result[$key]['status']; //Dead ship //fire
    			$result[$key]['status'] = $status . " ship";
    		}else{
    			if($ships){
    				if(isset($result[$key]['status'])){ $status = $result[$key]['status']; }else{ $status = "grass"; };
	    			 
    				$result[$key]['status'] = $status . " ship";
				}
    		}
    	}
    	}else{ $result = null; }
    	
    	return $result;
    	
    }
    
}