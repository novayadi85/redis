<?php 
class Cokspressrelease_Core_All
{ 
	private $accesslvl = 'manage_options';	
	private $versionTable = 'Version 1.0';
	private $plugName = 'cokspressrelease';
	private $postName = 'pressrelease';
	
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
	public function convertName($str)
	{
		return strtolower(str_replace(' ', '-',$str));
	}
}