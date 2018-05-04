<?php
	global $wpdb;
	$table = $wpdb->prefix."bvactc";
	$table2 = $wpdb->prefix."bvactc_metadata";
	$hasils = $wpdb->get_results("SELECT `value` FROM  $table2 ORDER BY `bva_metadata_id` ASC");
	
	$cerror = NULL;
		$msg	= NULL;
			if(empty($_POST['fname'])){
				$cerror = 1;
				$msg 	= "Please filled out the require field!";
			}
			if(empty($_POST['email'])){
				$cerror = 1;
				$msg 	= "Please filled out the require field!";
			}
			if(empty($_POST['message'])){
				$cerror = 1;
				$msg 	= "Please filled out the require field!";
			}
			if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
				$cerror = 1;
				$msg 	= "Please input valid email address!";
			}
			
			$_POST['phone'] = empty($_POST['phone']) ? $_POST['phone'] = NULL : $_POST['phone'] = $_POST['phone'] ;
			
			if(!empty($_POST['dontfill'])){ //Anti-spam
				$cerror = 1;
				$msg = "Error submiting";
			}
			if(empty($cerror)){
				$msg = "Thank you for contacting Us"; 
				$wpdb->insert( $table, 
								array( 
									'bvactc_name' => $_POST['fname'], 
									'bvactc_email' => $_POST['email'],
									'bvactc_phone' => $_POST['phone'],
									'created_date' => date('Y-m-d')
								) 
							);
				$to = $hasils[0]->value ;
				$subject = $hasils[2]->value;
				$name = trim($_POST['fname']);
				$from	= trim($_POST['email']);
				
				//$messages = wp_magic_quotes( $_POST['message'] );
				if (get_magic_quotes_gpc()) {
					$messages = stripslashes($_POST['message']);
				}
				else {
					$messages = $_POST['message'];
				}
				
				$messages = utf8_decode($messages);
				$message = " <html>
								<head></head>
								<body>
									<h1>This is Contact From $name</h1>
									<br />
									<br />
									<table border='0'>
										<tr>
											<td width='150'><strong>Full Name</strong></td>
											<td>:</td>
											<td>$name</td>
										</tr>
										<tr>
											<td><strong>E-mail</strong></td>
											<td>:</td>
											<td>$from</td>
										</tr>
										<tr>
											<td><strong>Phone</strong></td>
											<td>:</td>
											<td>".$_POST['phone']."</td>
										</tr>
										<tr>
											<td><strong>Wedding Dates</strong></td>
											<td>:</td>
											<td>".$_POST['wdate']."</td>
										</tr>
										<tr>
											<td><strong>Ceremony/Events</strong></td>
											<td>:</td>
											<td>".$_POST['cplan']."</td>
										</tr>
										<tr>
											<td><strong>Number of Guests</strong></td>
											<td>:</td>
											<td>".$_POST['nguess']."</td>
										</tr>
										<tr>
											<td><strong>Accommodation/Location</strong></td>
											<td>:</td>
											<td>".$_POST['location']."</td>
										</tr>
										<tr>
											<td><strong>Budget</strong></td>
											<td>:</td>
											<td>".$_POST['budget']."</td>
										</tr>
										<tr>
											<td><strong>Message</strong></td>
											<td>:</td>
											<td width='400'>".$messages."</td>
										</tr>
									</table>
								</body>
							</html>";

				// Always set content-type when sending HTML email
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

				// More headers
				$headers .= 'From: ' . $from . '' . "\r\n";
				$headers .= 'Cc: '. $from . '' . "\r\n";

				mail($to,$subject,$message,$headers);
				
			}
			
			
			
?>
			
			