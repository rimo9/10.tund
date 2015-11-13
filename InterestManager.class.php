<?php
class InterestManager{
	private $connection;
	function __construct($mysqli){
		$this->connection=$mysqli;
	}
	function addInterest($new_interest){
		$response=new StdClass();
		$stmt=$this->connection->prepare("SELECT id FROM interests WHERE name = ?");
		$stmt->bind_param("s", $new_interest);
		$stmt->execute();
		if($stmt->fetch()){
			$error=new StdClass();
			$error->id=0;
			$error->message="interest already in the list";
			$response->error=$error;
			return $response;
		}
		$stmt->close();
		$stmt=$this->connection->prepare("INSERT INTO interests (name) VALUES (?)");
		$stmt->bind_param("s", $new_interest);
		if($stmt->execute()){
			$success=new StdClass();
			$success->message="Successfully added new interest";
			$response->success=$success;
		}else{
			$error=new StdClass();
			$error->id=1;
			$error->message="Something broke";
			$response->error=$error;
		}
		$stmt->close();
		return $response;
	}
	function createDropdown(){
		$html = '';
		$html.='<select name="dropdownselect">';
		$stmt=$this->connection->prepare("SELECT id, name from interests");
		$stmt->bind_result($id, $name);
		$stmt->execute();
		while($stmt->fetch()){
			$html.='<option value="'.$id.'">'.$name.'</option>';
		}
		$stmt->close();
		$html.='</select>';
		return $html;
	}
	function addUserInterest($new_interest_id, $user_id){
		$response=new StdClass();
		$stmt=$this->connection->prepare("SELECT user_id FROM user_interests WHERE interests_id = ? AND user_id = ?");
		$stmt->bind_param("ii", $new_interest_id, $user_id);
		$stmt->execute();
		if($stmt->fetch()){
			$error=new StdClass();
			$error->id=0;
			$error->message="interest already in your list";
			$response->error=$error;
			return $response;
		}
		$stmt->close();
		$stmt=$this->connection->prepare("INSERT INTO user_interests (user_id, interests_id) VALUES (?, ?)");
		$stmt->bind_param("ii", $user_id, $new_interest_id);
		if($stmt->execute()){
			$success=new StdClass();
			$success->message="Successfully saved new interest";
			$response->success=$success;
		}else{
			$error=new StdClass();
			$error->id=1;
			$error->message="Something broke";
			$response->error=$error;
		}
		$stmt->close();
		return $response;
	}
}?>