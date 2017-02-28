<!--***** SESSION 'OFF' *****************************************************************************************************************************************-->    
       <?php 
        if(empty($_POST["connexion"]) && $_SESSION==false)
        {
            if(empty($_POST["sinscrire"]))
            {
/***** INSCRIPTION EN BDD *********************************************************************************************************************************************/
                if(isset($_POST['jeminscris']))
                {
                    if($_POST['g-recaptcha-response']==true)
                    {
                        $message="";
                        $level=0;
                        $i=0;
                        $j=0;
                        
                        extract($_POST);

                        $recupemail = $bdd->query("SELECT email FROM user WHERE email ='".$email."'");
                        $testEmail=$recupemail->fetch();
                        
                        if(empty($retapermdp) || $mdp != $retapermdp)
                        {
                            $i++;
                            $message .= '<span style="color:#ff5c5c;text-align:center;"><b>'.$i.'. Les mots de passe sont différents</b></span><br>';
                        }

                        if(empty($mdp) || !preg_match("#^[A-Z][a-z0-9]{4,20}$#",$mdp))
                        {
                            $i++;
                            $message .= '<span style="color:#ff5c5c;text-align:center;"><b>'.$i.'. Le mot de passe doit commencer par une majuscule et contenir au minimum 4 caractères</b></span><br>';
                        }

                        if(empty($email) || !preg_match("#^[a-z0-9._-]{2,20}@[a-z0-9._-]{2,20}\.[a-z]{2,6}$#",$email))
                        {
                            $i++;
                            $message .= '<span style="color:#ff5c5c;text-align:center;"><b>'.$i.'. L\'email n\'est pas valide</b></span><br>';
                        }
                        
                        if($testEmail['email'] == $email)
                        {
                            $i++;
                            $message .= '<span style="color:#ff5c5c;text-align:center;"><b>'.$i.'. L\'email est déjà utilisé</b></span><br>';
                        }
                        
                        if(empty($nom))
                        {
                            $i++;
                            $message .= '<span style="color:#ff5c5c;text-align:center;"><b>'.$i.'. Veuillez rentrer un nom valide</b></span><br>';
                        }  


                        if(empty($prenom))
                        {
                            $i++;
                            $message .= '<span style="color:#ff5c5c;text-align:center;"><b>'.$i.'. Veuillez rentrer un prenom valide</b></span><br>';
                        }

                        if(empty($date))
                        {
                            $i++;
                            $message .= '<span style="color:#ff5c5c;text-align:center;"><b>'.$i.'. Veuillez rentrer une date valide</b></span><br>';
                        }      

                        if($i>0)
                        {
                            $i= $i+$j;
                        ?>
                           
                            <div class="col-lg-offset-4 col-lg-4 col-lg-offset-4 col-md-offset-3 col-md-6 col-md-offset-3 col-sm-offset-2 col-sm-8 col-sm-offset-2 col-xs-offset-1 col-xs-10 col-xs-offset-1 erreurs-reg">
                        <?php
                            echo '<span style="color:#ff5c5c;"><b><u>Vous avez '.$i.' erreur(s)</u></b></span>';
                            echo '<br>'.$message;
                        ?>
                            </div>
                        <?php
                        
                        }

                        else
                        {
                            $requete = $bdd->prepare("INSERT INTO `user` (prenom, nom, email, mdp, date) VALUES(:prenom, :nom, :email, :mdp, :date)");
                            $requete->bindValue(":prenom",$prenom,PDO::PARAM_STR);
                            $requete->bindValue(":nom",$nom,PDO::PARAM_STR);    
                            $requete->bindValue(":email",$email,PDO::PARAM_STR);
                            $requete->bindValue(":date",$date,PDO::PARAM_STR);
                            $requete->bindValue(":mdp",sha1($mdp),PDO::PARAM_STR);
                            $requete->execute();
                                 
                        ?>
                            <div class="col-lg-offset-4 col-lg-4 col-lg-offset-4 col-md-offset-3 col-md-6 col-md-offset-3 col-sm-offset-2 col-sm-8 col-sm-offset-2 col-xs-offset-1 col-xs-10 col-xs-offset-1 erreurs-reg">
                        <?php                                    
                            echo '<span style="color:#AFA;"><b>Félicitation, votre compte est créé.</b></span><span style="color:#FFF;"></span>';
                                  
                        ?>
                            </div>
                        <?php 
                            
                        }
                    }
                    else
                    {
                    ?>
                    <div class="col-lg-offset-4 col-lg-4 col-lg-offset-4 col-md-offset-3 col-md-6 col-md-offset-3 col-sm-offset-2 col-sm-8 col-sm-offset-2 col-xs-offset-1 col-xs-10 col-xs-offset-1 erreurs-reg">
                    <?php                                    
                        echo '<span style="color:#ff5c5c;text-align:center;"><b>Inscription non conforme !</b></span>';
                    ?>
                    </div>
                    <?php
                    }
                }
// FIN INSCRIPTION EN BDD //

                              
                
/***** AVATAR *********************************************************************************************************************************************/  
                if (isset($_FILES['avatar']) AND $_FILES['avatar']['error'] == 0)
                {
                    $requete = $bdd->query("SELECT * FROM user WHERE'".$_POST['email']."'= email");
                    $donnee = $requete->fetch();
                    
                    // Testons si le fichier n'est pas trop gros
                    if ($_FILES['avatar']['size'] <= 1000000)
                    {
                        // Testons si l'extension est autorisée
                        $infosfichier = pathinfo($_FILES['avatar']['name']);
                        $extension_upload = $infosfichier['extension'];
                        $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');

                        if (in_array($extension_upload, $extensions_autorisees))
                        {
                            // On peut valider le fichier et le stocker définitivement
                            move_uploaded_file($_FILES['avatar']['tmp_name'], 'membres/avatars/' .$donnee['id_u']);//.'.'.$extension_upload);
                            $chemin = 'membres/avatars/' .$donnee['id_u'];//.'.'.$extension_upload;
                            $requete = $bdd->query("UPDATE user SET avatar = '".$chemin."' WHERE id_u='".$donnee['id_u']."'");
                        }
                        
                        else
                        {
                            $j++;
                        ?>
                            <div class="col-lg-offset-4 col-lg-4 col-lg-offset-4 col-md-offset-3 col-md-6 col-md-offset-3 col-sm-offset-2 col-sm-8 col-sm-offset-2 col-xs-offset-1 col-xs-10 col-xs-offset-1 erreurs-reg">
                        <?php                                    
                            echo '<span style="color:#ff5c5c;text-align:center;"><b><u>Vous avez '.$j.' erreur(s)</u><br>'.$j.'. Extensions d\'images autorisées: JPG,JPEG,GIF,PNG</b></span>';
                        ?>
                            </div>
                        <?php       
                        }

                    }
                    
                    else
                    {
                       $j++;
                    ?>
                        <div class="col-lg-offset-4 col-lg-4 col-lg-offset-4 col-md-offset-3 col-md-6 col-md-offset-3 col-sm-offset-2 col-sm-8 col-sm-offset-2 col-xs-offset-1 col-xs-10 col-xs-offset-1 erreurs-reg">
                    <?php                                    
                        echo '<span style="color:#ff5c5c;text-align:center;"><b><u>Vous avez '.$j.' erreur(s)</u><br>'.$j.'. Fichier trop volumineux</b></span>';
                    ?>
                        </div>
                    <?php 
                    }
                }
            }
// FIN AVATAR //          
            
            
 
            if(isset($_POST['sinscrire']))
            {          
                include 'pages/register.php';
            } 
// FIN FORMULAIRE D'INSCRIPTION //                 
        }         
