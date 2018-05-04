<?php 
class Cokscustomposts_Core_All
{ 
	private $accesslvl = 'manage_options';	
	private $versionTable = 'Version 1.0';
	private $plugName = 'cokscustomposts';
	private $postName = 'cokscustomposts';
	
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
	public function todoPosts()
	{
		$details = array(
			'name' => 'thingtodo',
			'names' => 'thingstodo',
			'capability' => 'page',
		);

		return (object) $details;
	}
}
