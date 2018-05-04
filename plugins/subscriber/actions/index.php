<?php
include_once( dirname(dirname(dirname(dirname(dirname(__FILE__))))) . DIRECTORY_SEPARATOR .'wp-load.php' );
function process_reg(){ 
	ob_start();
		$data['error'] = TRUE;
		if(!empty($_POST)){
			if(!empty($_POST['email'])){
				if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
					$data['error'] = TRUE;
					$data['message'] = 'Please input valid email';
				}else{
					$email = sanitize_text_field($_POST['email']);
					global $wpdb;
					$table = $wpdb->prefix."subscriber";
					$hasils = $wpdb->get_results("SELECT * FROM  $table WHERE `email` ='" .$_POST['email']."'");
					if(count($hasils) > 0 ){
						if($hasils[0]->status == 0){
							$query = ("UPDATE " . $table . " SET `status` = 1, `name` = 'Anynamous',`revision_date` = '". date("Y-m-d") ."' WHERE `subscriber_id` = '" . $hasils[0]->subscriber_id . "'");
							if($wpdb->query($query)){
								$data['error'] = FALSE; 
								$data['message'] = "Thank you for registered to our newsletter.";
							}else{
								$data['error'] = TRUE; 
								$data['message'] = "Sorry, unable to submit your request. Please try again later.";
							}
						}else{
							$data['error'] = TRUE; 
							$data['message'] = "Sorry, you already registered.";
						}
					}else{
						$query = ("INSERT INTO `{$table}` (`name`, `email`,`status`, `created_date`) VALUES ('Anynamous','{$email}',1,'". date("Y-m-d") ."')");
						$fields = array('Anynamous',
							$email,
							1,
							date('Y-m-d')
						);
				if($wpdb->query( 
					$wpdb->prepare( 
							"INSERT INTO {$table} ( `name`, `email`, `status`, `created_date`) VALUES ( '%s', '%s', '%s', '%s')", 
							$fields
						) 
					)
				){
					$data['error'] = FALSE;
					$data['message'] = "Thank you for subscribing to our newsletter!";
				}else{
					$data['error'] = TRUE; 
					$data['message'] = "Sorry, unable to submit your request. Please try again later. " . mysql_error();
				}
						/* if(mysql_query($query)){
							$data['error'] = FALSE;
							$data['message'] = "Thank you for subsribe our newsletter";						
						}else{
							$data['error'] = TRUE; 
							$data['message'] = "Sorry, unable to submit your request. Please try again later. " . mysql_error();
						} */
					}
				}
				
								
			}else{
				$data['error'] = TRUE;
				$data['message'] = "Please fill out required field!";
			}
			unset($_POST);	
			echo json_encode($data);
		}else{
			wp_redirect('index.php');
		}
		
	return ob_get_clean();
	
}

echo process_reg();
 
