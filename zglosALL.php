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
   <title>FFF - wrzuć graczy ALL</title>
</head>
<body>
<div>

<?php
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
    $i = 1;
    $id_wys = $_GET['id_wys'];
    
    if ($id_wys > 18999) {
      
      $zapyt3 = "SELECT dataP FROM Wyscigi WHERE id_wys = '$id_wys'";
      $idzapyt3 = mysql_query($zapyt3) or die('mysql_query');
      while ($wiersz3 = mysql_fetch_row($idzapyt3)) 
      {
        echo "data wyścigu to: ",$wiersz3[0],"<br/>";
        $datka = $wiersz3[0];
      }
    
     $zapyt2 = "SELECT id_zgl FROM zgloszenia ORDER BY id_zgl DESC LIMIT 0, 1";
      $idzapyt2 = mysql_query($zapyt2) or die('mysql_query');
      while ($wiersz2 = mysql_fetch_row($idzapyt2)) 
      {
        echo "Ostatnie zgłoszenie to: ",$wiersz2[0],"<br/><br/><br/>";
        $idzg = $wiersz2[0] + 1;
        $i = $idzg;
      }
     
     
     
     
     
     $zapyt1 = "SELECT Kolarze.id_kol, Kolarze.nazw, Kolarze.id_user
                FROM Kolarze, ktopoj 
		WHERE ktopoj.id_wys=\"".$id_wys."\" AND Kolarze.id_user <>0 AND Kolarze.id_kol=ktopoj.id_kol 
		ORDER BY Kolarze.id_user, Kolarze.nazw, Kolarze.imie";
     echo $zapyt1.'<br/><br/><br/>';	
     $idzapyt1 = mysql_query($zapyt1) or die('mysql_query');
     while ($wiersz = mysql_fetch_row($idzapyt1)) 
     {
      echo 'Wystartował <b>',$wiersz[1],'</b> '.$wiersz[2];
      
      
      
     echo '<br/>sprawdzamy kiedy kolarz został kupiony (czy należy mu się zgłosznie)<br/>';
     $zapytanie_kol_trans = "SELECT `kiedy`, `id_userK`, `id_userS` FROM `transzaak` WHERE `id_kol`= '$wiersz[0]' ORDER BY `kiedy` DESC";
     //echo $zapytanie_kol_trans.' <br/>';
    
     $idz_kol_trans = mysql_query($zapytanie_kol_trans) or die('mysql_query');
     //echo 'test';
     $dane_sql_kol_trans = mysql_fetch_row($idz_kol_trans);
     
     //wyścig odbywa się $datka ostatni transfer to $dane_sql_kol_trans[0]
     //jeżeli datka > $dane kol oznacza to że transfer był wcześniej.
      echo 'wyścig '.$datka.' ostatni transter '.$dane_sql_kol_trans[0].' <br/>';
      
      
      
      if ($datka < $dane_sql_kol_trans[0]) {
        echo 'kolarz kupiony po wyścigu więc powinien pojechać dla: '.$dane_sql_kol_trans[2].' a nie dla '.$dane_sql_kol_trans[1].' <br/>';
        $wiersz[2] = $dane_sql_kol_trans[2];
      } 
      
    
      
    
      echo $i," -> id.kol: ",$wiersz[0]," w wys: ",$id_wys," zzgł: ",$data,"  zgłaszał: ".$wiersz[2]."<br/>";
      $prio = 0;
      
      echo 'Sprawdzamy czy przez przypadek nie ma zgłoszenia tego kolarza wrzuconego wcześniej.';
      $sql_czy_zglaszalem = "SELECT id_kol FROM zgloszenia WHERE id_wys = '$id_wys' AND id_kol='$wiersz[0]'";
      $idz_czy_zglaszalem = mysql_query($sql_czy_zglaszalem) or die('mysql_query');
      
      echo $sql_czy_zglaszalem."<br/>";
      $dane_sql_czy_zglaszalem = mysql_num_rows($idz_czy_zglaszalem);
      echo 'znaleziono rekordów:'.$dane_sql_czy_zglaszalem.'<br/>';
      
      $zapyt2 = "INSERT INTO zgloszenia (id_zgl, kolej, id_kol, id_wys, id_user, pri, dataZ) VALUES ('$i', 1, '$wiersz[0]', '$id_wys', '$wiersz[2]', '$prio', '$datka')";
      
      
      if ($dane_sql_czy_zglaszalem == 0) {
        
        //if ($wiersz[2] == 0) {
        //  echo 'nie zgłaszamy 0';
	//} else {
	//  echo $zapyt2;
	//  
	//}
	
	
        
	
	
	echo '<font color=green>nie było zgłoszenia wcześniej więc</font>  - '.$zapyt2,"<br/>";
        $idzapyt22 = mysql_query($zapyt2) or die('mysql_query');
        echo 'udało się!<br/><br/>';
	$i = $i + 1;
      } else {
        echo '<font color=red>Kolarz był już zgłoszony więc nie dodaję go ponownie</font></br><br/>';
      }
      
     }
    
    } else {
      echo "Nie podałeś id wyścigu";
    }
    
    
    echo koniec();
?>
    
    
    
