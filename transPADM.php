<?php 
  //ł±czenie się z bazą php
  session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US">
<head>
   <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
   <meta http-equiv="Content-Language" content="pl"/>
   <meta name="Author" content="Michał Myśliwiec"/>
   <link rel="stylesheet" href="style.css" type="text/css"/>
   <title>FFF - lista transferwa</title>
</head>
<body>
<div>


<?php
  echo google();

  $connection = @mysql_connect(getenv('DB_HOST'), getenv('DB_USER'), getenv('DB_PASS'));
  $db = @mysql_select_db(getenv('DB_NAME'), $connection)
   or die('Nie mogę poł±czyć się z baz± danych<br />Bł±d: '.mysql_error());
  echo "<p style='font-size:5pt;'>Udało się poł±czyć z baz± dancych!</p>";
  mysql_query("SET NAMES 'utf8'");
  include_once('logowanie.php');
  
  //sprawdzanie poprawności logowania
  if($_SESSION['logowanie'] == 'poprawne') { 
  $log=$_POST['login'];
  $zapytanie = "SELECT `id_user`,`login`,`haslo`,`ekipa`, `boss` FROM `User` WHERE login=\"".$_SESSION['uzytkownik']."\"";
  $idzapytania = mysql_query($zapytanie) or die('mysql_query');
  while ($wiersz = mysql_fetch_row($idzapytania)) 
   {
      $logi=$wiersz[1];
      $idek=$wiersz[0];
      $ekipa=$wiersz[3];
      $_SESSION['boss']=$wiersz[4];
   }
  } else {}
  ?>
  <table id="glowna">
    <tr>
      <td class="gora" colspan="3">
      <!--  tu będą odnośniki o obrazki do forum i strony-->
      <a href="http://www.pro-cycling.org"><img class="obraz" src="img/layout_01.gif" alt="P-C" /></a><img src="img/layout_02.gif" class="obraz" alt="top" />
      </td>
    </tr>
    <tr>
      <td class="podgora" colspan="3" align="right">
      <!--  góra + logowanie-->
      <?php 
      if($_SESSION['logowanie'] == 'poprawne') {
      echo '<p>Witam<b> ';
      echo $logi.'</b> - ';
      echo $ekipa. ' ('.$idek.')</p>';
      } else { ?>
      <p style='color:red;'>Aby uzyskać pełen dostęp do serwisu musisz się zalogować</p>
      <?php } ?>
    </td>
  </tr>
  <tr class="srodek1">
    <td class="lewo">
      <?php  
      $czas=date("d-m-Y G:i");
      echo $czas;    
      ?>
      <table id="menu">
         <tr class="podmenu"><td>Ogólne:</td></tr>
         <tr><td>- <a href="index.php">Aktualności</a></td></tr>
         <?php 
         if($_SESSION['logowanie'] == 'poprawne') {
         ?>
         <tr class="podmenu"><td>FFF:</td></tr>
         <tr><td>- <a href="user.php?id_user=<?php echo $idek; ?>">Mój team:</a></td></tr>
         <tr><td>- <a href="ligi.php">Ligi:</a></td></tr>
         <tr><td>- <a href="trans.php">Transfery</a></td></tr>
         <tr><td>- <a href="FA.php">Podpisywanie FA</a></td></tr>
         <?php 
         } else {}
         ?>
         <tr class="podmenu"><td>dane:</td></tr>
         <tr><td>- <a href="teams.php">Ekipy:</a></td></tr>
         <tr><td>- <a href="country.php">Narodowości:</a></td></tr>
         <tr><td>- <a href="races.php">Wyścigi:</a></td></tr>
         <?php 
         if ($_SESSION['logowanie'] == 'poprawne') {
         ?>
         <tr class="podmenu"><td>FFF informacje:</td></tr>
         <tr><td>- <a href="boss.php">zarządzający grą:</a></td></tr>
         <tr><td>- <a href="transADM.php">transfery:</a></td></tr>
         <?php 
         } else {}
         if ($_SESSION['boss'] > 0 ) { ?>
           <tr class="podmenu"><td>FFF informacje:</td></tr>
           <tr><td>- <a href="admin.php">panel zarządzający:</a></td></tr>
         <?php 
	 } else {}
         ?>	          
      </table> <br/> <br/>
      <p><a href="http://validator.w3.org/check?uri=referer"><img
          src="http://www.w3.org/Icons/valid-xhtml10" class="obraz"
          alt="Valid XHTML 1.0 Strict" height="31" width="88" /></a></p>
    </td>
    <!--  główna część strony -->
    <td class="srodek">
    <?php 
      if($_SESSION['logowanie'] == 'poprawne') { 
        if ($_SESSION['boss'] >= 0) {
             $sort1=$_GET['sort'];
             
             echo  '<form action="transADM.php" method="get">';
             echo  '<input class="form" type=radio name=sort value=1 ';
	     if ($sort1 == 1) {
               echo 'checked="checked"';
             }
	     echo  '>Sortowanie po nazwiskach kolarzy<br>';
             echo  '<input class="form" type=radio name=sort value=2 ';
	     if ($sort1 == 2) {
               echo 'checked="checked"';
             }
	     echo  '>Sortowanie po kupujących<br>';
             echo  '<input class="form" type=radio name=sort value=3 ';
	     if ($sort1 == 3) {
               echo 'checked="checked"';
             }
	     echo  '>Sortowanie po sprzedających<br>';
             echo  '<input class="form2" type="submit" value="Sortuj" />'; 
             echo  '</form>';

          

          
          
            $sort1=$_GET['sort'];
            echo $sort1;
            if ($sort1 == 3) {
              $sql3 =  " SELECT Kolarze.imie , Kolarze.nazw , transprop.kiedy , transprop.ile , User_1.login , User.login, transprop.id_tp, Kolarze.cena "
                    .  " FROM User AS User_1 INNER JOIN ( User INNER JOIN ( transprop INNER JOIN Kolarze ON transprop.id_kol = Kolarze.id_kol ) ON User.id_user = transproop.id_userK ) ON User_1.id_user = transprop.id_userS" 
                    .  " ORDER BY User_1.login";
            } elseif ($sort1 == 2)
            {
    	      $sql3 = " SELECT Kolarze.imie , Kolarze.nazw , transprop.kiedy , transprop.ile , User_1.login , User.login, transprop.id_tp, Kolarze.cena "
                    .  " FROM User AS User_1 INNER JOIN ( User INNER JOIN ( transprop INNER JOIN Kolarze ON transprop.id_kol = Kolarze.id_kol ) ON User.id_user = transprop.id_userK ) ON User_1.id_user = transprop.id_userS" 
                    .  " ORDER BY User.login "  ;
	    } else 
	    {
	      $sql3 = " SELECT Kolarze.imie , Kolarze.nazw , transprop.kiedy , transprop.ile , User_1.login , User.login, transprop.id_tp, Kolarze.cena "
                    .  " FROM User AS User_1 INNER JOIN ( User INNER JOIN ( transprop INNER JOIN Kolarze ON transprop.id_kol = Kolarze.id_kol ) ON User.id_user = transprop.id_userK ) ON User_1.id_user = transprop.id_userS" 
                    .  " ORDER BY Kolarze.nazw "  ;
            }
            echo $sort;
            $wydatki=0;
            $zarobki=0;
	    echo '<h5 style="color=red;"> Kolarze którzy mogą zmienić barwy (proponowane transfery): </h5>';
	    
            $zap3 = mysql_query($sql3) or die('mysql_query');
            echo '<table class="wyscig">';
            echo '<tr><td class="wyscig9"> Kolarz </td><td class="wyscig6" style="text-align: middle;"> kiedy zapr. </td><td class="wyscig6" style="text-align: middle;"> Sprzedający </td><td class="wyscig6" style="text-align: middle;"> Kupujący </td><td class="wyscig1" style="text-align: right;"> za ile </td><td class="wyscig6" style="text-align: middle;"> ile kosztował poprzednio </td></tr>';
            while ($dan3 = mysql_fetch_row($zap3)) 
            {
              echo '<tr><td class="wyscig9">'.$dan3[0].' '.$dan3[1].'</td></td><td class="wyscig6" style="text-align: middle;">'.$dan3[2].'</td><td class="wyscig6" style="text-align: middle;"> '.$dan3[4].'</td><td class="wyscig6" style="text-align: middle;"> '.$dan3[5].'</td><td class="wyscig1" style="text-align: right;"> <b>'.$dan3[3].'C </b><td class="wyscig6" style="text-align: right;"> ';
	      
	      echo $dan3[8];
	      
	      echo 'C </td></tr>';
            }
              echo '</table>';
            
       
          } else {
            echo 'Nie masz uprawnień do tej strony';
          } 
       } else {
      echo 'Musisz się zalogować';
    }   
    ?>
    
    
    
    
    </td>
    <td class="prawo">
    <!--  logowanie się -->
      <?php
      echo logowanie();
      ?>
      <br/> <br/> 
      <?php 
        if($_SESSION['logowanie'] == 'poprawne') {
        echo ' <br/><br/>szukaj kolarza';
        echo ' <form action="szukaj.php" method="POST">';
        echo ' <input  class="form" type="input" name="czego" />';
        echo ' <input  class="form2" type=submit value="Szukaj" />';
        echo ' </form>';
        }
      ?>

    </td>
  </tr>
  <tr>
    <td class="dol" colspan="3">Done by BigBird (R)
      </td>
  </tr>
</table>
</div>
</body>
</html>
