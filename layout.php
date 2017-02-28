<!DOCTYPE html>
<!-- 
Conquer Template
http://www.templatemo.com/preview/templatemo_426_conquer
-->
<head>
<title>Conquer HTML5 Template</title>
<meta name="keywords" content="">
<meta name="description" content="">
<meta charset="utf-8">
<meta name="viewport" content="initial-scale=1">
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,700italic,400,600,700,800' rel='stylesheet' type='text/css'>
<!-- Style Sheets --> 
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/templatemo_misc.css"> 
    <link rel="stylesheet" href="css/templatemo_style.css"> 
    <link rel="stylesheet" href="css/styles.css"> 
<!-- JavaScripts -->
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/bootstrap-dropdown.js"></script>
<script src="js/bootstrap-collapse.js"></script>
<script src="js/bootstrap-tab.js"></script>
<script src="js/jquery.singlePageNav.js"></script>
<script src="js/jquery.flexslider.js"></script>
<script src="js/custom.js"></script>
<script src="js/jquery.lightbox.js"></script>
<script src="js/templatemo_custom.js"></script>
<script src="js/responsiveCarousel.min.js"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>
<script src="https://use.fontawesome.com/df110f86e6.js"></script>

</head>
<body>

<!--** HEADER *************************************************************************************************************************************************-->
   <section class="fullsize-video-bg">
        <div id="video-viewport">
            <video autoplay muted loop>
                <source src="video/motion.mov" type="video/mp4" />
                <source src="video/motion.mov" type="video/webm" />
            </video>
        </div>
    </section> 
    <div class="templatemo_topbar">
    <div class="container"> 
      <div class="row rowOne">
        <div class="templatemo_titlewrapper"><img src="images/templatemo_logobg.png" alt="logo background">
            <div class="templatemo_title"><span class="text-center">ALU-ME Corporation</span></div>
        </div>
        <div class="clear"></div>
        <div class="templatemo_titlewrappersmall">ALU-ME Corp</div>
        <nav class="navbar navbar-default templatemo_menu" role="navigation">
          <div class="container-fluid"> 
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"><span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span></button>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div id="top-menu">
              <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                  <li><a class="menu" href="accueil">Accueil</a></li>
                  <li><a class="menu" href="entreprise">L'entreprise</a></li>
                  <li><a class="menu" href="realisation">Réalisations</a></li>
                  <li><a class="menu" href="produits">Produits</a></li>
                  <li><a class="menu" href="espaceMembre">Membres</a></li>
                  <li><a class="menu" href="contact">Contact&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></li>
                  <?php
                
                     if(isset($_SESSION['connecte']) && $_SESSION['connecte']==true)
                     {
                       $nombre = $bdd->query("SELECT count(id_panier) FROM panier where Num_client = '".$_SESSION['info']['id_u']."'");
                       while($nombres = $nombre->fetch()){

                        ?>
                        <a href="espaceMembre"><li class="fa fa-shopping-basket" style="font-size:150%; color: white; font-weight:bold;" aria-hidden="true">&nbsp;&nbsp;<?php if($nombres[0] == 0){echo " vide";}else echo $nombres[0]." Art.";?></li></a>
                       <?php
                       }
                     }
                  ?>
                  
                </ul>
              </div>
            </div>
            <!-- /.navbar-collapse -->
          </div>
          <!-- /.container-fluid --> 
        </nav>
        <div class="clear"></div> 
      </div>


    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 page">
        <?php echo $content;?>
    </div>
    </div>
                     
        
<!--** FOOTER ********************************************************************************************************************************************-->
    </div>
<div class="footeratbottom">
  <div class="container">
    <div class="row">
      <div class="col-md-12 copyright">Copyright &copy; 2017 <a href="">ALU-ME Corporation</a>
      </div>
    </div>
  </div>
</div>
<!-- FIN FOOTER --> 



<!--** JAVASCRIPT *****************************************************************************************************************************************-->
<script src="js/index.js"></script>
<script>
<!-- scroll to specific id when click on menu -->
// Cache selectors
var lastId,
    topMenu = $("#top-menu"),
    topMenuHeight = topMenu.outerHeight() + 15,
    // All list items
    menuItems = topMenu.find("a"),
    // Anchors corresponding to menu items
    scrollItems = menuItems.map(function() {
        var item = $($(this).attr("href"));
        if (item.length) {
            return item;
        }
    });
// Bind click handler to menu items
// so we can get a fancy scroll animation
menuItems.click(function(e) {
    var href = $(this).attr("href"),
        offsetTop = href === "#" ? 0 : $(href).offset().top - topMenuHeight + 1;
    $('html, body').stop().animate({
        scrollTop: offsetTop
    }, 300);
    e.preventDefault();
});
// Bind to scroll
$(window).scroll(function() {
    // Get container scroll position
    var fromTop = $(this).scrollTop() + topMenuHeight;
    // Get id of current scroll item
    var cur = scrollItems.map(function() {
        if ($(this).offset().top < fromTop)
            return this;
    });
    // Get the id of the current element
    cur = cur[cur.length - 1];
    var id = cur && cur.length ? cur[0].id : "";
    if (lastId !== id) {
        lastId = id;
        // Set/remove active class
        menuItems
            .parent().removeClass("active")
            .end().filter("[href=#" + id + "]").parent().addClass("active");
    }
});
</script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

        <script>
            $(document).ready(function(){
            var date_input=$('input[name="date"]');
            var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
            date_input.datepicker({
            format: 'yyyy/mm/dd',
            container: container,
            todayHighlight: true,
            autoclose: true,})
            })
        </script>
<!-- FIN JAVASCRIPT -->
</body>
