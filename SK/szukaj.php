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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US">
<head>
   <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
   <meta http-equiv="Content-Language" content="pl"/>
   <meta name="Author" content="Michał Myśliwiec"/>
   <link rel="stylesheet" href="style2.css" type="text/css"/>
   <title>SKARB KIBICA - <?php echo zwroc_tekst(12, $jezyk); ?></title>
</head>
<body>

<?php 

    poczatek();

?>

	  <div id="TRESC">
	  <?php    
         $czego=$_POST['czego'];  
         echo '<br/><br/>'.zwroc_tekst(12, $jezyk).'
	       <form action="szukaj.php" method="POST">
	         <input  class="form" type="input" name="czego" value="'.$czego.'"/>
	         <input  class="form2" type=submit value="'.zwroc_tekst(4, $jezyk).'" />
               </form>';
        
	if ($czego <> "") {   
      
      
           $sql = " SELECT Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga, Ekipy.nazwa, Kolarze.id_team
	            FROM Ekipy INNER JOIN (Nat INNER JOIN Kolarze ON Nat.id_nat = Kolarze.id_nat) ON Ekipy.id_team = Kolarze.id_team
		    WHERE ((CONCAT_WS(' ',Kolarze.imie, Kolarze.nazw) Like '%".$czego."%') OR CONCAT_WS(' ', Kolarze.nazw,Kolarze.imie) Like '%".$czego."%')
		    ORDER BY Kolarze.nazw ";
           $zap  = mysql_query($sql) or die('mysql_query');
           
             if (mysql_num_rows($zap) >= 100) {
                 echo ''.zwroc_tekst(70, $jezyk).' </br>';
	     } else {  
                echo '<table class="wyscig" rules="all">
		      <tr><td class="wyscig2">'.zwroc_tekst(32, $jezyk).'</td><td class="wyscig5">'.zwroc_tekst(23, $jezyk).'</td><td class="wyscig2">'.zwroc_tekst(56, $jezyk).'</td></tr>
		';
                while ($dane = mysql_fetch_row($zap)) {
                  echo '<tr><td><a href="kol.php?id_kol='.$dane[0].'">'.$dane[1].' '.$dane[2].'</a> </td><td> <img src="http://fff.xon.pl/img/flagi/'.$dane[3].'" /></td>
		  <td>';

		  //echo ' '.$dane[5].' ';
		  if ($dane[5] == 1000) {
                     echo zwroc_tekst(22, $jezyk);
	          } elseif ($dane[5] == 1001) {
                     echo zwroc_tekst(21, $jezyk);
	          } elseif ($dane[5] == 0) {
                     echo zwroc_tekst(57, $jezyk);
                  } else {
	             echo $dane[4];
	          }  
		  
		  echo '</td></tr>
		  ';  
                  }
                echo '</table>';  
             }   
                
        } else {
           echo '<br/><br/>';
        }   
	  ?>
	   
	   
	   </div>

<?php 

    koniec();

?>       

</body>
</html>
    
