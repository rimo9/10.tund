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
}?>