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

<p> Bitte w&auml;hle die Gr&ouml;sse:</p><br>
<form action="editorFrosting.php" method="post">
     <ul>
    <li  style="list-style:none;">
     <input type="radio" name="size" value="small" />
      klein
     <input type="radio" name="size" 
     value="medium"/>mittel
 <input type="radio" name="size" 
     value="large"/>gross
     </li>
 </ul>
<br>
Bitte w&auml;hle hier ein Aroma:<br><br>
     <input type="radio" name="flavor" value="vanilla" />
      Vanille</br>
     <input type="radio" name="flavor" 
     value="choco"/> Schokolade</br>
 <input type="radio" name="flavor" 
     value="citro"/> Zitrone
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
