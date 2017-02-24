<div class="vitrine col-md-12">

<?php 

$produits = $bdd->query("SELECT * FROM produit");
$folder = "espaceAdmin/";
foreach($produits as $produit)
{ 
?>
    <div class="col-md-4">
        <div class="case col-md-12">
            <div class="col-md-7 vitrine_photo">
                <img src="<?php echo $folder.$produit['Image_produit']?>" height="150px"/>
            </div>
            <div class="col-md-5 vitrine_texte">
                <div class="col-md-12 vitrine_ref">
                    <p> Référence :</p>
                    <?php echo $produit['Ref_produit']?>
                </div>
                <div class="col-md-12 vitrine_prix">
                    <?php echo $produit['Prix_produit']?>
                </div>
                <div class="col-md-12 vitrine-redirection">
                    <a href="produit&<?php echo $produit['Num_produit']?>"><p class="texte-redirection">Plus de détails</p></a>
                </div>
            </div>
        </div>
    </div>

<?php 
}
?>

</div>



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
    height: 220px;
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