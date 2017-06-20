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
            foreach ($route as $r) {
                if ($this->checkRouteBoolean($r)) {
                    return $this->activeValue;
                }
            }
            return $this->inActiveValue;
        }

        return $this->checkActive($route,'routeIs');
    }

    /*
    * It is the main entry point to check using route name and return boolean
    */ 
    public function checkRouteBoolean($route)
    {
        if (is_array($route)) {
            foreach ($route as $r) {
                if ($this->request->routeIs($r)) {
                    return true;
                }
            }
            return false;
        }
        return $this->request->routeIs($route);
    }

    /*
    * It is the main entry point to check using fullurl including query
    */ 
    public function checkQuery($fullUrlWithQuery,$active=null,$inactive=null)
    {
        $this->setReturnValue($active,$inactive);

        if (is_array($fullUrlWithQuery)) {
            foreach ($fullUrlWithQuery as $f) {
                $f = url($f);
                if ($this->checkQueryBoolean($f)) {
                    return $this->activeValue;
                }
            }
            return $this->inActiveValue;
        }

        // Here we have to transform to domain base full query
        // Since fullUrlIs also check domain name, if we dont transform here
        // User have to type those lenghty domain name
        $fullUrlWithQuery = url($fullUrlWithQuery);
        return $this->checkActive($route,'fullUrlIs');
    }

    /*
    * It is the main entry point to check using route name and return boolean
    */ 
    public function checkQueryBoolean($fullUrlWithQuery)
    {
        if (is_array($fullUrlWithQuery)) {
            foreach ($fullUrlWithQuery as $f) {
                $f = url($f);
                if ($this->request->fullUrlIs($f)) {
                    return true;
                }
            }
            return false;
        }
        $fullUrlWithQuery = url($fullUrlWithQuery);
        return $this->request->fullUrlIs($fullUrlWithQuery);
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
}