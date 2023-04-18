<?php
//register.php


include 'config.php';

session_start();




if(isset($_POST['submit'])){

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = md5($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $select = $conn->prepare("SELECT * FROM `p45_users` WHERE email = ? AND password = ?");
   $select->execute([$email, $pass]);
   $row = $select->fetch(PDO::FETCH_ASSOC);

   if($select->rowCount() > 0){

      if($row['user_role'] == 'admin'){

         $_SESSION['admin_id'] = $row['id'];
         header('location:index_admin');

      }elseif($row['user_role'] == 'eleve'){

         $_SESSION['eleve_id'] = $row['id'];
         header('location:index_eleve');
         
         
      }elseif($row['user_role'] == 'prof'){

         $_SESSION['prof_id'] = $row['id'];
         header('location:index_prof');


	}elseif($row['user_role'] == 'educ'){

         $_SESSION['educ_id'] = $row['id'];
         header('location:index_educ');
   

      }else{
         $message[] = 'Aucun utilisateur renseigné !';
         $alert_style = 'alert-warning'; 
      }
      
   }else{
      $message[] = 'Email ou mot de passe incorrect !';
      $alert_style = 'alert-danger';
   }

}


$meta_title = "AP!P45 - Connexion";
$nav_right = array("login", "register");




include "includes/head.php";?>  
  <body>
	<?php include "includes/navbar.php";?> 
	  <main class="container" style="margin-top: 80px;">
		   <div class="row">
    <div class="col-md-3">
    </div>
    <div class="col-lg-6">
      <h2>Connexion</h2>
    



<?php
   if(isset($message)){
      foreach($message as $message){
         echo '
   <div class="alert '.$alert_style.' alert-dismissible fade show" role="alert">
            <span>'.$message.'</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
         </div>
         ';
      }
   }
?>
 
	<form action="" method="post" enctype="multipart/form-data">
		

		<div class="mb-3">
			<label for="email" class="form-label">Email</label>
			<input type="email" required class="form-control" id="email" name="email" placeholder="Entrez votre adresse email">
  		</div>
  		
  		<div class="mb-3">
	  		<label for="pass" class="form-label">Mot de passe</label>
	  		<input type="password" required class="form-control" id="pass" name="pass" placeholder="Entrez votre mot de passe">
  		</div>
  		
  		  		
  		
     
      <input type="submit" class="btn btn-primary" value="Connexion" name="submit">
   </form>

    </div>
    <div class="col-md-3">
    </div>
       </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  </body>
</html>