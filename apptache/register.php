
<?php
	$bdd = new PDO('mysql:host=127.0.0.1;dbname=espace_membre', 'root', '1234');
	 
	if(isset($_POST['forminscription'])) {
	   $pseudo = htmlspecialchars($_POST['pseudo']);
	   $mail = htmlspecialchars($_POST['mail']);
	   $mail2 = htmlspecialchars($_POST['mail2']);
	   $mdp = sha1($_POST['mdp']);
	   $mdp2 = sha1($_POST['mdp2']);
	   if(!empty($_POST['pseudo']) AND !empty($_POST['mail']) AND !empty($_POST['mail2']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2'])) {
	      $pseudolength = strlen($pseudo);
	      if($pseudolength <= 255) {
	         if($mail == $mail2) {
	            if(filter_var($mail, FILTER_VALIDATE_EMAIL)) {
	               $reqmail = $bdd->prepare("SELECT * FROM membres WHERE mail = ?");
	               $reqmail->execute(array($mail));
	               $mailexist = $reqmail->rowCount();
	               if($mailexist == 0) {
	                  if($mdp == $mdp2) {
	                     $insertmbr = $bdd->prepare("INSERT INTO membres(pseudo, mail, motdepasse) VALUES(?, ?, ?)");
	                     $insertmbr->execute(array($pseudo, $mail, $mdp));
	                     $erreur = "Votre compte a bien été créé ! <a href=\"connexion.php\">Me connecter</a>";
	                  } else {
	                     $erreur = "Vos mots de passes ne correspondent pas !";
	                  }
	               } else {
	                  $erreur = "Adresse mail déjà utilisée !";
	               }
	            } else {
	               $erreur = "Votre adresse mail n'est pas valide !";
	            }
	         } else {
	            $erreur = "Vos adresses mail ne correspondent pas !";
	         }
	      } else {
	         $erreur = "Votre pseudo ne doit pas dépasser 255 caractères !";
	      }
	   } else {
	      $erreur = "Tous les champs doivent être complétés !";
	   }
	}
	?>
<!DOCTYPE html>
<html>
<head>
 <meta charset="UTF-8">
   <meta name="description" content="Add a Google Sign-in button to your HTML+JavaScript app">
    <meta name="google-signin-client_id" content="247219641427-03rg1f2pcjosj7lts7mal355juad7vs5.apps.googleusercontent.com">
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Inscription</title>
	<link rel="stylesheet" href="style1.css">
</head>
<body>
            <div class="hero">
              <div class="button-box">
			  <div id="btn"></div>
			  </div>
			</div>
	      <button class="toggle-btn" onclick="logined()">S'enregistrer</button>
            </div>		  
	      <div align="center" class="container">
	         <h2>Inscription</h2>
	         <br /><br />
	         <form id="register" class="input-group" method="POST" action="" >
	            
	                     <input type="text" class="input-field" placeholder="Votre pseudo" id="pseudo"  name="pseudo" value="<?php if(isset($pseudo)) { echo $pseudo; } ?>" />
	                  
	                     <input type="email" class="input-field"placeholder="Votre mail" id="mail"  name="mail" value="<?php if(isset($mail)) { echo $mail; } ?>" />	                 
	                     <input type="email" class="input-field" placeholder="Confirmez votre mail" id="mail2"  name="mail2" value="<?php if(isset($mail2)) { echo $mail2; } ?>" />	                 	                    
	                     <input type="password" class="input-field" placeholder="Votre mot de passe" id="mdp"  name="mdp" />	                  
	                     <input type="password" class="input-field" placeholder="Confirmez votre mdp" id="mdp2"  name="mdp2" />	                 	               
	                     <button type="checkbox" class="check-box"><span>J'accepte les thermes & les conditions</span>	
						 <br/><br/>
						 <input type="submit" name="forminscription" class="submit-btn" value="Je m'inscris" />	     
                         					 
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