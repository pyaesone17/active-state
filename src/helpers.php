<?php


    /**
     * Generate a HTML link to a controller action.
     *
     * @param string $url
     * @param string $deep
     * @param array  $active
     * @param array  $inactive
     *
     * @return string
     */
    if (! function_exists('active_check')) {

        function active_check($url,$deep=false,$active=null,$inactive=null)
        {
            return app('active-state')->check($url, $deep, $active, $inactive);     
        }
    }

    /**
     * Generate a HTML link to a controller action.
     *
     * @param string $url
     * @param string $deep
     * @param array  $active
     * @param array  $inactive
     *
     * @return string
     */
    if (! function_exists('active_route')) {

        function active_route($url,$active=null,$inactive=null)
        {
            return app('active-state')->checkRoute($url, $active, $inactive);     
        }
    }


    /**
     * Generate a HTML link to a controller action.
     *
     * @param string $url
     * @param string $deep
     * @param array  $active
     * @param array  $inactive
     *
     * @return string
     */
    if (! function_exists('active_query')) {

        function active_query($url,$active=null,$inactive=null)
        {
            return app('active-state')->checkQuery($url, $active, $inactive);     
        }
    }

