<?php
namespace Core\UserBundle\Request;


class Client 
{
	private $agent;
	
	private $type;

	public function __construct($agent){
		
		$tablet_values = Array(
			'iPad'
		);
		
		$phone_values = Array(
			'iPhone',
			'Android',
			'android',
			'blackberry',
			'opera mini',
			'motorola',
			'mobilephone',
			'nokia',
			'iPod'
		);

		$this->type="computer";

		foreach($phone_values as $alias){
			if (preg_match("/" . $alias . "/", $agent)) {
				$this->type="mobile";
			}
		}
		
		return $this->type;
	
	}
	
	public function __toString(){
		return $this->type;
	}
}