// FIN SESSION 'OFF' //   

       
        
/***** CONNEXION *********************************************************************************************************************************************/
        if(isset($_POST['connexion']))
        {   
            extract($_POST);
            $requete = $bdd->prepare("SELECT * FROM user where email = :email AND mdp = :mdp");
            $requete->bindValue(":email", $email, PDO::PARAM_STR);
            $requete->bindValue(":mdp", sha1($mdp), PDO::PARAM_STR);
            $requete->execute();
            
            if($reponse = $requete->fetch())
            {
                $_SESSION['connecte'] = true;
                $_SESSION['id']  = $reponse['id_u'];
                $_SESSION['info'] = $reponse;
                $_SESSION['testAvatar']= $reponse['avatar'];

                if(isset($_POST['remember']))
                {
                    setcookie('auth', $reponse['id_u'].'-----'.sha1($reponse['email'].$reponse['mdp'].$_SERVER['REMOTE_ADDR']), time()+(3600*24*3));
                }
                else
                {
                    echo "<script type='text/javascript'>document.location.replace('espaceMembre');</script>";
                  //header("Location:accueil");
                }
            }
            
            if($reponse !=$requete)
            {
                
            ?> 
                <div class="col-lg-offset-4 col-lg-4 col-lg-offset-4 col-md-offset-3 col-md-6 col-md-offset-3 col-sm-offset-2 col-sm-8 col-sm-offset-2 col-xs-offset-1 col-xs-10 col-xs-offset-1 login">
                    <table>
                        <h3 class="text-center"><strong>Accès refusé</strong></h3><hr>
                        <h5 class="text-center"><strong>login/mot de passe<br>incorrecte(s)</strong></h5><hr>
                    </table>
               </div>
            <?php
            }
        }       
        
        
        
