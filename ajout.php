<?php
	
	require "models/ajout.php";

	if(isset($_POST['submit']))
	{

	      $i = 0;
	      $message = "salut";
	      
	      extract($_POST);

	    	

	      if(empty($mdp) || !preg_match("#^[a-z0-9]{5,20}$#", $mdp))
	      {
	        $i++;
	        $message .= "Votre mot de passe n'est pas valide";
	      }


	      if(empty($email) || !preg_match("#^[a-z0-9._-]{2,20}@[a-z0-9._-]{2,20}\.[a-z]{2,6}$#", $email))
	      {
	        $i++;
	        $message .= "Votre email n'est pas valide";
	      }

	      if($i>0)
	      {
	        echo $message;
	      }

	      else
	      {
	      	insert_user($email, $login, $mdp);
	      }

	}
	  
	require "views/ajout.php";
?>