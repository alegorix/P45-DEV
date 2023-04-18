<?php
//register.php

include 'config.php';

if(isset($_POST['submit'])){
	
   $lastname = $_POST['lastname'];
   $lastname = filter_var($lastname, FILTER_SANITIZE_STRING);
   $firstname = $_POST['firstname'];
   $firstname = filter_var($firstname, FILTER_SANITIZE_STRING);
   $sexe = $_POST['sexe'];
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = md5($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = md5($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);
      $role = $_POST['role'];
         $classe = $_POST['classe'];



   

   $select = $conn->prepare("SELECT * FROM `p45_users` WHERE email = ?");
   $select->execute([$email]);

   if($select->rowCount() > 0){
      $message[] = 'Ce compte existe déjà !';
   }else{
      if($pass != $cpass){
         $message[] = 'Les mots de passe ne correspondent pas !';
      
      }else{
         $insert = $conn->prepare("INSERT INTO `p45_users`(nom, prenom, sexe, email, password, user_role, classe) VALUES(?,?,?,?,?,?,?)");
         $insert->execute([$lastname, $firstname, $sexe, $email, $cpass, $role, $classe]);
         if($insert){
            $message[] = 'Enregistrement réusssi !';
            header('location:login');
         }
      }
   }

}
$meta_title = "AP!P45 - Enregistrement";
$nav_right = array("login", "register");

include "includes/head.php";?>  
  <body>
	<?php include "includes/navbar.php";?> 
	  <main class="container" style="margin-top: 80px;">
		   <div class="row">
    <div class="col-md-3">
    </div>
    <div class="col-lg-6">
    <h2>Enregistrement</h2>
    



<?php
   if(isset($message)){
      foreach($message as $message){
         echo '
   <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <span>'.$message.'</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
         </div>
         ';
      }
   }
?>
   
	<form action="" method="post" enctype="multipart/form-data">
		<div class="mb-3">
			<label for="lastname" class="form-label">Nom</label>
			<input type="text" required class="form-control" id="lastname" name="lastname" placeholder="Entrez le nom">
		</div>
		
		<div class="mb-3">
			<label for="firstname" class="form-label">Prénom</label>
			<input type="text" required class="form-control" id="firstname" name="firstname" placeholder="Entrez le prénom">
		</div>
		
		
		<div class="mb-0">
			<label for="sexe" class="form-label">Sexe</label>
			</div>
			<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="sexe" id="sexe1" value="M" checked>
  <label class="form-check-label" for="sexe1">
    M
  </label>
  
			</div>
						<div class="form-check form-check-inline mb-3">

  <input class="form-check-input" type="radio" name="sexe" id="sexe2" value="F">
  <label class="form-check-label" for="sexe2">
   F
  </label>
			
			
			
			
			

		
				
				</div>
		
		
		
		
		<div class="mb-3">
			<label for="role" class="form-label">Rôle</label>

		<select id="roles-list" class="form-select" aria-label="Role" name="role" required>
  <option selected>Choisissez le rôle</option>
  <option value="eleve">Élève</option>
  <option value="prof">Professeur</option>
  <option value="educ">Educateur</option>
</select>
		
				</div>
		
		
		
				<div id="eleve" class="mb-3 option-target hidden">
			<label for="classe" class="form-label">Classe</label>

		<select class="form-select" aria-label="Classe" name="classe">
  <option selected value="0">Choisissez l'année</option>
  <option value="1">1ère</option>
  <option value="2">2ème</option>
  <option value="3">3ème</option>
    <option value="4">4ème</option>
  <option value="5">5ème</option>
  <option value="6">6ème</option>
</select>
		
				</div>

		<div class="mb-3">
			<label for="email" class="form-label">Email</label>
			<input type="email" required class="form-control" id="email" name="email" placeholder="Entrez l'adresse email">
  		</div>
  		
  		<div class="mb-3">
	  		<label for="pass" class="form-label">Mot de passe</label>
	  		<input type="password" required class="form-control" id="pass" name="pass" placeholder="Entrez le mot de passe">
  		</div>
  		
  		<div class="mb-3">
	  		<label for="cpass" class="form-label">Mot de passe (2x)</label>
	  		<input type="password" required class="form-control" id="cpass" name="cpass" placeholder="Confirmez le mot de passe">
  		</div>
  		
  		
     
      <input type="submit" class="btn btn-primary" value="Inscription" name="submit">
   </form>
   </div>
    <div class="col-md-3">
    </div>
       </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
  </body>
</html>