/***** DECONNEXION *********************************************************************************************************************************************/  
        if(isset($_POST['deconnexion']))
        { 
            session_destroy();
            setcookie('auth','', time()-3600);
            echo "<script type='text/javascript'>document.location.replace('espaceMembre');</script>";
        }
// FIN DECONNEXION //

        
        
/***** SESSION 'ON' ********************************************************************************************************************************************/
        if(isset($_SESSION['connecte']) && $_SESSION['connecte']==true)
        {
            if($_SESSION['info']['avatar']==true)
            {
              //  echo $_SESSION['testAvatar'];
            ?>
                <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12 avatar">   
                  <p class="text-center p-connexion">Connecté</p>
                   <h4 class="text-center"><?php echo $_SESSION['info']['prenom'] ?></h4>
                    <img class="img-circle avatar-border" src='<?php echo $_SESSION['testAvatar']; ?>?filemtime(<?php echo time(); ?>)'/>
                    <div class="space"></div>
                    <form action="" method="post">
                        <input class="btn btn-warning btninscription" type="submit" name="deconnexion" value="Déconnexion"/> 
                        <input id="editer" class="btn btn-link btninscription" type="submit" name="modifierprofil" value="Modifier profil"/>    
                    </form>
                </div>
            <?php
            }
            else
            {
            ?>   
                <div class="col-lg-2 col-md-2 col-sm-3 col-xs-5 avatar"> 
                 <p class="text-center text-muted">Connecté</p>
                 <h4 class="text-center"><?php echo $_SESSION['info']['prenom'] ?></h4>
                  <img class="img-circle avatar-border" src="membres/avatars/1.jpg"/>
                  <div class="space"></div>
                  <form action="" method="post">
                      <input class="btn btn-warning btninscription" type="submit" name="deconnexion" value="Déconnexion"/>
                      <input id="editer" class="btn btn-link btninscription" type="submit" name="modifierprofil" value="Modifier profil"/>   
                  </form>
               </div>   
            <?php    
            }
        }


      


// FIN SESSION ON //    
        
        

