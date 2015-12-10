<?php

/**
 * @author saymon
 */
class Logger
{

	/**
	 * @param mixed $var
	 * @param string $exit
	 * @return void
	 */
	public static function dump($var, $exit = FALSE)
	{
	    print '<div style="background-color: #ffffff; padding: 3px; z-index: 1000;"><pre style="text-align: left; font: normal 14px Courier; color: #000000;">';

	    if ( is_array($var) || is_object($var) )
	    {
	    	print_r($var);
	    }
	    else
	    {
	    	var_dump($var);
	    }

	    print '</pre></div>';

	    if ( $exit ) exit;

	}

}