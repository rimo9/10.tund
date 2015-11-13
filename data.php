<?php
	// siia lisame auto nr märgite vormi
	//laeme funktsiooni failis
	require_once("functions.php");
	require_once("InterestManager.class.php");
	
	//kontrollin, kas kasutaja ei ole sisseloginud
	if(!isset($_SESSION["id_from_db"])){
		// suunan login lehele
		header("Location: login.php");
	}
	//login välja, aadressireal on ?logout=1
	if(isset($_GET["logout"])){
		//kustutab kõik sessiooni muutujad
		session_destroy();
		
		header("Location: login.php");
		exit();
	}
	$InterestManager=new InterestManager($mysqli);
	if(isset($_GET["new_interest"])){
		$interests_response = $InterestManager->addInterest($_GET["new_interest"]);
	}
?>

<p>
	Tere, <?=$_SESSION["user_email"];?>
	<a href="?logout=1"> Logi välja</a>
</p>

<h2>Lisa uus huviala</h2>
<form>
	<?php if(isset($interests_response->error)):?>
	<p style="color:red;"><?=$interests_response->error->message;?></p>
	<?php elseif(isset($interests_response->success)):?>
	<p style="color:green;"><?=$interests_response->success->message;?></p>
	<?php endif;?>
	<input name="new_interest">
	<input type="submit">
</form>