/***** EDITION PROFIL ***********************************************************************************************************************/
        if(isset($_POST["modifierprofil"]) && $_SESSION['connecte']==true)
        {
            include 'pages/edition.php';
        }
        
        if(isset($_POST['update']))
        {
            include 'pages/edition.php';
            $message="";
            $i=0;
       
            extract($_POST);
            
            if(isset($_FILES['avatar']) AND $_FILES['avatar']['error'] == 0)
            {
                $requete = $bdd->query("SELECT * FROM user WHERE id_u ='".$_SESSION['info']['id_u']."'");
                $donnee = $requete->fetch();
                // Testons si le fichier n'est pas trop gros

                if ($_FILES['avatar']['size'] <= 1000000)
                {
                    // Testons si l'extension est autorisée
                    $infosfichier = pathinfo($_FILES['avatar']['name']);
                    $extension_upload = $infosfichier['extension'];
                    $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');

                    if (in_array($extension_upload, $extensions_autorisees))
                    {
                        // On peut valider le fichier et le stocker définitivement
                        move_uploaded_file($_FILES['avatar']['tmp_name'], 'membres/avatars/' .$donnee['id_u']);//.'.'.$extension_upload);
                        $chemin = 'membres/avatars/' .$donnee['id_u'];//.'.'.$extension_upload;
                        $requete = $bdd->query("UPDATE user SET avatar = '".$chemin."' WHERE id_u='".$donnee['id_u']."'");

                    }
                    else
                    {
                        $i++;
                        $message.= '<span style="color:#ff5c5c;text-align:center;"><b>'.$i.'. Changer mon avatar =></b></span><span style="color:#fff;"><b><i> extensions d\'images autorisées: JPG,JPEG,GIF,PNG<br></i></b></span>';
                    }
                }
                else
                {
                    $i++;
                    $message.= '<span style="color:#ff5c5c;text-align:center;"><b>'.$i.'. Changer mon avatar =></b></span><span style="color:#fff;"><b><i> fichier trop volumineux<br></i></b></span>';
                }
            }

            if(isset($newmdp) && !empty($newmdp)) // si il y a quelque chose dans tapez votre mdp, on le cript !
            {
                $newmdp = sha1($_POST['newmdp']); 

                if($_SESSION['info']['mdp'] == $newmdp) // si le mdp qui vient d'être saisi par l'utilisateur est le meme que le mdp de son compte
                {
                    if(isset($newmdp1) && !empty($newmdp1) && isset($newmdp2) && !empty($newmdp2) && preg_match("#^[A-Z][a-z0-9]{4,20}$#",$newmdp1) && $newmdp1 == $newmdp2) // si tapez votre nouveau mdp1 est égal au mdp2 
                    {
                        $newmdp1 = sha1($_POST['newmdp1']);
                        $editerprof = $bdd->query("UPDATE `gestion-alume`.`user` SET `mdp` ='".$newmdp1."' WHERE `user`.`id_u` = '".$_SESSION['info']['id_u']."'");
                    }
                    else 
                    {
                        $i++;
                        $message.= '<span style="color:#ff5c5c;text-align:center;"><b>'.$i.'. Changer mon mot de passe =></b></span><span style="color:#fff;"><b><i> les mots de passe sont différents<br></i></b></span>';
                    }
                }
                else
                {
                    $i++;
                    $message.= '<span style="color:#ff5c5c;text-align:center;"><b>'.$i.'. Changer mon mot de passe =></b></span><span style="color:#fff;"><b><i> mot de passe actuel incorrecte<br></i></b></span>';
                }
            }

            if(isset($emailactuel) && !empty($emailactuel))
            {
                if($emailactuel == $_SESSION['info']['email'])
                {
                    if(isset($newemail) && !empty($newemail) && preg_match("#^[a-z0-9._-]{2,20}@[a-z0-9._-]{2,20}\.[a-z]{2,6}$#",$newemail))
                    {
                        if(isset($mdpemailactuel) && !empty($mdpemailactuel) && preg_match("#^[A-Z][a-z0-9]{4,20}$#",$mdpemailactuel))
                        {
                            $mdpemailactuel = sha1($_POST['mdpemailactuel']);

                            if($mdpemailactuel == $_SESSION['info']['mdp'])
                            {
                                $editerprof = $bdd->query("UPDATE `gestion-alume`.`user` SET `email` ='".$newemail."' WHERE `user`.`id_u` = '".$_SESSION['info']['id_u']."'");
                            }
                            else
                            {
                                $i++;
                                $message.= '<span style="color:#ff5c5c;text-align:center;"><b>'.$i.'. Changer mon adresse email =></b></span><span style="color:#fff;"><b><i> mot de passe incorrect<br></i></b></span>';
                            }
                        }
                        else
                        {
                            $i++;
                            $message.= '<span style="color:#ff5c5c;text-align:center;"><b>'.$i.'. Changer mon adresse email:</b></span><span style="color:#fff;"><b><i><br> le mot de passe doit:<br> -commencer par une majuscule<br> -5 caractères minimum <br> -21 caractères maximum <br></i></b></span>';
                        }
                    }
                    else
                    {
                        $i++;
                        $message.= '<span style="color:#ff5c5c;text-align:center;"><b>'.$i.'. Changer mon adresse email =></b></span><span style="color:#fff;"><b><i> nouvel email incorrecte<br></i></b></span>';
                    }
                }
                else
                {
                    $i++;
                    $message.= '<span style="color:#ff5c5c;text-align:center;"><b>'.$i.'. Changer mon adresse email =></b></span><span style="color:#fff;"><b><i> email actuel incorrecte<br></i></b></span>';
                }
            }
            
            if($i>0)
            {
            ?>
                 <div class="col-lg-offset-4 col-lg-4 col-lg-offset-4 col-md-offset-3 col-md-6 col-md-offset-3 col-sm-offset-3 col-sm-6 col-sm-offset-3 col-xs-12 erreurs-edit">
            <?php
                echo '<span style="color:#ff5c5c;text-align:center;"><b><ins>Vous avez '.$i.' erreur(s)</ins></b></span>';
                echo "<br>".$message;
            ?>
                </div>
            <?php
            }
        }
