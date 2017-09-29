<?php
namespace Pyaesone17\ActiveState;
use Illuminate\Support\Str;
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
        return $deep == true ? $this->checkActiveDeeply($url,'is') : $this->checkActive($url,'is');
    }

    /*
    * It is the main entry point to check Url
    */ 
    public function checkBoolean($url,$deep=false,$active=true,$inactive=false)
    {
        $this->setReturnValue($active,$inactive);
        return $deep == true ? $this->checkActiveDeeply($url,'is') : $this->checkActive($url,'is');
    }

    /*
    * It is the main entry point to check using route name
    */ 
    public function checkRoute($route,$active=null,$inactive=null)
    {
        $this->setReturnValue($active,$inactive);

        if (is_array($route)) {
            $result = call_user_func_array(array($this,'routeIsDeeply'), $route);
        } else {
            $result = $this->routeIsDeeply($route);   
        }

        return $result ? $this->activeValue : $this->inActiveValue;
    }

    /*
    * It is the main entry point to check using route name and return boolean
    */ 
    public function checkRouteBoolean($route)
    {
        if (is_array($route)) {
            $result = call_user_func_array(array($this,'routeIsDeeply'), $route);
        } else {
            $result = $this->routeIsDeeply($route);   
        }
        return $result;
    }

    /*
    * It is the main entry point to check using fullurl including query
    */ 
    public function checkQuery($fullUrlWithQuery,$active=null,$inactive=null)
    {
        $this->setReturnValue($active,$inactive);

        if (is_array($fullUrlWithQuery)) {
            $result = call_user_func_array(array($this,'queryIsDeeply'), $fullUrlWithQuery);
        } else {
            $result = $this->queryIsDeeply($fullUrlWithQuery);   
        }

        return $result ? $this->activeValue : $this->inActiveValue;
    }

    /*
    * It is the main entry point to check using route name and return boolean
    */ 
    public function checkQueryBoolean($fullUrlWithQuery)
    {
        if (is_array($fullUrlWithQuery)) {
            $result = call_user_func_array(array($this,'queryIsDeeply'), $fullUrlWithQuery);
        } else {
            $result = $this->queryIsDeeply($fullUrlWithQuery);   
        }
        return $result;
    }

    /**
    *   It checks the active state of given url deeply 
    *   @param  string $url < url point to check >
    *   @return string it returns wherether the state is active or no 
    */
    protected function checkActiveDeeply($url,$method)
    {
        if(is_array($url)) {
            foreach ($url as $value) { $urls[] = $value.'*'; }
            return call_user_func_array(array($this->request,$method), $urls) ? $this->activeValue : $this->inActiveValue;
        } else {
            return $this->request->is($url) || $this->request->is($url . '/*') ? $this->activeValue : $this->inActiveValue;
        }
    }
    /**
    *   It checks the active state of given url specificly  
    *   @param  string $url < url point to check >
    *   @return string it returns wherether the state is active or no 
    */
    protected function checkActive($url,$method)
    {
        if(is_array($url)){
            return call_user_func_array(array($this->request,$method), $url) ? $this->activeValue : $this->inActiveValue;
        } else{
            return $this->request->{$method}($url) ? $this->activeValue : $this->inActiveValue;
        }
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

    protected function queryIsDeeply() 
    {
        foreach (func_get_args() as $f) {
            $f = url($f);
            if ($this->request->fullUrlIs($f)) {
                return true;
            }
        }
        return false;
    }

    protected function routeIsDeeply() 
    {
        if ($this->request->route()===null) {
            return false;
        }
        
        foreach (func_get_args() as $r) {
            if (Str::is($r,$this->request->route()->getName())) {
                return true;
            }
        }
        return false;
    }
}