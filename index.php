<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>tuto html</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

	<form method="POST">
		<input type="text" name="pseudo" id="pseudo" placeholder="Votre Pseudo">
		<input type="email" name="email" id="email" placeholder="Votre Email">
		<input type="password" name="password" id="password" placeholder="Votre Mot de Passe">
		<input type="password" name="cpassword" id="cpassword" placeholder="Confirmez votre mot de passe">
		<input type="submit" name="formsend" id="formsend" value="Envoyer">
	</form>
	
</body>
</html>

<?php

	include'include/database.php';
	global $db;
	extract($_POST);

	if(isset($formsend)){
		if(!empty($pseudo) && !empty($email) && !empty($password) && !empty($cpassword)){
			if($password == $cpassword){

				$verifp = $db->prepare("SELECT pseudo FROM users WHERE pseudo = :pseudo");
				$verifp->execute(['pseudo' => $pseudo]);
				$resultp = $verifp->rowCount();

				if($resultp == 0){
					$verife = $db->prepare("SELECT email FROM users WHERE email = :email");
					$verife->execute(['email' => $email]);
					$resulte = $verife->rowCount();

					if($resulte == 0){
						$q = $db->prepare("INSERT INTO users(pseudo,email,password) VALUES(:pseudo,:email,:password)");
						$q->execute([
						'pseudo' => $pseudo,
						'email' => $email,
						'password' => $password
						]);
						echo "<span>FIOUUUU...requête envoyée !</span><br>";
					}else{
						echo "<span>Un compte utilise déja cet email...</span>";
					}
				}else{
					echo "<span>Un compte utilise déja ce pseudo...</span>";
				}

				
			}else{
				echo "<span>Les mots de passes ne sont pas identiques...</span><br>";
			}
		}else {
			echo "<span>Tous les champs ne sont pas remplis...</span><br>";
		}
	}

?>