// FIN EDITION PROFIL //       
// FIN HEADER //        

/* UTILISATEUR TABLEAU COMMANDE */
    if(isset($_SESSION['connecte']) && $_SESSION['connecte']==true)
    {
    ?>
       <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <table cellspacing="0" cellpadding="0" border="1" bordercolor="white" width="100%" align="center" style="background-color: rgba(0,0,0,0.4);">
           
           <h3>Récapitulatif de vos commandes :</h3>
           
            <tr>
                <td><p class="text-center p-admin">Produit</p></td>
                <td><p class="text-center p-admin">Quantité</p></td>
                <td><p class="text-center p-admin">Prix unitaire</p></td>
                <td><p class="text-center p-admin">Prix total</p></td>
                <td><p class="text-center p-admin">Payée</p></td>
                <td><p class="text-center p-admin">Date</p></td>
            </tr>
        <?php
        
        $commandes = $bdd->query("SELECT * FROM commande WHERE Num_client ='".$_SESSION['info']['id_u']."'");
        foreach($commandes as $commande)
        {
            
        $requete = $bdd->query("SELECT * FROM Produit, Commande WHERE commande.Num_produit=produit.Num_produit AND '".$commande['Num_produit']."'= produit.Num_produit ");
        
        if($produit=$requete->fetch()) {
            
        ?> 
            <tr>
                <td><p class="text-center p-admin-db"><?php echo $produit['Ref_produit']?></p></td>
                <td><p class="text-center p-admin-db"><?php echo $commande['Quantite']?></p></td>
                <td><p class="text-center p-admin-db"><?php echo $produit['Prix_produit']?></p></td>
                <td><p class="text-center p-admin-db"><?php echo $commande['Quantite']*$produit['Prix_produit']?></p></td> 
                <td><p class="text-center p-admin-db"><?php if ($produit['Payee']=="0") {echo "Non";} else {echo "Oui";}?></p></td>
                <td><p class="text-center p-admin-db"><?php echo $commande['Date_commande']?></p></td>
            </tr> 
    <?php
        }
        }
        ?>
            </table>
            </div>
        <?php
    }
    
    if(!isset($_SESSION['connecte']))
    {

?>










        <div class="col-lg-offset-4 col-lg-4 col-lg-offset-4 col-md-offset-4 col-md-4 col-md-offset-4 col-sm-offset-3 col-sm-6 col-sm-offset-3 col-xs-offset-2 col-xs-8 col-xs-offset-2 login">
            <table>
                <h3 class="text-center"><strong>Connexion</strong></h3><hr>         
                    <article class="templatemo-item">
                        <form class="form-horizontal" action="" method="post">
                            <div class="form-group">
                                <input class="form-control" type="email" name="email" placeholder="Email"  />
                            </div>
                            <div class="for[m-group">
                                <input class="form-control" type="password" name="mdp" placeholder="Mot de passe" pattern="[A-Za-z0-9]{4,20}"  />
                            </div>
                            <div class="checkbox">
                                <label for="contact_remember"><input type="checkbox" name="remember" id="contact_remember" value="remember" />se souvenir de moi</label>
                            </div>
                                <input class="btn btn-warning" type="submit" name="connexion" value="Connexion" />
                                <input class="btn btn-secondary" type="submit" name="sinscrire" value="S'inscrire" />
                              <!--  <a href="pages/register.php">s'inscrire</a> -->
                        </form>         
                    </article>
            </table><hr>
        </div>
<?php
    }
    if(empty($_SESSION) && isset($_POST['sinscrire'])){}

