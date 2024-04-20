<?php 
include_once('jez.php');
  
function poczatek() {
  echo '<script type="text/javascript" src="whcookies.js"></script>';
  global $jezyk;
  echo '<div id="supertop">
 <!-- Strona korzysta z plików cookies w celu realizacji usług. Możesz określić warunki przechowywania lub dostępu do plików cookies w ustawieniach Twojej przeglądarki.<br/> -->
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
                </script>';
		
		
		echo '
		
		<script type="text/javascript">
                   var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
                   document.write(unescape("%3Cscript src=\'" + gaJsHost + "google-analytics.com/ga.js\' type=\'text/javascript\'%3E%3C/script%3E"));
                </script>
                <script type="text/javascript">
                   try {
                   var pageTracker = _gat._getTracker("UA-7230447-1");
                   pageTracker._trackPageview();
                } catch(err) {}</script>
                
		';
		
		
		echo '
                
                
                <br/>
                <div id="top">

	<div id="NAGLOWEK">
	    <!--<div id="NAGLOWEKLEWY">	     
	        <img src="graf/tlonagle.png" alt="pro-cycling.org" /></div>
	    <div id="NAGLOWEKPRAWY">
	        <img src="graf/tlonagpr.png" alt="SKARB KIBICA" /></div> -->
	    ';
	    
	    if ($jezyk == "EN") {
	       echo '<img src="graf/tlonag_EN.jpg" alt="CYCLING DATABASE" />';
	    } else {
	       echo '<img src="graf/tlonag.jpg" alt="SKARB KIBICA" />';
	    }
	    
	    
	    
	    echo '
            
	</div>
	<div id="NAGLOWEK2">';
	

	    
	    // Szukaj kolarza...
	    echo '<div style="float: left; width: 350px; padding-top: 0px;">'.zwroc_tekst(12, $jezyk).'
	       <form action="szukaj.php" method="POST">
	         <input  class="form" type="input" name="czego" value="'.$czego.'"/>
	         <input  class="form2" type=submit value="'.zwroc_tekst(4, $jezyk).'" />
               </form>
               
	       </div>';
	    
	    // '.$_SERVER['HTTP_ACCEPT_LANGUAGE'].'
	    
	    echo '<div style="float: right; paddig-right: 15px; padding-top: 0px;">';
	    include_once('zmienjezyk.php');
	    //ZMIANA JĘZYKA!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	        
	     echo '  
	      </div>
	</div>
	<div id="srodek">  
	   <div id="MENU">
	      <br/>
	     <b>'.zwroc_tekst(6, $jezyk).'</b>
	     <ul>
	       <li style="margin-left: -25px;"><a href="index.php">'.zwroc_tekst(7, $jezyk).'</a> </li>
	     </ul> 
	     <b>'.zwroc_tekst(8, $jezyk).'</b> <br/> 
	     <ul>
	       <li style="margin-left: -25px;"><a href="teams.php">'.zwroc_tekst(9, $jezyk).'</a> </li>
	       <li style="margin-left: -25px;"><a href="nats.php">'.zwroc_tekst(10, $jezyk).'</a> </li>
	       <li style="margin-left: -25px;"><a href="races.php">'.zwroc_tekst(11, $jezyk).'</a></li>
	       <li style="margin-left: -25px;"><a href="trans.php">'.zwroc_tekst(127, $jezyk).'</a> </li>
	       <li style="margin-left: -25px;"><a href="champs.php">'.zwroc_tekst(126, $jezyk).'</a> </li>
	       <li style="margin-left: -25px;"><a href="szukaj.php">'.zwroc_tekst(12, $jezyk).'</a> </li>
               <li style="margin-left: -25px;"><a href="szukajpor.php">'.zwroc_tekst(138, $jezyk).'</a> </li>
	     </ul>
	     <br/>
	     <b>'.zwroc_tekst(13, $jezyk).'</b>  <br/>
	     <ul>
	       <li style="margin-left: -25px;"><a href="rankingib.php">'.zwroc_tekst(14, $jezyk).' ';
    	       $rok = date('Y');
	       //echo $rok;
               echo '</a>
	       </li> 
	       <li style="margin-left: -25px;"><a href="rankingikro.php">'.zwroc_tekst(15, $jezyk).'</a></li>
	     </ul>
	     <br/>
	     <b>'.zwroc_tekst(20, $jezyk).'</b>  <br/>
	     <ul>
	       <li style="margin-left: -25px;"><a href="wyjskr.php">'.zwroc_tekst(76, $jezyk).'</a></li>
	     </ul>
	   </div>';
 }
 
function koniec() {
  
  //<font style="color: white;">kolarstwo, skarb kibica, kolarze itp</font> 
  echo '
  </div> 
       <div id="STOPKA"><a href="mailto:bigbird@pro-cycling.org">bigbird@pro-cycling.org</a> <img src="graf/Logomoje.png" alt="logo" /></div>
</div>

  <div id="INFORMACJE">
   <script type="text/javascript"><!--
     google_ad_client = "pub-3792030440284753";
     /* 120x600, utworzono 09-06-17 */
     google_ad_slot = "3914821586";
     google_ad_width = 120;
     google_ad_height = 600;
   //-->
   </script>
   <script type="text/javascript"
     src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
   </script>
  </div>
  
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

</div>

  ';
} 
 
?>
