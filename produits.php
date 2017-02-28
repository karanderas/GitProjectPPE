<div class="vitrine col-md-12">

    <?php 

    $produits = $bdd->query("SELECT * FROM Produit");
    foreach($produits as $produit)
    { 
        ?>
            <div class="col-md-4">
                <div class="case col-md-12">
                    <div class="col-md-7 vitrine_photo">
                        <img src="<?php echo $produit['Image_produit']?>" height="150px"/>
                    </div>
                    <div class="col-md-5 vitrine_texte">
                        <div class="col-md-12 vitrine_ref">
                            <p> Référence :</p>
                            <?php echo $produit['Ref_produit']?>
                        </div>
                        <div class="col-md-12 vitrine_prix">
                            <?php echo $produit['Prix_produit']." €"?>
                        </div>
                        
                        <div class="col-md-12 vitrine-redirection">
                            <a href="produit&<?php echo $produit['Num_produit']?>"><p class="texte-redirection">Plus de détails</p></a><br>
                            <div class="space"></div>
        
                        </div>
        

                    </div>
                        <?php
                            if(isset($_SESSION['connecte']) && $_SESSION['connecte']==true)
                            {
                        ?>
                        <form method="post">
                             <div class="col-md-12">
                                <a href="produits&<?php echo $produit['Num_produit']?>"><p class="addPanier" style="text-decoration:none;">Ajouter au panier</p></a>
                            </div>
                        <form>
                        <?php
                            }
                        ?>
                </div>
            </div>

        <?php 
    }
    ?>

</div>

<?php
    
    if(isset($_GET['v']))
    {
        $requete = $bdd->query("INSERT INTO panier (Num_produit, Num_client) values ('".$_GET['v']."', '".$_SESSION['info']['id_u']."')");
        Header("Location:produits");
    }
?>


<style>

.addPanier
{
    text-align:  center;
    border-style: solid;
    border-width: 1px;
    padding-top: 15px;
    padding-bottom: 15px;
    width: 100%;
    border-radius: 6px 6px 6px 6px;
    background-color: #c9302c;
    color: #fff;
    font-weight: bold;
    font-size: 11px;
}

.addPanier:hover
{
    border-color: #c9302c;
    color: #c9302c;
    font-weight: bold;
    background-color: #fff;
    text-decoration: none;
}
    
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
    height: 310px;
    width: 320px;
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