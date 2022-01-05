	<?php
	session_start();
	 
	$bdd = new PDO('mysql:host=127.0.0.1;dbname=espace_membre', 'root', '1234');
	 
	if(isset($_POST['formconnexion'])) {
	   $mailconnect = htmlspecialchars($_POST['mailconnect']);
	   $mdpconnect = sha1($_POST['mdpconnect']);
	   if(!empty($mailconnect) AND !empty($mdpconnect)) {
	      $requser = $bdd->prepare("SELECT * FROM membres WHERE mail = ? AND motdepasse = ?");
	      $requser->execute(array($mailconnect, $mdpconnect));
	      $userexist = $requser->rowCount();
	      if($userexist == 1) {
	         $userinfo = $requser->fetch();
	         $_SESSION['id'] = $userinfo['id'];
	         $_SESSION['pseudo'] = $userinfo['pseudo'];
	         $_SESSION['mail'] = $userinfo['mail'];
	         header("Location: index.php?id=".$_SESSION['id']);
	      } else {
	         $erreur = "Mauvais mail ou mot de passe !";
	      }
	   } else {
	      $erreur = "Tous les champs doivent être complétés !";
	   }
	}
	?>
	<html>
	   <head>
	       <meta charset="UTF-8">
   <meta name="description" content="Add a Google Sign-in button to your HTML+JavaScript app">
    <meta name="google-signin-client_id" content="247219641427-03rg1f2pcjosj7lts7mal355juad7vs5.apps.googleusercontent.com">
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Connexion</title>
	<link rel="stylesheet" href="style1.css">


	   </head>
	   <body>
	   <div class="hero">
              <div class="form-box">
	       <div class="button-box">
			<div id="btn"></div>
	      <button class="toggle-btn" onclick="logined()">Login</button>
            </div>		  
		 <div align="center" class="container">
	         <h2>Connexion</h2>
	         <br /><br />
			 
	         <form id="login" class="input-group" method="POST" action="" >
	            <input type="email" name="mailconnect" class="input-field" placeholder="Mail"  />
	            <input type="password" name="mdpconnect" class="input-field" placeholder="Mot de passe" />
				<input type="checkbox" class="check-box"><span>Remember Password</span>
	            <br /><br />
	           <input type="submit" name="formconnexion" class="submit-btn" value="Se connecter !" />
	         </form>
	         <?php
	         if(isset($erreur)) {
	            echo '<font color="red">'.$erreur."</font>";
	         }
	         ?>
			  
	      </div>
		  <script src="main.js"></script>
		 
	   </body>
	</html>