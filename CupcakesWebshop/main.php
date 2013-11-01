<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Simple Personal</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="navi.css" type="text/css" media="screen, projection, tv" />
</head>
<body>
<?php include 'functions.php'; ?>
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
<!--?php content(); ?-->
<?php
include 'productlist.php';
?>
          <h2>Welcome to my website</h2>

<?php language(); ?>
          <p>Integer metus enim, laoreet vitae, blandit sit amet, gravida eu, eros. Morbi quis enim. Sed velit. Proin a sapien a lacus semper auctor. Maecenas faucibus aliquam diam. Duis aliquet. Donec feugiat tincidunt orci. Aliquam suscipit. Cras vehicula sodales erat. Duis non felis.</p>
          <p>Sed pharetra felis quis quam. Morbi aliquet consectetuer ligula. Curabitur velit elit, pellentesque tincidunt, ultrices ut, ullamcorper eget, ante. Curabitur ipsum orci, cursus eget, ultricies et, fringilla in, felis. Aliquam porta augue ac arcu. Aliquam mi. Fusce cursus lorem sed mi.</p>
          <br />
          <h2>Lorem ipsum dolor</h2>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
