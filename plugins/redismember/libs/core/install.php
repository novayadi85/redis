<?php 
class Core_Install {
	
	public $name = "redis_";
	
	
	public function installer() {
        global $wpdb;
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        $charset_collate = '';
        if (!empty($wpdb->charset)) {
            $charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
        } else {
            $charset_collate = "DEFAULT CHARSET=utf8";
        }
        if (!empty($wpdb->collate)) {
            $charset_collate .= " COLLATE $wpdb->collate";
        }

        $sql = "CREATE TABLE " . $wpdb->prefix . "redis_members_tbl (
			member_id int(12) NOT NULL PRIMARY KEY AUTO_INCREMENT,
			user_name varchar(255) NOT NULL,
			first_name varchar(64) DEFAULT '',
			last_name varchar(64) DEFAULT '',
			password varchar(255) NOT NULL,
			member_since date NOT NULL DEFAULT '0000-00-00',
			membership_level smallint(6) NOT NULL,
			more_membership_levels VARCHAR(100) DEFAULT NULL,
			account_state enum('active','inactive','expired','pending','unsubscribed') DEFAULT 'pending',
			last_accessed datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			last_accessed_from_ip varchar(128) NOT NULL,
			email varchar(255) DEFAULT NULL,
			phone varchar(64) DEFAULT NULL,
			address_street varchar(255) DEFAULT NULL,
			address_city varchar(255) DEFAULT NULL,
			address_state varchar(255) DEFAULT NULL,
			address_zipcode varchar(255) DEFAULT NULL,
			home_page varchar(255) DEFAULT NULL,
			country varchar(255) DEFAULT NULL,
			gender enum('male','female','not specified') DEFAULT 'not specified',
			referrer varchar(255) DEFAULT NULL,
			extra_info text,
			reg_code varchar(255) DEFAULT NULL,
			subscription_starts date DEFAULT NULL,
			initial_membership_level smallint(6) DEFAULT NULL,
			txn_id varchar(255) DEFAULT '',
			subscr_id varchar(255) DEFAULT '',
			company_name varchar(255) DEFAULT '',
			notes text DEFAULT NULL,
			flags int(11) DEFAULT '0',
			profile_image varchar(255) DEFAULT ''
          )" . $charset_collate . ";";
        dbDelta($sql);

        $sql = "CREATE TABLE " . $wpdb->prefix . "redis_membership_tbl (
			id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
			alias varchar(127) NOT NULL,
			role varchar(255) NOT NULL DEFAULT 'subscriber',
			permissions tinyint(4) NOT NULL DEFAULT '0',
			subscription_period varchar(11) NOT NULL DEFAULT '-1',
                        subscription_duration_type tinyint NOT NULL default 0,
			subscription_unit   VARCHAR(20)        NULL,
			loginredirect_page  text NULL,
			category_list longtext,
			page_list longtext,
			post_list longtext,
			comment_list longtext,
			attachment_list longtext,
			custom_post_list longtext,
			disable_bookmark_list longtext,
			options longtext,
                        protect_older_posts  tinyint(1) NOT NULL DEFAULT '0',
			campaign_name varchar(255) NOT NULL DEFAULT ''
          )" . $charset_collate . " AUTO_INCREMENT=1 ;";
        dbDelta($sql);
        $sql = "SELECT * FROM " . $wpdb->prefix . "redis_membership_tbl WHERE id = 1";
        $results = $wpdb->get_row($sql);
        if (is_null($results)) {
            $sql = "INSERT INTO  " . $wpdb->prefix . "redis_membership_tbl  (
			id ,
			alias ,
			role ,
			permissions ,
			subscription_period ,
			subscription_unit,
			loginredirect_page,
			category_list ,
			page_list ,
			post_list ,
			comment_list,
			disable_bookmark_list,
			options,
			campaign_name
			)VALUES (1 , 'Content Protection', 'administrator', '15', '0',NULL,NULL, NULL , NULL , NULL , NULL,NULL,NULL,'');";
            $wpdb->query($sql);
        }
        $sql = "UPDATE  " . $wpdb->prefix . "redis_membership_tbl SET subscription_duration_type = 1 WHERE subscription_unit='days' AND subscription_duration_type = 0";
        $wpdb->query($sql);

        $sql = "UPDATE  " . $wpdb->prefix . "redis_membership_tbl SET subscription_duration_type = 2 WHERE subscription_unit='weeks' AND subscription_duration_type = 0";
        $wpdb->query($sql);

        $sql = "UPDATE  " . $wpdb->prefix . "redis_membership_tbl SET subscription_duration_type = 3 WHERE subscription_unit='months' AND subscription_duration_type = 0";
        $wpdb->query($sql);

        $sql = "UPDATE  " . $wpdb->prefix . "redis_membership_tbl SET subscription_duration_type = 4 WHERE subscription_unit='years' AND subscription_duration_type = 0";
        $wpdb->query($sql);

        $sql = "CREATE TABLE " . $wpdb->prefix . "redis_membership_meta_tbl (
                    id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    level_id int(11) NOT NULL,
                    meta_key varchar(255) NOT NULL,
                    meta_label varchar(255) NULL,
                    meta_value text,
                    meta_type varchar(255) NOT NULL DEFAULT 'text',
                    meta_default text,
                    meta_context varchar(255) NOT NULL DEFAULT 'default',
                    KEY level_id (level_id)
        )" . $charset_collate . " AUTO_INCREMENT=1;";
        dbDelta($sql);

        $sql = "CREATE TABLE " . $wpdb->prefix . "redis_payments_tbl (
                    id int(12) NOT NULL PRIMARY KEY AUTO_INCREMENT,
                    email varchar(255) DEFAULT NULL,
                    first_name varchar(64) DEFAULT '',
                    last_name varchar(64) DEFAULT '',
                    member_id varchar(16) DEFAULT '',
                    membership_level varchar(64) DEFAULT '',
                    txn_date date NOT NULL default '0000-00-00',
                    txn_id varchar(255) NOT NULL default '',
                    subscr_id varchar(255) NOT NULL default '',
                    reference varchar(255) NOT NULL default '',
                    payment_amount varchar(32) NOT NULL default '',
                    gateway varchar(32) DEFAULT '',
                    status varchar(16) DEFAULT '',
                    ip_address varchar(128) default ''
                    )" . $charset_collate . ";";
        dbDelta($sql);

        //Save the current DB version
        update_option("redis_db_version", REDIS_WP_MEMBERSHIP_VER);
    }
	
	
}