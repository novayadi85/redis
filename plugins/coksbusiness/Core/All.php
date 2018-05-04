<?php 
class Coksbusiness_Core_All
{ 
	private $accesslvl = 'manage_options';	
	private $versionTable = 'Version 1.0';
	private $plugName = 'cokbusiness';
	private $postName = 'Business';
	
	public function getPluginName()
	{
		return $this->plugName;
	}
	public function getVersion()
	{
		return $this->versionTable;
	}
	public function getAccessLevel()
	{
		return $this->accesslvl;
	}
	public function getPostName()
	{
		return $this->postName;
	}
	
	public function convert_day($i)
	{
		$array = array(1 => "Sunday", 2 => "Monday", 3 => "Tuesday", 4 => "Wednesday", 5 => "Thursday", 6 => "Friday", 7 => "Saturday" );
		return $array[$i];
	}
}