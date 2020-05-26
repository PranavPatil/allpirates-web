<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html;charset=iso-8859-1" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<?php
$type = isset($_GET['type']) ? $_GET['type']: 'login';
?>
<title><?php if ($type=="account") echo "Account"; else if ($type=="login") echo "Login"; ?></title>

<link rel="icon" type="image/vnd.microsoft.icon" href="/images/allpirates.ico">
<link rel="stylesheet" href="/style.css" type="text/css" media="screen" />
<script src="/javascript/ddmenu.js" type="text/javascript"></script>
<script type="text/javascript" src="/javascript/fadw.js"></script>
<script type="text/javascript" src="/javascript/shadedborder.js"></script>
<script language="javascript" type="text/javascript">
  var holderBorder = RUZEE.ShadedBorder.create({ corner:20, border:2 });
  
  function sFanew() {
    sFa();
    holderBorder.render('content');
  }
  
</script>

</head>

<body onload="setTimeout('sFanew()',1000)">

<div id="container">

    <?php include("$DOCUMENT_ROOT/header.html"); ?>

    <?php include("$DOCUMENT_ROOT/menu.html"); ?>

	<div id="main_content">

      <p>
	  <div class="clearthis">&nbsp;</div>
	  <div class="clearthis">&nbsp;</div>
	  <div class="clearthis">&nbsp;</div>
	  <div class="clearthis">&nbsp;</div>
	  <div class="clearthis">&nbsp;</div>
	  <div class="clearthis">&nbsp;</div>
	  <div class="clearthis">&nbsp;</div>
	  <div class="clearthis">&nbsp;</div>
	  <div class="clearthis">&nbsp;</div>
      <a href="#" onClick="sFanew()">Click here to open <?php if ($type=="account") echo "new account"; else if ($type=="login") echo "login"; ?></a>
	  <div id="faw">
      <div id="content">
        <div id="innerholder">
         <h3><br /><h1><?php if ($type=="account") echo "New Account"; else if ($type=="login") echo "Login"; ?></h1><br /><br /><hr></h3>
         <applet
         <?php if ($type=="account") echo "code=\"Account.class\" width=310 height=250"; else if ($type=="login") echo "code=\"Login.class\" width=300 height=120"; ?>
          ></applet>
        </div>
      </div>
	  </div>
    </div>
	<div class="clearthis">&nbsp;</div>

    <?php include("$DOCUMENT_ROOT/footer.html"); ?>
</div>

</body>
</html>