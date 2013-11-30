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

$_SESSION['frosting'] = $_POST['frosting'];
 
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
<form action="editorOverview.php" method="post">
<p> Bitte w&auml;hle die Deko:</p><br>
     <input type="checkbox" name="deco" value="stars" />
      Sterne</br>
     <input type="checkbox" name="deco" 
     value="hearts"/> Herzen</br>
 <input type="checkbox" name="deco" 
     value="choco"/> Schokostreusel
<br><br>
<input type="submit" value="Submit" class="button" />

</form>

        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
