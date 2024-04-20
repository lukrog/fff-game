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
   <title>FFF - dane ekipy</title>
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
          $czy_w_tym_roku_istniala = 0;
          $id_rok = $_GET['rok'];
	  $id_team = $_GET['id_team'];
	  echo '<table class="wyscig">';
          echo '<tr><td>ROK</td><td>nazwa ekipy</td><td>Skr</td><td>Dyw</td></tr>';
	  
	  
	  $sqlhise = " SELECT z_a_historiaekip.nazwa, z_a_historiaekip.id_nat, z_a_historiaekip.skr, z_a_historiaekip.dyw, Nat.flaga, z_a_historiaekip.rok "
                   . " FROM z_a_historiaekip INNER JOIN Nat ON z_a_historiaekip.id_nat = Nat.id_nat"
	           . " WHERE (z_a_historiaekip.id_ek = '$id_team')"
		   . " ORDER BY z_a_historiaekip.rok ";
	  $zaphise = mysql_query($sqlhise) or die('mysql_query');
	  while ($danhise = mysql_fetch_row($zaphise))
	  {
	     if ($danhise[5] == $id_rok) {
	        echo '<tr><td class="wyscig5"><b>'.$danhise[5].'</b></td><td class="wyscig7"><img src="img/flagi/'.$danhise[4].'" alt="flaga" /> <b>'.$danhise[0].'</b></td><td class="wyscig5">'.$danhise[2].'</td><td class="wyscig5">'.$danhise[3].'</td</tr>';
	        $czy_w_tym_roku_istniala = 1;
	     } else {
                echo '<tr><td class="wyscig5"><a href="teamh.php?id_team='.$id_team.'&rok='.$danhise[5].'">'.$danhise[5].'</a></td><td class="wyscig7"><img src="img/flagi/'.$danhise[4].'" alt="flaga" /> '.$danhise[0].'<td class="wyscig5">'.$danhise[2].'</td><td class="wyscig5">'.$danhise[3].'</td></tr>';
             }   
	  }
	  echo '</table>
	  
	  <br/><br/>';
	  
	  //-------------------------------------/
          //  Kolarze którzy zostali w drużynie  /   
          //-------------------------------------/
          echo 'Kolarze którzy przedłużyli kontrakty:';   
	  echo '<table class="wyscig">';
          echo '<tr><td>kolarz</td><td>data urodzenia</td></tr>';
	  $zap = " SELECT z_a_historiakol.id_kol, z_a_historiakol.id_z, z_a_historiakol.id_do, z_a_historiakol.kiedy, YEAR(z_a_historiakol.kiedy), Kolarze.imie , Kolarze.nazw, Kolarze.dataU , Nat.nazwa , Nat.flaga "
               . " FROM (z_a_historiakol INNER JOIN Kolarze ON z_a_historiakol.id_kol = Kolarze.id_kol) INNER JOIN Nat ON Kolarze.id_nat = Nat.id_nat "
	       . " WHERE z_a_historiakol.id_do = '$id_team' AND z_a_historiakol.id_z = '$id_team' AND YEAR(z_a_historiakol.kiedy) = '$id_rok' "
	       . " ORDER BY Kolarze.nazw, Kolarze.imie ";
          $idz = mysql_query($zap) or die('mysql_query');
  	  while ($dane = mysql_fetch_row($idz)) {
  	       echo '<tr><td class="wyscig7"><img src="img/flagi/'.$dane[9].'" alt='.$dane[8].'> <a href="kol.php?id_kol='.$dane[0].'">'.$dane[5].' <b>'.$dane[6].'</a></td><td>'.$dane[7].'</td></tr>
	    ';
	  }
          echo '</table>
	  
	  <br/><br/>';

	  //-------------------------------------/
          //      Kolarze którzy przychodzą      /   
          //-------------------------------------/
          echo 'Kolarze którzy przyszli:';   
	  echo '<table class="wyscig">';
          echo '<tr><td>kolarz</td><td> </td><td>data urodzenia</td><td>kiedy</td></tr>';
	  $zap = " SELECT z_a_historiakol.id_kol, z_a_historiakol.id_z, z_a_historiakol.id_do, z_a_historiakol.kiedy, YEAR(z_a_historiakol.kiedy), Kolarze.imie , Kolarze.nazw, Kolarze.dataU , Nat.nazwa , Nat.flaga "
               . " FROM (z_a_historiakol INNER JOIN Kolarze ON z_a_historiakol.id_kol = Kolarze.id_kol) INNER JOIN Nat ON Kolarze.id_nat = Nat.id_nat "
	       . " WHERE z_a_historiakol.id_do = '$id_team' AND z_a_historiakol.id_z <> '$id_team' AND YEAR(z_a_historiakol.kiedy) = '$id_rok' "
	       . " ORDER BY Kolarze.nazw, Kolarze.imie ";
          $idz = mysql_query($zap) or die('mysql_query');
  	  while ($dane = mysql_fetch_row($idz)) {
  	    $dzieńmniej = strtotime($dane[3]) - 24 * 3600;
  	    $dzieńmniej = date('Y',$dzieńmniej);
  	    $zap2 = " SELECT z_a_historiaekip.nazwa, z_a_historiaekip.id_nat, z_a_historiaekip.skr, z_a_historiaekip.dyw, Nat.flaga, Nat.nazwa, z_a_historiaekip.id_ek "
                  . " FROM z_a_historiaekip INNER JOIN Nat ON z_a_historiaekip.id_nat = Nat.id_nat"
	          . " WHERE (z_a_historiaekip.id_ek = '$dane[1]') AND (z_a_historiaekip.rok = '$dzieńmniej') ";
            $idz2 = mysql_query($zap2) or die('mysql_query');
  	    $dane2 = mysql_fetch_row($idz2);
  	    
  	    
            echo '<tr><td class="wyscig9"><img src="img/flagi/'.$dane[9].'" alt='.$dane[8].'> <a href="kol.php?id_kol='.$dane[0].'">'.$dane[5].' <b>'.$dane[6].'</a></b></td><td class="wyscig9">z  <img src="img/flagi/'.$dane2[4].'" alt="'.$dane2[5].'" /><a href="teamh.php?id_team='.$dane[1].'&rok=',$dzieńmniej+1,'">'.$dane2[0].'</a> </td><td>'.$dane[7].'</td><td>'.$dane[3].'</td></tr>
	    ';
	  }
          echo '</table>
	  
	  <br/><br/>';
	  $dzienmniej = $dane[4];
          //-------------------------------------/
          //       Kolarze którzy odchodzą       /   
          //-------------------------------------/
          echo 'Kolarze którzy odeszli:';   
	  echo '<table class="wyscig">';
          echo '<tr><td>kolarz</td><td> </td><td>data urodzenia</td><td>kiedy</td></tr>';
	  $zap = " SELECT z_a_historiakol.id_kol, z_a_historiakol.id_z, z_a_historiakol.id_do, z_a_historiakol.kiedy, YEAR(z_a_historiakol.kiedy), Kolarze.imie , Kolarze.nazw, Kolarze.dataU , Nat.nazwa , Nat.flaga "
               . " FROM (z_a_historiakol INNER JOIN Kolarze ON z_a_historiakol.id_kol = Kolarze.id_kol) INNER JOIN Nat ON Kolarze.id_nat = Nat.id_nat "
	       . " WHERE z_a_historiakol.id_do <> '$id_team' AND z_a_historiakol.id_z = '$id_team' AND YEAR(z_a_historiakol.kiedy) = '$id_rok' "
	       . " ORDER BY Kolarze.nazw, Kolarze.imie ";
          $idz = mysql_query($zap) or die('mysql_query');
  	  while ($dane = mysql_fetch_row($idz)) {
  	      IF ($czy_w_tym_roku_istniala == 0){
  	        $dzienmniej = $id_rok; }
	       else {
	       $dzienmniej = $dane[4];
              }
  	    $zap2 = " SELECT z_a_historiaekip.nazwa, z_a_historiaekip.id_nat, z_a_historiaekip.skr, z_a_historiaekip.dyw, Nat.flaga, Nat.nazwa, z_a_historiaekip.id_ek "
                  . " FROM z_a_historiaekip INNER JOIN Nat ON z_a_historiaekip.id_nat = Nat.id_nat"
	          . " WHERE (z_a_historiaekip.id_ek = '$dane[2]') AND (z_a_historiaekip.rok = '$dane[4]') ";
            $idz2 = mysql_query($zap2) or die('mysql_query');
  	    $dane2 = mysql_fetch_row($idz2);
            echo '<tr><td class="wyscig9"><img src="img/flagi/'.$dane[9].'" alt='.$dane[8].'> <a href="kol.php?id_kol='.$dane[0].'">'.$dane[5].' <b>'.$dane[6].'</a></b></td><td class="wyscig9">do  <img src="img/flagi/'.$dane2[4].'" alt="'.$dane2[5].'" />  <a href="teamh.php?id_team='.$dane[2].'&rok=',$dzienmniej,'">'.$dane2[0].'</a></td><td>'.$dane[7].'</td><td>'.$dane[3].'</td></tr>
	    ';
	  }
          echo '</table>
	  
	  <br/><br/>';
	  
	  //-------------------------------------/
          //       Kolarze niezdecydowani        /   
          //-------------------------------------/
          If ($id_rok >= date("Y"))  {
	  
	  echo 'Kolarze niezdecydowani:';   
	  echo '<table class="wyscig">';
          echo '<tr><td>kolarz</td><td>data urodzenia</td></tr>';
	  $zap = " SELECT Kolarze.id_kol, Kolarze.imie , Kolarze.nazw, Kolarze.dataU , Nat.nazwa , Nat.flaga "
	       . " FROM Kolarze INNER JOIN Nat ON Kolarze.id_nat = Nat.id_nat "
	       . " WHERE Kolarze.id_team = '$id_team' "
	       . " ORDER BY Kolarze.nazw, Kolarze.imie ";
          $idz = mysql_query($zap) or die('mysql_query');
  	  while ($dane = mysql_fetch_row($idz)) {
  	    $zap2 = " SELECT * "
                  . " FROM z_a_historiakol  "
	          . " WHERE z_a_historiakol.id_kol = '$dane[0]' AND YEAR(z_a_historiakol.kiedy) = '$id_rok' ";
            $idz2 = mysql_query($zap2) or die('mysql_query');
  	    $dane2 = mysql_num_rows($idz2);
	       
	         if ($dane2 == 0) {
		 echo '<tr><td class="wyscig7"><img src="img/flagi/'.$dane[5].'" alt='.$dane[4].'> <a href="kol.php?id_kol='.$dane[0].'">'.$dane[1].' <b>'.$dane[2].'</a></td><td>'.$dane[3].'</td></tr>
	         ';
	    }
	  }
          echo '</table>
	  
	  <br/><br/>';
          }

	  echo koniec();
        ?>
         
    


    
