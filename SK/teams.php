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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US">
<head>
   <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
   <meta http-equiv="Content-Language" content="pl"/>
   <meta name="Author" content="Michał Myśliwiec"/>
   <link rel="stylesheet" href="style2.css" type="text/css"/>
   <title>SKARB KIBICA - <?php echo zwroc_tekst(9, $jezyk); ?></title>
</head>
<body>

<?php 

    poczatek();

?>
<div id="TRESC">

<?php  
echo '<h3>'.zwroc_tekst(16, $jezyk).' PRO TOUR</h3>';
	  $li = 'PT';
	  //$pocz = 1000 * (date("Y") - 2000);
	  //$kon = 1000 * (date("Y") + 1 - 2000);
	  
	  //$sql = " SELECT Ekipy.id_team, Ekipy.nazwa, Ekipy.skr, Nat.nazwa, Nat.flaga "
          //     . " FROM Kolarze INNER JOIN (Nat INNER JOIN Ekipy ON Nat.id_nat = Ekipy.id_kraj) ON Kolarze.id_team = Ekipy.id_team "
	  //     . " WHERE Ekipy.liga='$li' "
	  //     . " GROUP BY Ekipy.id_team, Ekipy.nazwa, Ekipy.skr, Nat.nazwa, Nat.flaga "
          //     . " ORDER BY Ekipy.nazwa ";
               
          $sql = " SELECT Ekipy.id_team, Ekipy.nazwa, Ekipy.skr, Nat.nazwa, Nat.flaga
	           FROM Kolarze, Nat, Ekipy
		   WHERE Ekipy.liga='$li' AND Kolarze.id_team = Ekipy.id_team AND Nat.id_nat = Ekipy.id_kraj
		   GROUP BY Ekipy.id_team
		   ORDER BY Ekipy.nazwa ";     
               
          $idzapytania = mysql_query($sql) or die(mysql_error());
          echo '<table class="wyscig" rules="all">';
          echo '<tr><td class="wyscig7">'.zwroc_tekst(17, $jezyk).'</td><td class="wyscig5">'.zwroc_tekst(18, $jezyk).'</td><td class="wyscig6">'.zwroc_tekst(19, $jezyk).'</td></tr>';
	  while ($dane = mysql_fetch_row($idzapytania)) {
	    $sqlaa = " SELECT Count(id_kol) FROM Kolarze WHERE id_team = '$dane[0]' ";
	    $zapaa = mysql_query($sqlaa) or die(mysql_error());
	    $daneaa = mysql_fetch_row($zapaa);
            echo '<tr><td><img src="http://fff.xon.pl/img/flagi/'.$dane[4].'" alt="'.$dane[3].'"/> <a href="team.php?id_team='.$dane[0].'">'.$dane[1].'</a></td><td>'.$dane[2].'</td><td>'.$daneaa[0].'</td></tr>';
          }  
          echo '</table><br/><br/>';
	  
	  $li = 'PR';
	  echo '<h3>'.zwroc_tekst(16, $jezyk).' PROFFESIONAL</h3>';
	  //$sql = " SELECT Ekipy.id_team, Ekipy.nazwa, Ekipy.skr, Nat.nazwa, Nat.flaga "
          //     . " FROM Kolarze INNER JOIN (Nat INNER JOIN Ekipy ON Nat.id_nat = Ekipy.id_kraj) ON Kolarze.id_team = Ekipy.id_team "
	  //     . " WHERE Ekipy.liga='$li' "
	  //     . " GROUP BY Ekipy.id_team, Ekipy.nazwa, Ekipy.skr, Nat.nazwa, Nat.flaga "
          //     . " ORDER BY Ekipy.nazwa ";
               
          $sql = " SELECT Ekipy.id_team, Ekipy.nazwa, Ekipy.skr, Nat.nazwa, Nat.flaga
	           FROM Kolarze, Nat, Ekipy
		   WHERE Ekipy.liga='$li' AND Kolarze.id_team = Ekipy.id_team AND Nat.id_nat = Ekipy.id_kraj
		   GROUP BY Ekipy.id_team
		   ORDER BY Ekipy.nazwa ";         

          $idzapytania = mysql_query($sql) or die(mysql_error());
          echo '<table class="wyscig" rules="all">';
          echo '<tr><td class="wyscig7">'.zwroc_tekst(17, $jezyk).'</td><td class="wyscig5">'.zwroc_tekst(18, $jezyk).'</td><td class="wyscig6">'.zwroc_tekst(19, $jezyk).'</td></tr>';while ($dane = mysql_fetch_row($idzapytania)) {
	    $sqlaa = " SELECT Count(id_kol) FROM Kolarze WHERE id_team = '$dane[0]' ";
	    $zapaa = mysql_query($sqlaa) or die(mysql_error());
	    $daneaa = mysql_fetch_row($zapaa);
            echo '<tr><td><img src="http://fff.xon.pl/img/flagi/'.$dane[4].'" alt="'.$dane[3].'"/> <a href="team.php?id_team='.$dane[0].'">'.$dane[1].'</a></td><td>'.$dane[2].'</td><td>'.$daneaa[0].'</td></tr>';
          }  
          echo '</table><br/><br/>';
          
          $li = 'CT';
	  echo '<h3>'.zwroc_tekst(16, $jezyk).' CONTINENTAL</h3>';
	  //$sql = " SELECT Ekipy.id_team, Ekipy.nazwa, Ekipy.skr, Nat.nazwa, Nat.flaga "
          //     . " FROM Kolarze INNER JOIN (Nat INNER JOIN Ekipy ON Nat.id_nat = Ekipy.id_kraj) ON Kolarze.id_team = Ekipy.id_team "
	  //     . " WHERE Ekipy.liga='$li' "
	  //     . " GROUP BY Ekipy.id_team, Ekipy.nazwa, Ekipy.skr, Nat.nazwa, Nat.flaga "
          //     . " ORDER BY Ekipy.nazwa ";
          
          
          $sql = " SELECT Ekipy.id_team, Ekipy.nazwa, Ekipy.skr, Nat.nazwa, Nat.flaga
	           FROM Kolarze, Nat, Ekipy
		   WHERE Ekipy.liga='$li' AND Kolarze.id_team = Ekipy.id_team AND Nat.id_nat = Ekipy.id_kraj
		   GROUP BY Ekipy.id_team
		   ORDER BY Ekipy.nazwa ";    

          $idzapytania = mysql_query($sql) or die(mysql_error());
          echo '<table class="wyscig" rules="all">';
          echo '<tr><td class="wyscig7">'.zwroc_tekst(17, $jezyk).'</td><td class="wyscig5">'.zwroc_tekst(18, $jezyk).'</td><td class="wyscig6">'.zwroc_tekst(19, $jezyk).'</td></tr>';while ($dane = mysql_fetch_row($idzapytania)) {
	    if ($dane[0] == 0) {} else {
	      $sqlaa = " SELECT Count(id_kol) FROM Kolarze WHERE id_team = '$dane[0]' ";
	      $zapaa = mysql_query($sqlaa) or die(mysql_error());
	      $daneaa = mysql_fetch_row($zapaa);
              echo '<tr><td><img src="http://fff.xon.pl/img/flagi/'.$dane[4].'" alt="'.$dane[3].'"/> <a href="team.php?id_team='.$dane[0].'">'.$dane[1].'</a></td><td>'.$dane[2].'</td><td>'.$daneaa[0].'</td></tr>';
            }
          }  
          echo '</table><br/><br/>';
          
          
          $li = 'AM';
	  echo '<h3>'.zwroc_tekst(20, $jezyk).'</h3>';
	  //$sql = " SELECT Ekipy.id_team, Ekipy.nazwa, Ekipy.skr, Nat.nazwa, Nat.flaga "
          //     . " FROM Kolarze INNER JOIN (Nat INNER JOIN Ekipy ON Nat.id_nat = Ekipy.id_kraj) ON Kolarze.id_team = Ekipy.id_team "
	  //     . " WHERE Ekipy.liga='$li' "
	  //     . " GROUP BY Ekipy.id_team, Ekipy.nazwa, Ekipy.skr, Nat.nazwa, Nat.flaga "
          //     . " ORDER BY Ekipy.nazwa ";
          
	  $sql = " SELECT Ekipy.id_team, Ekipy.nazwa, Ekipy.skr, Nat.nazwa, Nat.flaga
	           FROM Kolarze, Nat, Ekipy
		   WHERE Ekipy.liga='$li' AND Kolarze.id_team = Ekipy.id_team AND Nat.id_nat = Ekipy.id_kraj
		   GROUP BY Ekipy.id_team
		   ORDER BY Ekipy.nazwa ";         
	  
          $idzapytania = mysql_query($sql) or die(mysql_error());
          echo '<table class="wyscig" rules="all">';
          echo '<tr><td class="wyscig7">'.zwroc_tekst(17, $jezyk).'</td><td class="wyscig5">'.zwroc_tekst(18, $jezyk).'</td><td class="wyscig6">'.zwroc_tekst(19, $jezyk).'</td></tr>';while ($dane = mysql_fetch_row($idzapytania)) {
	    if ($dane[0] == 0) {} else {
	      $sqlaa = " SELECT Count(id_kol) FROM Kolarze WHERE id_team = '$dane[0]' ";
	      $zapaa = mysql_query($sqlaa) or die(mysql_error());
	      $daneaa = mysql_fetch_row($zapaa);
              echo '<tr><td><img src="http://fff.xon.pl/img/flagi/'.$dane[4].'" alt="'.$dane[3].'"/> <a href="team.php?id_team='.$dane[0].'">';
	       if ($dane[0] == 1000) {
                  echo zwroc_tekst(22, $jezyk);
	       } elseif ($dane[0] == 1001) {
                  echo zwroc_tekst(21, $jezyk);
	       } else {
	          echo $dane[1];
	       }  
	      echo '</a></td><td>'.$dane[2].'</td><td>'.$daneaa[0].'</td></tr>';
            }
          }  
          echo '</table><br/><br/>
	  
	  ';
   
?>

</div>
<?php 

    koniec();

?>       

</body>
</html>
    
