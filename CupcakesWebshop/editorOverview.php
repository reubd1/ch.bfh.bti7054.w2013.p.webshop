<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
       "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<style type="text/css">
@import "navi.css";
.button {
    border: 1px solid #006;
    background: #9cf;
}
</style>
</head>
<body>
<?php
  
session_start();
 
$_SESSION['deco'] = $_POST['deco'];

$size = $_SESSION['size'];
$flavor = $_SESSION['flavor']; 
$frosting = $_SESSION['frosting']; 
$deco = $_SESSION['deco'];

?>

<?php include 'functions.php'; ?>
<div id="tabwrapper">
<div id='tabmenu'>
<ul>
<?php tabmenu(); ?>
</ul>
</div>
</div>
<div id="wrapper">
  <hr class="noscreen" />
  <div class="content">
    <div class="column-left">
      <h3>MENU</h3>
      <a href="#skip-menu" class="hidden">Skip menu</a>
      <ul class="menu">
<?php menu(); ?>
      </ul>
    </div>
    <div id="skip-menu"></div>
    <div class="column-right">
      <div class="box">
        <div class="box-top"></div>
        <div class="box-in">
<form action="purchase.php" method="post">
<p> Sie haben sich folgendes Cupcake zusammengestellt:</p><br>

<p>Gr&ouml;sse: <?php  echo $size;  ?></p><br>
<p>Geschmack: <?php  echo $flavor ?></p><br>
<p>Frosting: <?php  echo $frosting  ?></p><br>
<p>Deko: <?php echo $deco ?></p><br>
<br><br>
<input type="submit" value="Jetzt kaufen" class="button" />

</form>

        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
