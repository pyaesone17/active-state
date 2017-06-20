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

    function __construct($request)
    {
        $this->request = $request;
    }

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

    /*
    * It is the main entry point to check using route name
    */ 
    public function checkRoute($route,$active=null,$inactive=null)
    {
        $this->setReturnValue($active,$inactive);
        return $this->request->routeIs($route) ? $this->activeValue : $this->inActiveValue;
    }

    /*
    * It is the main entry point to check using route name and return boolean
    */ 
    public function checkRouteBoolean($route)
    {
        return $this->request->routeIs($route);
    }

    /*
    * It is the main entry point to check using fullurl including query
    */ 
    public function checkQuery($fullUrlWithQuery,$active=null,$inactive=null)
    {
        // Here we have to transform to domain base full query
        // Since fullUrlIs also check domain name, if we dont transform here
        // User have to type those lenghty domain name
        $fullUrlWithQuery = url($fullUrlWithQuery);

        $this->setReturnValue($active,$inactive);
        return $this->request->fullUrlIs($fullUrlWithQuery) ? $this->activeValue : $this->inActiveValue;
    }

    /*
    * It is the main entry point to check using route name and return boolean
    */ 
    public function checkQueryBoolean($fullUrlWithQuery)
    {
        $fullUrlWithQuery = url($fullUrlWithQuery);
        return $this->request->fullUrlIs($fullUrlWithQuery);
    }

    /**
    *   It checks the active state of given url deeply 
    *   @param  string $url < url point to check >
    *   @return string it returns wherether the state is active or no 
    */
    protected function checkActiveDeeply($url)
    {
        return $this->request->is($url) || $this->request->is($url.'/*') ? $this->activeValue : $this->inActiveValue; 
    }

    /**
    *   It checks the active state of given url specificly  
    *   @param  string $url < url point to check >
    *   @return string it returns wherether the state is active or no 
    */
    protected function checkActive($url)
    {
        return $this->request->is($url) ? $this->activeValue : $this->inActiveValue; 
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