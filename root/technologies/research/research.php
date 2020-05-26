<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html;charset=iso-8859-1" />
<meta http-equiv="Content-Style-Type" content="text/css" />

<title>
Research
</title>

<link rel="icon" type="image/vnd.microsoft.icon" href="/images/allpirates.ico">
<link rel="stylesheet" href="/style.css" type="text/css" media="screen" />
<script src="/javascript/ddmenu.js" type="text/javascript"></script>
<script src="/javascript/tabbox.js" type="text/javascript"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $(".tabLink").each(function(){
      $(this).click(function(){
        tabeId = $(this).attr('id');
        $(".tabLink").removeClass("activeLink");
        $(this).addClass("activeLink");
        $(".tabboxcontent").addClass("tabboxhide");
        $("#"+tabeId+"-1").removeClass("tabboxhide")   
        return false;	  
      });
    });  
  });
  
function SubmitForm(add)
{
   document.researchfrm.address.value = add;
   document.researchfrm.submit();
}	
  
</script>

</head>

<body>

<div id="container">

    <?php include("$DOCUMENT_ROOT/header.html"); ?>

    <?php include("$DOCUMENT_ROOT/menu.html"); ?>

	<div id="main_content">
	  <img src="/technologies/research/images/research.png"></img></p>

     <div class="tabbox"> 
       <a href="javascript:;" class="tabLink " id="cont-1">Comp Arch</a> 
       <a href="javascript:;" class="tabLink " id="cont-2">Prog</a> 
       <a href="javascript:;" class="tabLink " id="cont-3">Networks</a> 
       <a href="javascript:;" class="tabLink " id="cont-4">O.S</a> 
       <a href="javascript:;" class="tabLink " id="cont-5">Databases</a> 
       <a href="javascript:;" class="tabLink " id="cont-6">Algorithms</a> 
       <a href="javascript:;" class="tabLink " id="cont-7">Soft Engg</a> 
       <a href="javascript:;" class="tabLink " id="cont-8">Security</a> 
       <a href="javascript:;" class="tabLink " id="cont-9">A.I</a> 
       <a href="javascript:;" class="tabLink " id="cont-10">Dist Comp</a> 
       <a href="javascript:;" class="tabLink " id="cont-11">Multimedia</a> 
     </div>
  
     <form name="researchfrm" action="researchtm.php" method="post">
      <input name="address" type="hidden" value="" />

     <div class="tabboxcontent tabboxhide" id="cont-1-1"> 
      <h3 align="left" style="background-color:#8383E7; padding: 3px 15px 3px; color:#FFF; font-size:15px;">Computer Architecture</h3>
      <p></p>
      <?php include("$DOCUMENT_ROOT/categories/comparch/research/index.php"); ?>
     </div>

     <div class="tabboxcontent tabboxhide" id="cont-2-1"> 
      <h3 align="left" style="background-color:#8383E7; padding: 3px 15px 3px; color:#FFF; font-size:15px;">Programming</h3>
      <p></p>
	  <?php include("$DOCUMENT_ROOT/categories/programming/research/index.php"); ?>
     </div>

     <div class="tabboxcontent tabboxhide" id="cont-3-1"> 
      <h3 align="left" style="background-color:#8383E7; padding: 3px 15px 3px; color:#FFF; font-size:15px;">Networking</h3>
      <p></p>
	  <?php include("$DOCUMENT_ROOT/categories/networking/research/index.php"); ?>
     </div>

     <div class="tabboxcontent tabboxhide" id="cont-4-1"> 
      <h3 align="left" style="background-color:#8383E7; padding: 3px 15px 3px; color:#FFF; font-size:15px;">Operating Systems</h3>
      <p></p>
	  <?php include("$DOCUMENT_ROOT/categories/os/research/index.php"); ?>
     </div>

     <div class="tabboxcontent tabboxhide" id="cont-5-1"> 
      <h3 align="left" style="background-color:#8383E7; padding: 3px 15px 3px; color:#FFF; font-size:15px;">Databases</h3>
      <p></p>
	  <?php include("$DOCUMENT_ROOT/categories/databases/research/index.php"); ?>
     </div>

     <div class="tabboxcontent tabboxhide" id="cont-6-1"> 
      <h3 align="left" style="background-color:#8383E7; padding: 3px 15px 3px; color:#FFF; font-size:15px;">Algorithms</h3>
      <p></p>
	  <?php include("$DOCUMENT_ROOT/categories/algorithms/research/index.php"); ?>
     </div>

     <div class="tabboxcontent tabboxhide" id="cont-7-1"> 
      <h3 align="left" style="background-color:#8383E7; padding: 3px 15px 3px; color:#FFF; font-size:15px;">Software Engineering</h3>
      <p></p>
	  <?php include("$DOCUMENT_ROOT/categories/softengg/research/index.php"); ?>
     </div>

     <div class="tabboxcontent tabboxhide" id="cont-8-1"> 
      <h3 align="left" style="background-color:#8383E7; padding: 3px 15px 3px; color:#FFF; font-size:15px;">Security</h3>
      <p></p>
	  <?php include("$DOCUMENT_ROOT/categories/security/research/index.php"); ?>
     </div>

     <div class="tabboxcontent tabboxhide" id="cont-9-1"> 
      <h3 align="left" style="background-color:#8383E7; padding: 3px 15px 3px; color:#FFF; font-size:15px;">Artificial Intelligence</h3>
      <p></p>
	  <?php include("$DOCUMENT_ROOT/categories/ai/research/index.php"); ?>
     </div>

     <div class="tabboxcontent tabboxhide" id="cont-10-1"> 
      <h3 align="left" style="background-color:#8383E7; padding: 3px 15px 3px; color:#FFF; font-size:15px;">Distributed Computing</h3>
      <p></p>
	  <?php include("$DOCUMENT_ROOT/categories/distcomputing/research/index.php"); ?>
     </div>

     <div class="tabboxcontent tabboxhide" id="cont-11-1"> 
      <h3 align="left" style="background-color:#8383E7; padding: 3px 15px 3px; color:#FFF; font-size:15px;">Multimedia</h3>
      <p></p>
	  <?php include("$DOCUMENT_ROOT/categories/multimedia/research/index.php"); ?>
     </div>

     </form>

    <P></P> 	  
   	</div>
	<div class="clearthis">&nbsp;</div>


    <?php include("$DOCUMENT_ROOT/footer.html"); ?>
</div>

</body>
</html>