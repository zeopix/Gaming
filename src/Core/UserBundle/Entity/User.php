<?php
namespace Core\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="core_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $surname
     *
     * @ORM\Column(name="last_ip", type="string", length=255, nullable=true)
     */
    private $last_ip;

    /**
     * @var string $surname
     *
     * @ORM\Column(name="ore", type="integer", nullable=true)
     */
    private $ore;

    /**
     * @var string $surname
     *
     * @ORM\Column(name="exp", type="integer", nullable=true)
     */
    private $exp;

    /**
     * @var string $surname
     *
     * @ORM\Column(name="level", type="integer", nullable=true)
     */
    private $level;
    

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
     * Set birthday
     *
     * @param date $birthday
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
    }

    /**
     * Get birthday
     *
     * @return date 
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set isMale
     *
     * @param boolean $isMale
     */
    public function setIsMale($isMale)
    {
        $this->isMale = $isMale;
    }

    /**
     * Get isMale
     *
     * @return boolean 
     */
    public function getIsMale()
    {
        return $this->isMale;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set secondname
     *
     * @param string $secondname
     */
    public function setSecondname($secondname)
    {
        $this->secondname = $secondname;
    }

    /**
     * Get secondname
     *
     * @return string 
     */
    public function getSecondname()
    {
        return $this->secondname;
    }

    /**
     * Set surname
     *
     * @param string $surname
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    /**
     * Get surname
     *
     * @return string 
     */
    public function getSurname()
    {
        return $this->surname;
    }
    
    public function convertBirthday(){
    
    	$date = new \DateTime();
    	
    	$date->setDate($this->birthday_year,$this->birthday_month,$this->birthday_day);
    	$this->setBirthday($date);
    
    }
      public function getLastIp(){ return $this->last_ip; }
    public function setLastIp($elm){ $this->last_ip = $elm; }  
    public function getBirthdayMonth(){ return $this->birthday_month; }
    public function getBirthdayDay(){ return $this->birthday_day; }
    public function getBirthdayYear(){ return $this->birthday_year; }
    public function setBirthdayMonth($elm){ $this->birthday_month = $elm; }
    public function setBirthdayDay($elm){ $this->birthday_day = $elm; }
    public function setBirthdayYear($elm){ $this->birthday_year = $elm; }

    /**
     * Set ore
     *
     * @param integer $ore
     */
    public function setOre($ore)
    {
        $this->ore = $ore;
    }

    /**
     * Get ore
     *
     * @return integer 
     */
    public function getOre()
    {
        return $this->ore;
    }

    /**
     * Set exp
     *
     * @param integer $exp
     */
    public function setExp($exp)
    {
        $this->exp = $exp;
    }

    /**
     * Get exp
     *
     * @return integer 
     */
    public function getExp()
    {
        return $this->exp;
    }

    /**
     * Set level
     *
     * @param integer $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }

    /**
     * Get level
     *
     * @return integer 
     */
    public function getLevel()
    {
        return $this->level;
    }
}