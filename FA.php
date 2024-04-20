<?php 
  //ł±czenie się z bazą php
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
   <title>FFF - licytacja</title>
</head>
<body>
<div>

<?php
  echo google();

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
    
    
        $dzis = date ("Y-m-d");
	$sql1 = " SELECT dok, typ FROM wydarzenia "
              . " WHERE dataP <= '$dzis' AND dataK >= '$dzis' AND ( typ = 2 OR typ = 3) ";
        $zap1  = mysql_query($sql1) or die('mysql_query');
        if(mysql_num_rows($zap1) > 0) {
           echo '<h4>Kolarze których aktualnie licytujesz</h4>';
           echo '<table class="wyscig">';
           echo '<tr><td class="wyscig9"> Kolarz </td><td class="wyscig8"> data licytacji </td><td class="wyscig6"> Za ile </td><td class="wyscig6"> max kwota </td><td class="wyscig6"> ilu licytuje </td></tr>';
           $sql2 = " SELECT Kolarze.imie , Kolarze.nazw , Kolarze.id_kol , licytacje.data , licytacje.ile , Kolarze.cena , licytacje.id_user  "
                 . " FROM licytacje, Kolarze "
                 . " WHERE licytacje.id_user = '$idek' AND licytacje.id_kol = Kolarze.id_kol ";
           $zap2  = mysql_query($sql2) or die('mysql_query');
           $wydatki = 0;
           while ($dan2 = mysql_fetch_row($zap2)) {
             echo '<tr><td><a href="kol.php?id_kol='.$dan2[2].'">'.$dan2[0].' '.$dan2[1].'</a></td><td><br/>'.$dan2[3].'<-T';
	     
	     $sql5 = " SELECT max(ile) FROM licytacje WHERE id_kol= '$dan2[2]' ";
	     $zap5  = mysql_query($sql5) or die('mysql_query');
	     $dan5 = mysql_fetch_row($zap5);
	     $wydatki = $wydatki + $dan2[4];
	     
	     
	     $sql6 = " SELECT dok, typ FROM wydarzenia "
                   . " WHERE dataP <= '$dzis' AND dataK >= '$dzis' AND typ = 3 ";
             $zap6  = mysql_query($sql6) or die('mysql_query');
             if(mysql_num_rows($zap6) > 0) {
               
	       $sql4321 = " SELECT data "
                        . " FROM licytacje "
                        . " WHERE id_kol = '$dan2[2]' "
                        . " ORDER BY data DESC "
		        . " LIMIT 0, 1 ";
               $zap4321 = mysql_query($sql4321) or die('mysql_query');
               $dan4321 = mysql_fetch_row($zap4321);
             
               $dane24pobidzie = strtotime($dan4321[0]) + 24 * 3600;
               $dane24pobidzie = date("Y-m-d G:i:s",$dane24pobidzie);
               
               

               $czasa = date("Y-m-d H:i:s");
               
               
               
               // wypisane informacje o zawodniku a w przypadku daty dorzucamy ostatni bid.
               
               
               if ($czasa > $dane24pobidzie ) 
	       { 
	         echo '<br/>'.$dane24pobidzie.'<-K<br/><br/></td><td style="text-align: right;"><b>'.$dan2[4].'C</b></td><td style="text-align: right;">';
                 echo $dan5[0].'C </td><td style="text-align: right;"> licytacja zakończona </td></tr>';
	       } else {
	       
	       $sql10 = " SELECT Count(licytacje.id_lic) AS PoliczOfid_lic "
                      . " FROM licytacje WHERE id_kol = '$dan2[2]' ";
               $zap10 = mysql_query($sql10) or die('mysql_query');
               $dan10 = mysql_fetch_row($zap10);
               
               $ile_czasu_pozostalo = strtotime($dan4321[0]) + 23 * 3600 - strtotime($czasa);
               $ile_czasu_pozostalo = date("G:i:s",$ile_czasu_pozostalo);
               
               echo '<br/>'.$dane24pobidzie.'<-K<br/>pozostało - '.$ile_czasu_pozostalo.'<br/><br/></td><td style="text-align: right;"><b>'.$dan2[4].'C</b></td><td style="text-align: right;">';
	       echo $dan5[0].'C </td><td style="text-align: right;"> '.$dan10[0].' </td></tr>';
	       }
	       
	       
             } else {
               echo '</td><td style="text-align: right;"><b>'.$dan2[4].'C</b></td><td style="text-align: right;">';
               echo 'tajna </td><td style="text-align: right;"> tajne </td></tr>';
             }
             
           }
           echo '</table>T -> Ty; K -> koniec licytacji w obeznym stanie (przy zachowaniu zasady 24h)<br/><br/>';
           
           $sql3 = " SELECT kasa "
                 . " FROM User "
                 . " WHERE id_user = '$idek' ";
           $zap3  = mysql_query($sql3) or die('mysql_query');
           $dan3 = mysql_fetch_row($zap3);
           
           echo 'Panowane wydatki: <b>'.$wydatki.'C</b><br/>';
           echo 'Twoje pieniądze: <b>'.$dan3[0].'C</b><br/>';
           $wydatki1 = $dan3[0] - $wydatki;
           echo 'Ewentualne pieniądze po uwzględnieniu wydatków: <b>'.$wydatki1.'C</b><br/>';
           
         } else {
           echo '<h4>Zgłaszanie kolarzy do licytacji i same licytacje są zamknięte</h4>';
         }
         
         } else {
           echo ' A może byś się tak zalogował???';
         }
         
         
         
         echo koniec();
       ?>
    
    
    
