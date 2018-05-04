<?php
class Coksbusiness_Core_Coksbusiness extends Coksbusiness_Core_All
{
	
	function __construct($file){
		register_activation_hook($file, array(&$this, 'install'));
		add_action('plugins_loaded',  array(&$this, 'myplugin_update_db_check'));
		
		/* Runs on plugin deactivation*/
		register_deactivation_hook($file, array(&$this, 'remove'));
	}
	
	public function install(){
		add_option($this->getPluginName(), $this->getVersion());
		$installed_ver = get_option( $this->getPluginName() );

		if( $installed_ver != $this->getVersion() ) {
			update_option( $this->getPluginName(), $this->getVersion() );
		}
	}
	
	public function myplugin_update_db_check() {
		if (get_site_option($this->getPluginName()) != $this->getVersion()) {
			$this->install();
		}
	}
	
	public function remove() {
		delete_option($this->getPluginName());
	}	
	
}