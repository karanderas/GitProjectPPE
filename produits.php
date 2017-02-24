<div class="vitrine col-md-12">

<?php 
    if(isset($_SESSION['connecte']) && $_SESSION['connecte']==true)
{ 
?>
    <div class="row">
        <div class="col-md-2">
            <form method="post">
                <input type="submit" name="panier" value="Panier"/> 
            </form>
        </div>
    </div>
<?php 
}

       
// Confirmation de la mise au panier :
if(isset($_POST['ajouterProduitAuPanier'])) 
{    
    extract($_POST);
    $requete=$bdd->query("SELECT * FROM Produit WHERE Num_produit ='".$numProduit."'");
    $produit=$requete->fetch();
    
    // On vérifie s'il n'y a pas déjà une commande de ce produit :
    $requete=$bdd->query("SELECT Quantite FROM Commande WHERE Num_client='".$_SESSION['info']['id_u']."' AND Id_facture='1' AND Num_produit='".$numProduit."'");
    $commandeExistante=$requete->fetch();
    
    ?>
    
    <div class="row">
        <div class="col-md-12">
            <?php
                if(!empty($commandeExistante['0'])) {
                    echo "Vous avez déjà ".$commandeExistante['0']." ".$produit['Ref_produit']." dans votre panier. \n Voulez vous en rajouter ".$_POST['quantiteProduit']." pour un total de ".($commandeExistante['0'] + $_POST['quantiteProduit'])." ".$produit['Ref_produit']." ?";
                } else {
                    echo "Voulez-vous vraiment acheter ".$_POST['quantiteProduit']." ".$produit['Ref_produit']." ?";
                }
            ?>
            
            <form method="post">
                    <div class="col-md-2">
                       <!-- input caché pour envoyé l'ID du produit et la quantité dans le formulaire -->
                        <input type="hidden" name="idProduit" value="<?php echo $produit['Num_produit']; ?>"/>
                        <input type="hidden" name="quantitéProduit" value="<?php echo $_POST['quantiteProduit']; ?>"/>
                        
                        <input class="form-control" type="submit" name="confirmerMiseAuPanier" value="Confirmer" required/>
                    </div>
            </form>
        </div>
    </div>

<?php     
}    
    
        
    
// Afficher le catalogue des produits :    
$produits = $bdd->query("SELECT * FROM Produit");
foreach($produits as $produit)
{ 
?>
    <div class="col-md-6">
        <div class="case col-md-12">
            <div class="col-md-7 vitrine_photo">
                <img src="<?php echo "images/".$produit['Image_produit']?>" width="250px" height="250px"/>
            </div>
            <div class="col-md-5 vitrine_texte">
                <div class="col-md-12 vitrine_ref">
                    <p> Référence :</p>
                    <?php echo $produit['Ref_produit']?>
                </div>
                <div class="col-md-12 vitrine_prix">
                   <p> Prix :</p>
                    <?php echo $produit['Prix_produit']. " €"?>
                </div>
                <div class="col-md-12 vitrine-redirection">
                    <a href="produit&<?php echo $produit['Num_produit']?>"><p class="texte-redirection">Plus de détails</p></a>
                </div>
                
                <?php
                if(isset($_SESSION['connecte']) && $_SESSION['connecte']==true) { 
                ?>
                <form method="post">
                    <div class="col-md-12">
                        <input style="width: 100px;" class="form-control" type="text" name="quantiteProduit" placeholder="Quantité" required/>
                        
                        <!-- input caché pour envoyé l'ID du produit dans le formulaire -->
                        <input type="hidden" name="numProduit" value="<?php echo $produit['Num_produit']; ?>"/>
                        
                        <input style="width: 130px;" id="bouton-admin" type="submit" name="ajouterProduitAuPanier" value="Ajouter au panier"/> 
                        
                    </div>
                </form>
                <?php
                }
                ?>
            </div>
        </div>
    </div>

<?php 
}
?>
</div>


<?php
// Ajouter un produit au panier :
if(isset($_POST['confirmerMiseAuPanier'])) 
{
    ajouterProduitAuPanier($_SESSION['info']['id_u'] ,$_POST['idProduit'], $_POST['quantitéProduit']);
}

if(isset($_POST['panier'])) {
    
    header("Location:panier");
}


// Fonctions pour gérer le panier
function ajouterProduitAuPanier ($numClient, $numProduit, $quantiteProduit) {
    
    global $bdd;
    
    // On vérifie s'il n'y a pas déjà une commande de ce produit :
    $requete=$bdd->query("SELECT Quantite FROM Commande WHERE Num_client='".$numClient."' AND Id_facture='1' AND Num_produit='".$numProduit."'");
    $commandeExistante=$requete->fetch();    
    
    // Si c'est le cas, on ajoute la quantité demandée à la quantité actuelle :
    if(!empty($commandeExistante['0'])) {
        $nouvelleQuantite = $commandeExistante['0'] + $quantiteProduit;
        
        $requete=$bdd->query("UPDATE Commande SET Quantite='".$nouvelleQuantite."' WHERE Num_client='".$numClient."' AND Num_produit='".$numProduit."' AND Id_facture='1'");
    }
    
    // Sinon, on ajoute la commande :
    else {
        $requete=$bdd->prepare("INSERT INTO Commande VALUES (:num_client, 1, :num_produit, :quantite)");
        $requete->bindValue(":num_client",$numClient, PDO::PARAM_INT);
        $requete->bindValue(":num_produit", $numProduit, PDO::PARAM_INT);    
        $requete->bindValue(":quantite", $quantiteProduit, PDO::PARAM_INT);
        $requete->execute();
    }
}

?>
<!-- -------------------------------------------------------------------- -->

<style>
    
.vitrine_photo {
    margin-left: -15px;
    /*background-color: blueviolet;*/
}
    
.vitrine_texte {
    text-align: left;
    /*background-color:aliceblue;*/
}
    
.vitrine_prix {
    padding-top: 25px;
}
    
.texte-redirection {
    font-size: 100%;
    min-width: 130px;
    font-weight: bold;
    color:coral ;
}

.case {
    background-color: rgba(0,0,0,0.4); 
    height: 300px;
    width: 500px;
    margin-top: 20px;
    padding-top: 7px;
    padding-left: 7px;
    padding-right: 10px;
}

.vitrine {
    margin-bottom: 50px;
}
    
.page {
    background-color: rgba(0, 0, 0, 0);
}

</style>