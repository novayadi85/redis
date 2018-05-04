<?php 
function checkIsEmail($email)
{
	$return = FALSE;
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $return = FALSE; 
    }else{
		$return = TRUE;
	}
	
	return $return;
}
function emailToBusiness($post)
{
	$body = 'Hi ' . get_the_title((int) $post['post_id']); 
	$body .= "\r\n\r\nYou have a new enquiry from Re Discover Melbourne website.";
	$body .= "\r\n\r\nBelow are the details:";
	$body .= "\nName: " . trim($post['name']);
	$body .= "\nEmail: " . trim($post['email']);
	$body .= "\nPhone: " . trim($post['phone']);
	$body .= "\nMessage: \n" . trim($post['message']);

	$body .= "\r\n\r\nPlease follow up the enquiry.";

	$body .= "\r\n\r\nRegards,";

	$body .= "\r\n\r\nRediscover Melbourne Administrator";
	$body .= "\r\nwww.rediscovermelbourne.com.au";

	//$body .= get_permalink($post['post_id']);
	
	return $body;
}
function emailToGuest($post)
{
	$body = 'Hi ' . trim( $post['name']); 
	$body .= "\r\n\r\nYour enquiry for " .get_the_title((int) $post['post_id']). " on Re Discover Melbourne website has been sent successfully. Thank you for your enquiry. " .get_the_title((int) $post['post_id']). " will contact you with more information.";
	$body .= "\r\n\r\nBelow are the details:";
	$body .= "\nName: " . trim($post['name']);
	$body .= "\nEmail: " . trim($post['email']);
	$body .= "\nPhone: " . trim($post['phone']);
	$body .= "\nMessage: \n\r\n\r" . trim($post['message']);

	//$body .= "\r\n\r\nPlease follow up the enquiry.";

	$body .= "\r\n\r\nRegards,";

	$body .= "\r\n\r\nRediscover Melbourne Administrator";
	$body .= "\r\nwww.rediscovermelbourne.com.au";
	
	return $body;
}
 if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	if(!empty($_POST)){
		if(!empty($_POST['name']) || !empty($_POST['email']) || !empty($_POST['phone']) || !empty($_POST['b_to']) || !empty($_POST['message'] ) || empty($_POST['hashinput'] )){
			if(checkIsEmail($_POST['email'])){
				$to = $_POST['b_to'];
				$to_2 = $_POST['email'];
				$subject = 'A new enquiry from Re Discover Melbourne - ' . trim($_POST['name']);
				$subject_2 = "Your enquiry for ".get_the_title((int) $_POST['post_id'])." on Re Discover Melbourne";
				$bodyToBusiness = emailToBusiness($_POST);
				$bodyToGuest = emailToGuest($_POST);
				$headers = 'From: ' . $_POST['email'] . "\r\n" .
					'Reply-To: info@rediscovermelbourne.com.au' . "\r\n" .
					'X-Mailer: PHP/' . phpversion();
				$headers_2 = 'From: noreply@rediscovermelbourne.com.au' . "\r\n" .
					'Reply-To: info@rediscovermelbourne.com.au' . "\r\n" .
					'X-Mailer: PHP/' . phpversion();
				if(mail($to, $subject, $bodyToBusiness, $headers)){
					mail($to_2, $subject_2, $bodyToGuest, $headers_2);
					$data['error'] = false;
					$data['message'] = 'Thank you for contacting us.';
					$data['status'] = 'success';
				}else{
					$data['error'] = true;
					$data['message'] = 'Unable to submit your request.';
					$data['status'] = 'warning';
				}
			}else{
				$data['error'] = true;
				$data['message'] = 'Please input valid email.';
				$data['status'] = 'danger';
			}
			
		}else{
			$data['error'] = true;
			$data['message'] = 'Please fill out required field!';
			$data['status'] = 'danger';
		}
		
		 echo json_encode($data);
		
	}
 }else{
	 wp_redirect(home_url());
 }
 
 ?>