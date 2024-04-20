<?php 
  //łączenie się z bazą php
  session_start();
  include_once('glowne.php');
?>
<?php 
$connection = @mysql_connect(getenv('DB_HOST'), getenv('DB_USER'), getenv('DB_PASS'));
  $db = @mysql_select_db(getenv('DB_NAME'), $connection)
   or die('Nie mogę połączyć się z bazą danych<br />Błąd: '.mysql_error());
  echo "<p style='font-size:5pt;'>Udało się połączyć z bazą dancych!</p>";
  mysql_query("SET NAMES 'utf8'");
  include_once('logowanie.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US">
<head>
   <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
   <meta http-equiv="Content-Language" content="pl"/>
   <meta name="Author" content="Michał Myśliwiec"/>
   <link rel="stylesheet" href="style.css" type="text/css"/>
   <title>FFF - srawdzanie licytacji</title>
</head>
<body>
<div>

<?php
  $licyt_zakoncone = 0;
  $licyt_trwajace = 0;
   
  $zapyt = "SELECT id_user, login, haslo, ekipa, boss FROM User WHERE login=\"".$_SESSION['uzytkownik']."\"";
  $idzapyt = mysql_query($zapyt) or die('mysql_query');
  while ($wiersza = mysql_fetch_row($idzapyt)) 
   {
      $logi=$wiersza[1];
      $idek=$wiersza[0];
      $ekipa = $wiersza[3];
      $_SESSION['boss']=$wiersza[4];
   }
   //sprawdzanie poprawności logowania
  if($_SESSION['logowanie'] == 'poprawne') { 
  $log=$_POST['login'];
  $zapytanie = "SELECT `id_user`,`login`,`haslo`,`ekipa`, `boss` FROM `User` WHERE login=\"".$_SESSION['uzytkownik']."\"";
  $idzapytania = mysql_query($zapytanie) or die('mysql_query');
  while ($wiersz = mysql_fetch_row($idzapytania)) 
   {
      $logi=$wiersz[1];
      $idek=$wiersz[0];
      $ekipa = $wiersz[3];
      $_SESSION['boss']=$wiersz[4];
   }
  } else {}
    echo poczatek();
      if($_SESSION['logowanie'] == 'poprawne') {
        if ($_SESSION['boss'] >= 1) {        
        $dzis = date ("Y-m-d H:i:s");
        echo 'Dziś mamy: '.$dzis;
        echo '<br/><br/><br/>';
        echo 'Sprawdzamy którzy kolarze nie byli licytowani przez ostatnie 24 godziny. <br/><br/>';
        
        $sql901 = " SELECT id_kol FROM licytacje GROUP BY id_kol ORDER BY id_kol ";

        $zap901 = mysql_query($sql901) or die('mysql_query');
        while ($dan901 = mysql_fetch_row($zap901)) 
        {

          $sql902 = " SELECT licytacje.id_kol, Kolarze.imie, Kolarze.nazw, licytacje.ile, licytacje.data, User.ekipa, Kolarze.cena, licytacje.id_user "
                  . " FROM (licytacje INNER JOIN Kolarze ON licytacje.id_kol = Kolarze.id_kol) INNER JOIN User ON licytacje.id_user = User.id_user "
                  . " WHERE licytacje.id_kol = '$dan901[0]' "
		  . " ORDER BY licytacje.ile DESC, licytacje.data, licytacje.id_lic ";
          $zap902 = mysql_query($sql902) or die('mysql_query');
          $dan902 = mysql_fetch_row($zap902);
          $id_kol = $dan901[0];
 
          $dane24pobidzie = strtotime($dan902[4]) + 24 * 3600;
          $dane24pobidzie = date("Y-m-d H:i:s",$dane24pobidzie);

          $czasa = date("Y-m-d H:i:s");
               
          $sqlile = " SELECT licytacje.id_lic FROM licytacje WHERE licytacje.id_kol = '$dan901[0]' ";    
          $zapile = mysql_query($sqlile) or die('mysql_query'); 
          
          echo 'ilość aktualnych licytacji kolarza: '.mysql_num_rows($zapile).'<br/>';
          
          if ( $czasa > $dane24pobidzie OR mysql_num_rows($zapile) == 1 ) 
          {
  
          
            $dan2[1] = $dan902[7];
            $dan2[0] = $dan902[3];
            //echo $dan2[1].' oooooooooooooooooooooooooooooooooooooo '.$dan2[0].' <br/>';
          
            $sql8 = " SELECT cena, imie, nazw "
                  . " FROM Kolarze "
                  . " WHERE id_kol = '$id_kol' ";
            $zap8 = mysql_query($sql8) or die('mysql_query');
            $dan8 = mysql_fetch_row($zap8);  
            //echo $dan8[0].'     oppopopopsdaksaofpovjnocns<br/>';
            
                        
            //---------------------------------------------------------------------
            //|                     Zmieniamy dane kolarza                        -
            //---------------------------------------------------------------------
            
            
            $sql4 = " UPDATE Kolarze " 
                  . " SET id_user = '$dan2[1]', cena = '$dan2[0]'"
                  . " WHERE id_kol = '$id_kol' ";
            $zap4 = mysql_query($sql4) or die('mysql_query');
                        
            //---------------------------------------------------------------------
            //|                     Sprawdzamy dane ekipy                         -
            //---------------------------------------------------------------------   
            
            $sql5 = " SELECT kasa, ekipa " 
                  . " FROM User "
                  . " WHERE id_user = '$dan2[1]' ";
            $zap5 = mysql_query($sql5) or die('mysql_query');
            $dan5 = mysql_fetch_row($zap5);
                      
            //---------------------------------------------------------------------
            //|                     Zmieniamy dane ekipy                          -
            //---------------------------------------------------------------------

            $kasa = $dan5[0] - $dan2[0];
            $sql6 = " UPDATE User " 
                  . " SET kasa = '$kasa'"
                  . " WHERE id_user = '$dan2[1]' ";
            $zap6 = mysql_query($sql6) or die('mysql_query');
                        
            //---------------------------------------------------------------------
            //|              dopisujemy całą akcję do transferów                  -
            //---------------------------------------------------------------------            
            
            $sql7 = " SELECT id_tpZ "
                  . " FROM transzaak "
                  . " ORDER BY id_tpZ DESC "
                  . " LIMIT 0, 1 ";
            $zap7 = mysql_query($sql7) or die('mysql_query');
            $dan7 = mysql_fetch_row($zap7);
            $id_tp1 = $dan7[0] + 1;
            
    
            
            
            $sql9 = " INSERT INTO transzaak "
	          . " VALUES ('$id_tp1', '$dan902[4]', '$id_kol', '$dan2[1]', 0, '$dan2[0]', '$dan8[0]', 2) ";
            $zap9 = mysql_query($sql9) or die('mysql_query');
            
            echo $dan902[4].' Kolarz <b>[b]'.$dan8[1].' '.$dan8[2].'[/b]</b> ('.$id_kol.') warty '.$dan8[0].' przechodzi do <b>[b]'.$dan5[1].'[/b]</b> ('.$dan2[1].') na zasadzie zasady 24h/1 bida za '.$dan2[0].'C <br/>';
            echo 'Aktywne w tym momencie Bidy na kolarza: <br/>';
            $licyt_zakoncone = $licyt_zakoncone + 1;
            $sql91100 = " SELECT User.ekipa, licytacje.data, licytacje.ile "
                      . " FROM licytacje INNER JOIN User ON licytacje.id_user = User.id_user "
                      . " WHERE licytacje.id_kol = '$id_kol' "
                      . " ORDER BY licytacje.ile DESC, licytacje.id_lic ";
           $zap91100 = mysql_query($sql91100) or die('mysql_query');
           while ($dan91100 = mysql_fetch_row($zap91100)) { 
             echo ' - <b>[b]'.$dan91100[0].'[/b]</b> {<i>[i]'.$dan91100[1].'[/i]</i>} - '.$dan91100[2].'C<br/>';
           }
            $sql500 = " DELETE FROM licytacje "
	            . " WHERE id_kol = '$id_kol' ";
            $zap500 = mysql_query($sql500) or die('mysql_query');
          
          echo '<br/><br/>';
          } else 
	  {
	    echo '<B>[b]'.$dan902[1].' '.$dan902[2].'[/b]</b> ('.$dan902[0].') ostatni bid: '.$dan902[4].'<br/>';
            echo 'Licytacja trwa nadal <br/><br/>';
            $licyt_trwajace = $licyt_trwajace + 1;
          }
        }
        
        echo "<br/><br/><br/>Przy okazji tego podliczenia zakończono [b]".$licyt_zakoncone."[/b] licytacji <br/> Pozostało w trakcie [b]".$licyt_trwajace."[/b] licytacji";
        
        } else {
        echo 'Nie jesteś adminem i nie masz dostępudo tej strony więc nie <i>kOMbinuj</i> <br/> BO CIĘ ZNAJDZIEMY';
      }
      } else {
        echo 'Nie masz uprawnień dostępu do tej strony';
      }
      
      
      
      
      
      echo koniec();
    ?>
    

    
