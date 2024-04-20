<?php 
date_default_timezone_set('Europe/Warsaw');  
function google() {
  //echo '
  //<script type="text/javascript"><!--
  //google_ad_client = "pub-3792030440284753";
  /* 728x90, utworzono 09-01-11, pierwszy duży główny */
  //google_ad_slot = "3028559192";
  //google_ad_width = 728;
  //google_ad_height = 90;
  //-->
  //</script>
  //<script type="text/javascript"
  //src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
  //</script>

  //';
}
  
function poczatek() {
if($_SESSION['logowanie'] == 'poprawne') { 
  
 
  $log=$_POST['login'];
  $zapytanie = "SELECT `id_user`,`login`,`haslo`,`ekipa`, `boss` FROM `User` WHERE    login=\"".$_SESSION['uzytkownik']."\"";
  $idzapytania = mysql_query($zapytanie) or die('mysql_query');
  while ($wiersz = mysql_fetch_row($idzapytania)) 
   {
      $logi=$wiersz[1];
      $idek=$wiersz[0];
      $ekipa = $wiersz[3];
      $_SESSION['boss']=$wiersz[4];
   }
  } else {}


echo '
<br/>Strona korzysta z plików cookies w celu realizacji usług. Możesz określić warunki przechowywania lub dostępu do plików cookies w ustawieniach Twojej przeglądarki.<br/>
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
<table id="glowna">
  <tr>
    <td class="gora" colspan="3">
      <!--  tu będą odnośniki o obrazki do forum i strony-->
      <a href="http://www.pro-cycling.org"><img class="obraz" src="img/layout_01.gif" alt="P-C" /></a><img src="img/layout_02.gif" class="obraz" alt="top" />
    </td>
  </tr>
  <tr>
    <td class="podgora" colspan="3" align="left">
    <!--  góra + logowanie-->
    
';

// Wyszukiwarka google.

echo '

    <style type="text/css">
    @import url(http://www.google.com/cse/api/branding.css);
    </style>
    <div class="cse-branding-right" style="background-color:#efefef;color:#000000">
      <div class="cse-branding-form">
        <form action="http://www.google.pl/cse" id="cse-search-box" target="_blank">
          <div>
            <input type="hidden" name="cx" value="partner-pub-3792030440284753:jujthhl5n6p" />
            <input type="hidden" name="ie" value="UTF-8" />
            <input type="text" name="q" size="31" />
            <input type="submit" name="sa" value="Szukaj" />
          </div>
        </form>
      </div>
      <div class="cse-branding-logo">
        <img src="http://www.google.com/images/poweredby_transparent/poweredby_999999.gif" alt="Google" />
      </div>
      <div class="cse-branding-text">
        Twoja wyszukiwarka
      </div>
    </div>

';    

// zamknięcie wyszukiwarki
echo '
    </td>
  </tr>
';

//informacje o logowaniu
echo '    <tr>';
echo '      <td class="podgora" colspan="3" align="right">';
echo '      <!--  góra + logowanie-->';      
      

      if($_SESSION['logowanie'] == 'poprawne') {     
        echo '<p>Witam<b> 
	'.$logi.'</b> - 
	'.$ekipa. ' ('.$idek.')</p>
	';
      } else { 
        echo '      <p style="color:red;">Aby uzyskać pełen dostęp do serwisu musisz się zalogować</p>
	';
      } 
echo '    </td>
  </tr>
  <tr class="srodek1">
    <td class="lewo">
';

      $czas=date("d-m-Y H:i");
      echo $czas;    

echo '      <table id="menu">
         <tr class="podmenu"><td>Ogólne:</td></tr>
         <tr><td>- <a href="index.php">Aktualności</a></td></tr>
';

echo '         <tr class="podmenu"><td>FFF:</td></tr>';

         if($_SESSION['logowanie'] == 'poprawne') {


echo '
         <tr><td>- <a href="user.php?id_user='.$idek.'">Moja drużyna:</a></td></tr>';
}
echo '
         <tr><td>- <a href="ligi.php">Ligi:</a></td></tr>';
         if($_SESSION['logowanie'] == 'poprawne') {	 
echo '
         <tr><td>- <a href="trans.php">Transfery</a></td></tr>
         <tr><td>- <a href="FA.php">Podpisywanie FA</a></td></tr>
         <tr><td>- <a href="przed.php">Przedłużanie</a></td></tr>
';

         } 
$rok_temu = date("Y")-1;
$rok_temu2 = date("Y")-2;
echo '         <tr class="podmenu"><td>dane:</td></tr>
         <tr><td>- <a href="teams.php">Ekipy:</a></td></tr>
         <tr><td>- <a href="country.php">Narodowości:</a></td></tr>
         <tr><td>- <a href="races.php">Wyścigi:</a></td></tr>
         <tr><td>- <a href="races.php?rok='.$rok_temu.'">Wyścigi '.$rok_temu.':</a></td></tr>
         <tr><td>- <a href="races.php?rok='.$rok_temu2.'">Wyścigi '.$rok_temu2.':</a></td></tr>
';

         if ($_SESSION['logowanie'] == 'poprawne') {

echo '         <tr class="podmenu"><td>FFF informacje:</td></tr>
         <tr><td>- <a href="boss.php">zarządzający grą:</a></td></tr>
         <tr><td>- <a href="transADM.php">transfery:</a></td></tr>
';

         } 
         if ($_SESSION['boss'] > 0 ) { 
echo '         <tr class="podmenu"><td>FFF informacje:</td></tr>
         <tr><td>- <a href="admin.php">panel zarządzający:</a></td></tr>
';
	 } 
echo '         <tr class="podmenu"><td>Rankingi:</td></tr>
         <tr><td>- <a href="kolarze.php">Klasyfikacja kolarzy:</a></td></tr>
         <tr><td>- <a href="rankingi.php">rankingi kolarzy '.date("Y").':</a></td></tr>
         <tr><td>- <a href="rankingi2007.php">rankingi kolarzy kroczący:</a></td></tr>
         </table> 
         
	 <br/> <br/>
	 
         <p><a href="http://validator.w3.org/check?uri=referer"><img
         src="http://www.w3.org/Icons/valid-xhtml10" class="obraz"
         alt="Valid XHTML 1.0 Strict" height="31" width="88" /></a></p>
	 ';
         

      
echo '      </td>
      <!--  główna część strony -->
      <td class="srodek" style="width: 70%;">';
    
  //$cosiedzieje = "CLOSE";
  $cosiedzieje = "OPEN";   

 if ($cosiedzieje == "CLOSE") {
   
   echo '<h1>Trwają prace na stronie</h1>';
   echo '<h1>przewidywany koniec za 20 minut</h1>';
   echo '<h1>nie wykonuj żadnych ruchów na stronie proszę</h1>';
   
 } 

}    
    
    
    


    
function koniec() {    
  
echo '       </td>
       <td class="prawo" style="width: 10%;">
       <!---->
       <!--  logowanie się -->
';

      echo logowanie();

echo '
          <br/> <br/> 
';

        if($_SESSION['logowanie'] == 'poprawne') {
        echo ' <br/><br/>szukaj kolarza
	 <form action="szukaj.php" method="POST">
	 <input  class="form" type="input" name="czego" />
	 <input  class="form2" type=submit value="Szukaj" />
        </form>
	';
        }
        
        


echo ' </td>
 </tr>
 <tr>
    <td class="dol" colspan="3">Done by BigBird (R)
    </td>
    </tr>
    </table>
    </div>
';



echo '
 </body>

</html>';

}
?>
