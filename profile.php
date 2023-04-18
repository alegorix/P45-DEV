<?php
//profile.php

include 'config.php';

session_start();

if(isset($_SESSION['prof_id'])){
   $user_id = $_SESSION['prof_id'];

};
if(isset($_SESSION['eleve_id'])){
$user_id = $_SESSION['eleve_id'];

};

if(isset($_SESSION['educ_id'])){
$user_id = $_SESSION['educ_id'];

};

if(isset($_SESSION['admin_id'])){
$user_id = $_SESSION['admin_id'];

};




if(!isset($user_id)){
   header('location:login');
};

$select_profile = $conn->prepare("SELECT * FROM `p45_users` WHERE id = ?");
      $select_profile->execute([$user_id]);
      $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);



if(isset($_POST['submit'])){
	
   $lastname = $_POST['lastname'];
   $lastname = filter_var($lastname, FILTER_SANITIZE_STRING);
   $firstname = $_POST['firstname'];
   $firstname = filter_var($firstname, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   
   $update_profile = $conn->prepare("UPDATE `p45_users` SET nom = ?, prenom = ?, email = ? WHERE id = ?");
   $update_profile->execute([$lastname, $firstname, $email, $user_id]);
   
   
   
   
   

   $old_pass = $_POST['old_pass'];
   $previous_pass = md5($_POST['previous_pass']);
   $previous_pass = filter_var($previous_pass, FILTER_SANITIZE_STRING);
   $new_pass = md5($_POST['new_pass']);
   $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
   $confirm_pass = md5($_POST['confirm_pass']);
   $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);

   if(!empty($previous_pass) || !empty($new_pass) || !empty($confirm_pass)){
      if ((empty($previous_pass)) && ($previous_pass != $old_pass)){
         $message[] = 'Ancien mot de passe incorrect !';
      }elseif($new_pass != $confirm_pass){
         $message[] = 'Les mots de passe ne correspondent pas !';
      }else{
         $update_password = $conn->prepare("UPDATE `p45_users` SET nom = ?, prenom = ?, email = ?, password = ? WHERE id = ?");
         $update_password->execute([$lastname, $firstname, $email,$confirm_pass, $user_id]);
         $message[] = 'Modification(s) réalisée(s) !';
         
      }
         header('location:profile');

   }


}
$meta_title = "AP!P45 - Profile";
$nav_right = array("logout", "profile");

include "includes/head.php";?>  
  <body>
	<?php include "includes/navbar.php";?> 
	  <main class="container" style="margin-top: 80px;">
		   <div class="row">
    <div class="col-md-3">
    </div>
    <div class="col-lg-6">
    <h2>Profil <?= $fetch_profile['prenom']; ?> <?= $fetch_profile['nom']; ?></h2>
    



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



<?php
      
   ?>
   
	<form action="" method="post" enctype="multipart/form-data">
		<div class="mb-3">
			<label for="lastname" class="form-label">Nom</label>
			<input type="text" class="form-control" id="lastname" name="lastname" value="<?= $fetch_profile['nom']; ?>" readonly>
		</div>
		
		<div class="mb-3">
			<label for="firstname" class="form-label">Prénom</label>
			<input type="text" class="form-control" id="firstname" name="firstname" value="<?= $fetch_profile['prenom']; ?>"readonly>
		</div>
		
		
		
		<div class="mb-3">
			<label for="sexe" class="form-label">Sexe</label>

		<select class="form-select" aria-label="Sexe" name="sexe" disabled>
  <option value="M"<?=$fetch_profile['sexe'] == 'M' ? ' selected="selected"' : ''?>>M</option>
  <option value="F"<?=$fetch_profile['sexe'] == 'F' ? ' selected="selected"' : ''?>>F</option>
 </select>
	</div>
		
		
		
		
		
		
		
				<div class="mb-3">
			<label for="classe" class="form-label">Classe</label>

		<select class="form-select" aria-label="Classe" name="classe" disabled>
  <option selected value="0"<?=$fetch_profile['classe'] == '0' ? ' selected="selected"' : ''?>>Non-Applicable</option>
  <option value="1"<?=$fetch_profile['classe'] == '1' ? ' selected="selected"' : ''?>>1ère</option>
  <option value="2"<?=$fetch_profile['classe'] == '2' ? ' selected="selected"' : ''?>>2ème</option>
  <option value="3"<?=$fetch_profile['classe'] == '3' ? ' selected="selected"' : ''?>>3ème</option>
    <option value="4"<?=$fetch_profile['classe'] == '4' ? ' selected="selected"' : ''?>>4ème</option>
  <option value="5"<?=$fetch_profile['classe'] == '5' ? ' selected="selected"' : ''?>>5ème</option>
  <option value="6"<?=$fetch_profile['classe'] == '6' ? ' selected="selected"' : ''?>>6ème</option>
  
  

</select>
		
				</div>

		<div class="mb-3">
			<label for="email" class="form-label">Email</label>
			<input type="email" class="form-control" id="email" name="email" placeholder="Entrez l'adresse email" value="<?= $fetch_profile['email']; ?>">
  		</div>
  		
  		<div class="mb-3">
	  		            <input type="hidden" name="old_pass" value="<?= $fetch_profile['password']; ?>">

	  		<label for="previous_pass" class="form-label">Ancien Mot de passe</label>
	  		<input type="password" class="form-control" id="previous_pass" name="previous_pass" placeholder="Entrez le mot de passe">
  		</div>
  		
  		<div class="mb-3">
	  		<label for="new_pass" class="form-label">Nouveau Mot de passe</label>
	  		<input type="password" class="form-control" id="new_pass" name="new_pass" placeholder="Entrez le mot de passe">
  		</div>
  		
  		<div class="mb-3">
	  		<label for="confirm_pass" class="form-label">Mot de passe (2x)</label>
	  		<input type="password" class="form-control" id="confirm_pass" name="confirm_pass" placeholder="Confirmez le mot de passe">
  		</div>
  		
  		
     
      <input type="submit" class="btn btn-primary" value="Modifier le profil" name="submit">
   </form>
   </div>
    <div class="col-md-3">
    </div>
       </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
  </body>
</html>