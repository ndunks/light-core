<?php
namespace Light;
/**
* 
*/
class Page
{

	static

		$template	= 'template.php',

		$content	= 'content/home.php',

		$title		= 'Light Framework',

		$desc		= '',

		$keyw		= '',

		$canoncial	= '', // Canoncial URL

		$param		= [],
		
		$data		= [];

	static function input( $method )
	{

	}

	static function process()
	{
		
	}

	static function output()
	{

		include VIEW . static::$template;
	}

	static function content()
	{
		extract( static::$data );

		include VIEW . static::$content;

	}

}