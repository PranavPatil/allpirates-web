<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html;charset=iso-8859-1" />
<meta http-equiv="Content-Style-Type" content="text/css" />

<title>
Computer Architecture
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
   document.aifrm.address.value = add;
   
   if(document.comparchfrm.type.value == 'article') 
     document.comparchfrm.action = "/technologies/articles/articletm.php";
   else if(document.comparchfrm.type.value == 'tutorial')
     document.comparchfrm.action = "/technologies/tutorials/tutorialtm.php";
   else if(document.comparchfrm.type.value == 'presentation')
     document.comparchfrm.action = "/technologies/ppts/ppttm.php";
   else if(document.comparchfrm.type.value == 'research')
     document.comparchfrm.action = "/technologies/research/researchtm.php";
   else
     document.comparchfrm.action = "#";
   
   document.comparchfrm.submit();
}

function switchadd(addss)
{
   document.comparchfrm.type.value = addss;
}

</script>

</head>

<body>

<div id="container">

    <?php include("$DOCUMENT_ROOT/header.html"); ?>

    <?php include("$DOCUMENT_ROOT/menu.html"); ?>

	<div id="main_content">
	  <img src="/categories/comparch/images/comparch.png"></img></p>

     <div class="tabbox"> 
       <a href="javascript:;" class="tabLink " id="cont-1" onclick="switchadd('article')">Articles</a> 
       <a href="javascript:;" class="tabLink " id="cont-2" onclick="switchadd('tutorial')">Tutorials</a> 
       <a href="javascript:;" class="tabLink " id="cont-3" onclick="switchadd('presentation')">Presentations</a> 
       <a href="javascript:;" class="tabLink " id="cont-4" onclick="switchadd('research')">Research</a> 
     </div>

     <form name="comparchfrm" method="post">
      <input name="address" type="hidden" value="" />
      <input name="type" type="hidden" value="#" />

     <div class="tabboxcontent tabboxhide" id="cont-1-1"> 
       <h3 align="left" style="background-color:#8383E7; padding: 3px 15px 3px; color:#FFF; font-size:15px;">Articles</h3>
       <p></p>
       <?php include("$DOCUMENT_ROOT/categories/comparch/articles/index.php"); ?>
     </div>

     <div class="tabboxcontent tabboxhide" id="cont-2-1"> 
       <h3 align="left" style="background-color:#8383E7; padding: 3px 15px 3px; color:#FFF; font-size:15px;">Tutorials</h3>
       <p></p>
	   <?php include("$DOCUMENT_ROOT/categories/comparch/tutorials/index.php"); ?>
     </div>

     <div class="tabboxcontent tabboxhide" id="cont-3-1"> 
       <h3 align="left" style="background-color:#8383E7; padding: 3px 15px 3px; color:#FFF; font-size:15px;">Presentations</h3>
       <p></p>
	   <?php include("$DOCUMENT_ROOT/categories/comparch/ppts/index.php"); ?>
     </div>

     <div class="tabboxcontent tabboxhide" id="cont-4-1"> 
       <h3 align="left" style="background-color:#8383E7; padding: 3px 15px 3px; color:#FFF; font-size:15px;">Research</h3>
       <p></p>
	   <?php include("$DOCUMENT_ROOT/categories/comparch/research/index.php"); ?>
     </div>

     </form>

    <P></P> 	  
   	</div>
	<div class="clearthis">&nbsp;</div>
    
    <?php include("$DOCUMENT_ROOT/footer.html"); ?>
</div>

</body>
</html>