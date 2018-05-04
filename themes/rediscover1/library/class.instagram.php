<?php
/**
* Dokument til at hente instagram data
* Lavet af Lasse Flinker - lasse@siteloom.dk
*/

class instagramDriver {
	
	var $clientId;
	var $clientSecret;
	var $accessToken;
	var $url;
	
	/**
	*
	*/
	function __construct($clientId,$clientSecret,$accessToken) {
		$this->clientId = $clientId;
		$this->clientSecret = $clientSecret;
		$this->accessToken = $accessToken;
	}
	/**
	*
	*/
	function searchUsers($searchterm) {
		$this->url = "https://api.instagram.com/v1/users/search";
		$this->url .= "?q=".urlencode($searchterm);
		$this->url .= "&access_token=".$this->accessToken;
		
		return $this->sendRequest();
	}
	/**
	*
	*/
	function getRecentMediaByTagname($tagname) {
		
		$this->url = "https://api.instagram.com/v1/tags/".$tagname."/media/recent";
		$this->url .= "?client_id=".$this->clientId;
		
		return $this->sendRequest();
		
	}
	/**
	*
	*/
	function searchTags($searchterm) {
		$this->url = "https://api.instagram.com/v1/tags/search";
		$this->url .= "?q=".urlencode($searchterm);
		$this->url .= "&access_token=".$this->accessToken;
		
		return $this->sendRequest();
	}
	/**
	*
	*/
	function getMediaById($id) {
		$this->url = "https://api.instagram.com/v1/media/".$id;
		$this->url .= "?access_token=".$this->accessToken;
		
		return $this->sendRequest();
	}
	/**
	*
	*/
	function getRecentMediaByUserId($userid,$params=array()) {
		$this->url = "https://api.instagram.com/v1/users/".$userid."/media/recent";
		$this->url .= "?access_token=".$this->accessToken;
		
		if(count($params) > 0) {
			foreach($params as $key => $value) {
				$this->url .= "&".$key."=".$value;
			}
		}
		
		return $this->sendRequest();
	}
	/**
	*
	*/
	function getUserById($userid) {
		$this->url = "https://api.instagram.com/v1/users/".$userid;
		$this->url .= "?access_token=".$this->accessToken;
		
		return $this->sendRequest();
	}
	/**
	*
	*/
	function sendRequest() {
		$content = @file_get_contents($this->url);
		$JSON = json_decode($content);
		
		return $JSON;
	}
}


class instagram {
	
	var $instagram;
	
	/**
	*
	*/
	function __construct($clientId,$clientSecret,$accessToken) {
		$this->instagram = new instagramDriver($clientId,$clientSecret,$accessToken);
	}
	/**
	*
	*/
	function getRelevantDataFromImageData($imageData) {
		$data = array(
			"id" => $imageData->id,
			"username" => $imageData->user->username,
			"timecreated" => $imageData->created_time,
			"description" => $imageData->caption->text,
			"imagepath" => $imageData->images->standard_resolution->url,
			"imagelink" => $imageData->link
		);
		
		return $data;
	}
	/**
	*
	*/
	function getImageById($id) {
		
		$result = (array)$this->instagram->getMediaById($id);
		$imageData = $result["data"];
		
		return $this->getRelevantDataFromImageData($imageData);
	}
	/**
	*
	*/
	function getImagesByTagname($tagname) {
		
		$tagsFound = (array)$this->instagram->searchTags($tagname);
		$tagNameValid = false;
		if(is_array($tagsFound["data"]) && count($tagsFound["data"]) > 0) {
			foreach($tagsFound["data"] as $taginfo) {
				if(trim($taginfo->name) == trim($tagname)) {
					$tagNameValid = $taginfo->name;
					break;
				}
			}
		}
		
		if($tagNameValid) {
		
			$imagesData = (array)$this->instagram->getRecentMediaByTagname($tagNameValid);
			
			$images = array();
			if(is_array($imagesData["data"]) && count($imagesData["data"]) > 0) {
				foreach($imagesData["data"] as $imageData) {
					$images[] = $this->getRelevantDataFromImageData($imageData);
				}
			}
			return $images;
		}
		
		return false;
	}
	/**
	*
	*/
	function searchUsers($searchterm) {
		$users = false;
		$result = (array)$this->instagram->searchUsers($searchterm);
		if(is_array($result["data"]) && count($result["data"]) > 0) {
			foreach($result["data"] as $user) {
				$users[] = (array)$user;
			}
		}
		
		return $users;
	}
	/**
	*
	*/
	function getImagesByUser($userid,$params=array()) {
		
		$images = array();
		$result = (array)$this->instagram->getRecentMediaByUserId($userid,$params);
		if(is_array($result["data"]) && count($result["data"]) > 0) {
			foreach($result["data"] as $imageData) {
				
				if($imageData->type == "image") {
					$images[] = $this->getRelevantDataFromImageData($imageData);
				}	
			}
		}
		return $images;
	}
	/**
	*
	*/
	function getUserById($userid) {
		
		$user = false;
		$result = (array)$this->instagram->getUserById($userid);
		$data = (array)$result["data"];
		
		if(is_array($data) && count($data) > 0) {
			$user = $data;
		}
		
		return $user;
	}
	/**
	*
	*/
	function searchTags($searchterm) {
		$tags = false;
		$tagsFound = (array)$this->instagram->searchTags($searchterm);
		if(is_array($tagsFound["data"]) && count($tagsFound["data"]) > 0) {
			$tags = array();
			foreach($tagsFound["data"] as $taginfo) {
				$tags[] = $taginfo->name;
			}
		}
		return $tags;
	}
}
?>