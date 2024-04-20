<?php 
  //ł±czenie się z bazą php
  session_start();
?>
<?php 
$connection = @mysql_connect(getenv('DB_HOST'), getenv('DB_USER'), getenv('DB_PASS'));
  $db = @mysql_select_db(getenv('DB_NAME'), $connection)
   or die('Nie mogę połączyć się z bazą danych<br />Błąd: '.mysql_error());
  echo "<p style='font-size:5pt;'>Udało się połączyć z bazą dancych!</p>";
  mysql_query("SET NAMES 'utf8'");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US">
<head>
   <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
   <meta http-equiv="Content-Language" content="pl"/>
   <meta name="Author" content="Michał Myśliwiec"/>
   <link rel="stylesheet" href="style2.css" type="text/css"/>
   <title>SKARB KIBICA - coś</title>
</head>
<body>


<?php
  //echo google();
?>
 



<div id="top">

     <script type="text/javascript"><!--
       google_ad_client = "pub-3792030440284753";
       /* 728x90, utworzono 09-01-11, pierwszy duży główny */
       google_ad_slot = "3028559192";
       google_ad_width = 728;
       google_ad_height = 90;
       //-->
     </script>
     <script type="text/javascript"
       src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
     </script>

	<div>
	    <div id="NAGLOWEKLEWY"><a href="http://www.pro-cycling.org"><img src="graf/tlonagle.jpg" alt="pro-cycling.org" /></a></div> 
	    <div id="NAGLOWEKPRAWY"><img src="graf/tlonagpr.jpg" alt="SKARB KIBICA" /></div>  
	</div>
	
	<div id="NAGLOWEK2">
	
	wyszukiwarka
	             
        </div>
	
	<div id="srodek">  
	   <div id="MENU">
	     <br/>
	     <b>Skarb: </b> <br/> 
	     - ekipy <br/>
	     - narodowości <br/> 
	     - wyścigi <br/> 
	     <br/> <br/>
	     <b>Ranking: </b>  <br/>
	     - ranking 
	     <?php 
    	        $rok = date('Y');
	        echo $rok;
	     ?>
	      <br/>
	     - ranking kroczący <br/>
	   </div>
	   
	   <div id="TRESC"><br/><br/><br/><br/>
	      k<br/>	    k <br/>	    k <br/>	    kh <br/>	    h <br/>	    h <br/>	    h <br/>	    h <br/>	    h <br/>	    h <br/> 	    h <br/>	    k <br/>	    k <br/>	    kk <br/>	    k <br/>	    i nie wiem co dalej  <br/>	    ih <br/>	    hf <br/>	    f <br/> e <br/>	    e <br/>	    robisz coś jeszcze
	   </div>
	   
  	    <div id="INFORMACJE">
               <script type="text/javascript"><!--
                 google_ad_client = "pub-3792030440284753";
                 /* 120x240, 09-01-22 pionowa */
                 google_ad_slot = "8819685630";
                 google_ad_width = 120;
                 google_ad_height = 240;
               //-->
               </script>
               <script type="text/javascript"
                 src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
               </script>
            </div> 
       </div> 
	
       <div id="STOPKA"><img  src="graf/Logomoje.png" alt="logo" /></div>

       <script type="text/javascript"><!--
         google_ad_client = "pub-3792030440284753";
         /* 728x15, 09-01-22 dół */
         google_ad_slot = "7023358724";
         google_ad_width = 728;
         google_ad_height = 15;
         //-->
       </script>
       <script type="text/javascript"
         src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
       </script>
       
  
</div> 
</div>
</body>

</html>
      
    
    
    
   
