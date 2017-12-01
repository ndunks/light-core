<?php
namespace Light;
/**
* 
*/
class Data extends Magical
{
	private $__file;
	
	function __construct($name, $force_create = false)
	{
		$this->__file	= $file	= SYSTEM . "data/$name.json";
		if(file_exists($file))
		{
			$data	= json_decode(file_get_contents($file), true);
			/* Error ignored!
			if( json_last_error() != JSON_ERROR_NONE )
				throw new \Exception("Error parsing $file: " . json_last_error_msg());*/

			if( is_array($data) )
			{
				foreach ($data as $key => $value) {
					$this->$key	= $value;
				}
			}
		}elseif( !$force_create )
			throw new \Exception("Data $name not exists");

	}

	function lastMod()
	{
		return @filemtime($this->__file) ?: 0;
	}

	function save()
	{
		$data	= get_object_vars($this);
		unset($data['__file']);
		return file_put_contents($this->__file, json_encode($data));
	}
}