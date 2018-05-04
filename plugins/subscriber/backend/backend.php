<?php
class setSubscriber{
	private $hook = 'subscriber';
	private $accesslvl = 'manage_options';
	public $filename = 'subscriber/subscriber.php';
	
	
	public $versionTable = 'Version 1.0 Dev';
	public $plugName = 'subscriber';
	
	function __construct($file){
		register_activation_hook($file, array(&$this, 'subscribe_install'));
		add_action('plugins_loaded',  array(&$this, 'myplugin_update_db_check'));
		
		/* Runs on plugin deactivation*/
		register_deactivation_hook($file, array(&$this, 'subscribe_remove'));
		add_action('admin_menu', array(&$this, 'subscribe_actions'));
	}
	
	function subscribe_install(){
		global $wpdb;
		$table = $wpdb->prefix . "subscriber"; //table name
		//$table2 = $wpdb->prefix . "bvactc_metadata"; //table name
		$structure = "CREATE TABLE IF NOT EXISTS $table(
						`subscriber_id` INT(11) NOT NULL AUTO_INCREMENT,
						`name` VARCHAR(50) NOT NULL,
						`email` VARCHAR(50) NOT NULL,
						`company` VARCHAR(50) NOT NULL,
						`country` VARCHAR(50) NOT NULL,
						`state` VARCHAR(50) NOT NULL,
						`zipcode` VARCHAR(50) NOT NULL,
						`phone` VARCHAR(50) NOT NULL,
						`status` INT(1) NOT NULL,
						`created_date` DATE,
						`revision_date` DATE,
						PRIMARY KEY (`subscriber_id`)
					)ENGINE=InnoDB;";
		/*
		$structure2 = "CREATE TABLE IF NOT EXISTS $table2(
						`bva_metadata_id` INT(11) NOT NULL AUTO_INCREMENT,
						`name` VARCHAR(30) NOT NULL,
						`value` TEXT NOT NULL,
						PRIMARY KEY (`bva_metadata_id`)
					)ENGINE=InnoDB;
						INSERT INTO $table2 (`bva_metadata_id`, `name`, `value`) VALUES
						(NULL, 'recipient_email', 'admin@localhost'),
						(NULL, 'recipient_name', 'admin'),
						(NULL, 'email_subject', 'Contact Us')
						;
					";
		*/ 
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
				dbDelta($structure);
				dbDelta($structure2);
		
		add_option($this->plugName, $this->versionTable);
		$installed_ver = get_option( $this->plugName );

		if( $installed_ver != $this->versionTable ) {
			update_option( $this->plugName, $this->versionTable );
		}
	}
	
	function myplugin_update_db_check() {
		//global $jal_db_version;
		if (get_site_option($this->plugName) != $this->versionTable) {
			$this->subscribe_install();
		}
	}
	
	function subscribe_remove() {
		/* Deletes the database table */
		delete_option($this->plugName);
	}	
	
	function subscribe_list(){
		require "views/subscriber_list.php";
	}
	function subscribe_setting(){
		require "views/subscriber_setting.php";
	}
	function subscribe_export(){
		require "views/subscriber_export.php";
	}
	
	function subscribe_actions() {
		add_menu_page('Configuration Subscriber', 'Subscriber', $this->accesslvl , $this->hook , array($this,'subscribe_list'), plugins_url('subscriber/images/icon.png'));
		add_submenu_page($this->hook, "Export list", "Export", $this->accesslvl, $this->hook.'_export', array($this,'subscribe_export'));
		//add_submenu_page($this->hook, "Export list", "Export", $this->accesslvl, $this->hook.'&action=export', array($this,'subscribe_export'));
	}
	
}