?>







<?php
    if(isset($_SESSION['connecte']) && $_SESSION['connecte']==true)
    {

    ?>
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
         <table cellspacing="0" cellpadding="0" border="1" bordercolor="white" width="100%" align="center" style="background-color: rgba(0,0,0,0.4);">
           
           <h3>Votre panier :</h3>
           
            <tr>
                <td><p class="text-center p-admin">Produit</p></td>
                <td><p class="text-center p-admin">Quantité</p></td>
                <td><p class="text-center p-admin">Prix</p></td>
                <td><p class="text-center p-admin">Delete</p></td>
            </tr>
    <?php

            
        $requete = $bdd->query("SELECT distinct produit.Ref_produit FROM produit, panier WHERE  produit.Num_produit = panier.Num_produit AND panier.Num_client = '".$_SESSION['info']['id_u']."'");
        $nb = $bdd->query("SELECT count(Num_produit) from panier group by Num_produit");
        $prix = $bdd->query("SELECT distinct Prix_produit from produit, panier where produit.Num_produit = panier.num_produit");
        $getId = $bdd->query("SELECT distinct Num_produit from panier");
        $total = 0;

        
        while($produit=$requete->fetch() AND $nbs=$nb->fetch() AND $ReelPrix=$prix->fetch() AND $getIdArticle = $getId->fetch()) {          
    ?> 
        <tr>
            <td><p class="text-center p-admin-db"><?php echo $produit['Ref_produit']?></p></td>
            <td><p class="text-center p-admin-db"><?php echo $nbs[0]?></p></td>
            <td><p class="text-center p-admin-db"><?php echo  $ReelPrix[0]*$nbs[0]; $total = $total + ($ReelPrix[0]*$nbs[0]);?></p></td>
            <td><a href="espaceMembre&<?php echo $getIdArticle[0];?>"><p class="text-center p-admin-db" style="font-weight:bold; color: red;">X</p></a></td>
        </tr>
   
    <?php
        }

        ?>
                <tr>
                    <td><p class="text-center p-admin-db">Total : <?php  echo $total; ?> €</p></td>
                    <?php if($total > 0){?><td><a href="espaceMembre&valAchat"><p class="text-center p-admin-db" style="font-weight:bold; color: green;">Acheter</p></a></td><?php }?>
                </tr>
            </table>
            </div>
        <?php
    }
?>

<?php
    if(isset($_GET['v']) &&  $_GET['v'] == "valAchat")
    { 
      $Achat = $bdd->query("DELETE from panier where Num_Client = '".$_SESSION['info']['id_u']."'");
      Header("Location:espaceMembre");
    }

    if(isset($_GET['v']))
    {
        $supprArticle = $bdd->query("DELETE from panier where Num_Produit = '".$_GET['v']."' ");
        Header("Location:espaceMembre");
    }
?>



<style>
.page {
    background-color: rgba(0, 0, 0, 0);
}

</style>