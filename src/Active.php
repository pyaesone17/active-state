<?php
namespace Pyaesone17\ActiveState;

use Request;
/**
* Active state check for laravel
*/
class Active
{
	protected $activeValue;
	protected $inActiveValue;

	/*
	* It is the main entry point to check Url
	*/ 
	public function check($url,$deep=false,$active=null,$inactive=null)
	{
		$this->setReturnValue($active,$inactive);
		return $deep == true ? $this->checkActiveDeeply($url) : $this->checkActive($url);
	}

	/*
	* It is the main entry point to check Url
	*/ 
	public function checkBoolean($url,$deep=false,$active=true,$inactive=false)
	{
		$this->setReturnValue($active,$inactive);
		return $deep == true ? $this->checkActiveDeeply($url) : $this->checkActive($url);
	}

	/**
	*	It checks the active state of given url deeply 
	*	@param  string $url < url point to check >
	*	@return string it returns wherether the state is active or no 
	*/
	protected function checkActiveDeeply($url)
	{
		if(is_array($url)) {
            foreach ($url as $value) { $urls[] = $value.'*'; }
            return call_user_func_array('Request::is', $urls) ? $this->activeValue : $this->inActiveValue;
        }else {
            return Request::is($url) || Request::is($url . '/*') ? $this->activeValue : $this->inActiveValue;
        }
	}

	/**
	*	It checks the active state of given url specificly  
	*	@param  string $url < url point to check >
	*	@return string it returns wherether the state is active or no 
	*/
	protected function checkActive($url)
	{
		if(is_array($url))
            return call_user_func_array('Request::is', $url) ? $this->activeValue : $this->inActiveValue;
        else
		    return Request::is($url) ? $this->activeValue : $this->inActiveValue;
	}

	protected function getActiveValue()
	{
		$trueValue=config('active.active_state');
		return $trueValue;
	}	
	protected function getInActiveValue()
	{
		$falseValue=config('active.inactive_state');
		return $falseValue;
	}

	protected function setReturnValue($active,$inactive)
	{
		$this->activeValue   = ( $active === null ) ? $this->getActiveValue() : $active;
		$this->inActiveValue = ( $inactive === null ) ? $this->getInActiveValue() : $inactive;
	}
}