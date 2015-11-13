<?php
	// siia lisame auto nr märgite vormi
	//laeme funktsiooni failis
	require_once("functions.php");
	require_once("InterestManager.class.php");
	
	//kontrollin, kas kasutaja ei ole sisseloginud
	if(!isset($_SESSION["id_from_db"])){
		// suunan login lehele
		header("Location: login.php");
		exit();
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
	if(isset($_GET["dropdownselect"])){
		$added_user_interests = $InterestManager->addUserInterest($_GET["dropdownselect"], $_SESSION["id_from_db"]);
	}
?>

<p>
	Tere, <?=$_SESSION["user_email"];?>
	<a href="?logout=1"> Logi välja</a>
</p>

<h2>Lisa uus huviala</h2>
	<?php if(isset($interests_response->error)):?>
	<p style="color:red;"><?=$interests_response->error->message;?></p>
	<?php elseif(isset($interests_response->success)):?>
	<p style="color:green;"><?=$interests_response->success->message;?></p>
	<?php endif;?>
<form>
	<input name="new_interest">
	<input type="submit">
</form>

<h2>Minu huvialad</h2>
	<?php if(isset($added_user_interests->error)):?>
	<p style="color:red;"><?=$added_user_interests->error->message;?></p>
	<?php elseif(isset($added_user_interests->success)):?>
	<p style="color:green;"><?=$added_user_interests->success->message;?></p>
	<?php endif;?>
<form>
	<?=$InterestManager->createDropdown();?>
	<input type="submit">
</form>