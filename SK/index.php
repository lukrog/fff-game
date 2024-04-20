<?php 
  //ł±czenie się z bazą php
  session_start();
  

  $connection = @mysql_connect(getenv('DB_HOST'), getenv('DB_USER'), getenv('DB_PASS'));
  $db = @mysql_select_db(getenv('DB_NAME'), $connection)
   or die('Nie mogę połączyć się z bazą danych<br />Błąd: '.mysql_error());
  echo "<p style='font-size:5pt;'>Udało się połączyć z bazą dancych!</p>";
  mysql_query("SET NAMES 'utf8'");
  include_once('glowne.php');
  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US">
<head>
   <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
   <meta http-equiv="Content-Language" content="pl"/>
   <meta name="Author" content="Michał Myśliwiec"/>
   <link rel="stylesheet" href="style2.css" type="text/css"/>
   <title>SKARB KIBICA - <?php echo zwroc_tekst(6, $jezyk); ?></title>
 
</head>
<body>

<?php 

    poczatek();

?>

	  <div id="TRESC">
	  
	  <?php 
	  
	  
	  
	  //OSTATNIO dodane wyścigi
	     echo '<h1>'.zwroc_tekst(119, $jezyk).'</h1>
	     
	     <table class="wyscig" rulles="all">
	     ';
	     //                                     nazwa                                          klasyfikacjia UCI                                     czas
	     echo '<tr><td class="wyscig7">'.zwroc_tekst(17, $jezyk).'</td><td class="wyscig6">'.zwroc_tekst(63, $jezyk).'</td><td class="wyscig6">'.zwroc_tekst(64, $jezyk).'</td></tr>
	     ';
	  
	     
	     $sql = " SELECT Wyscigi.id_wys, MAX( Wyniki.id_wyn )
                      FROM Wyscigi INNER JOIN Wyniki ON Wyscigi.id_wys = Wyniki.id_wys
                      GROUP BY Wyscigi.id_wys
                      ORDER BY MAX( Wyniki.id_wyn ) DESC, Wyscigi.dataP DESC
                      LIMIT 0 , 15 ";
	     $idzap = mysql_query($sql) or die(mysql_error());
              


	     while ($dan = mysql_fetch_row($idzap)) {
	        
	        $sqlpyt = " SELECT Wyniki.id_wyn
                            FROM Wyniki 
                            WHERE Wyniki.id_wys = '$dan[0]'
                            ORDER BY Wyniki.id_wyn DESC
                          ";
	       $idzappyt = mysql_query($sqlpyt) or die(mysql_error());
               $czyupdate = FALSE;
               $danpyt = mysql_fetch_row($idzappyt);
               $numerek = $danpyt[0];
	       while ($danpyt = mysql_fetch_row($idzappyt)) {
	         $numerek2 = $numerek - $danpyt[0];
		 if ($numerek2 > 10) {
		   $czyupdate = TRUE;
		 }
		 $numerek = $danpyt[0];
	       }
	        
	        
	        $sql1 = "  SELECT Wyscigi.id_wys, Wyscigi.nazwa, Nat.nazwa, Nat.flaga, Wyscigi.klaUCI, DATE(Wyscigi.dataP), Wyscigi.klaUCI, Wyscigi.dataP
		           FROM Nat INNER JOIN Wyscigi ON Nat.id_nat = Wyscigi.id_nat 
			   WHERE Wyscigi.id_wys = '$dan[0]' ";
	        $idzap1 = mysql_query($sql1) or die(mysql_error());
	        $dane = mysql_fetch_row($idzap1);
	        echo '<tr><td><img src="http://fff.xon.pl/img/flagi/'.$dane[3].'" alt="'.$dane[2].'"/> <a href="wyscig.php?id_wys='.$dane[0].'">'.$dane[1].'</a>
		';
		
		if ($czyupdate == TRUE) {
		  echo ' UPDATE';
		}
		
		echo '</td><td>'.$dane[4].'</td><td>'.$dane[5].'</td></tr>
		';       
	        
	    }
	    
	    echo '</table>';
	  
	  
	    echo '<h1>'.zwroc_tekst(120, $jezyk).'</h1>
	     
	     <table class="wyscig" rulles="all">
	     ';
	     //                                     nazwa                                          klasyfikacjia UCI                                     czas
	     echo '<tr><td class="wyscig7">'.zwroc_tekst(17, $jezyk).'</td><td class="wyscig6">'.zwroc_tekst(63, $jezyk).'</td><td class="wyscig6">'.zwroc_tekst(64, $jezyk).'</td></tr>
	     ';
	  
	     $dzis = date("Y-m-d");
	     $rok = date("Y");
	     //echo $dzis.' >> '.$rok.'  ';
	     //$sql = " SELECT Wyscigi.id_wys, MAX(Wyniki.id_wyn)
             //         FROM Wyniki Right JOIN Wyscigi ON Wyscigi.id_wys = Wyniki.id_wys
             //         WHERE ((Wyscigi.dataK < '$dzis') AND (YEAR(Wyscigi.dataK) = $rok))
             //         GROUP BY Wyscigi.id_wys
             //         ORDER BY Wyscigi.dataP DESC
             //         ";
             $sql = " SELECT id_wys
	              FROM Wyscigi
		      WHERE ((Wyscigi.dataK < '$dzis') AND (YEAR(Wyscigi.dataK) = $rok) AND (pri <> 50.00))
                      ORDER BY dataK DESC";
             
             
	     $idzap = mysql_query($sql) or die(mysql_error());

	     while ($dan = mysql_fetch_row($idzap)) {
	     
	     $sqlaa = " SELECT * FROM Wyniki WHERE id_wys = '$dan[0]' ";
	     $idzapaa = mysql_query($sqlaa) or die(mysql_error());

             //echo $dan[0].' --> '.mysql_num_rows($idzapaa).'<br/>';

	     if (mysql_num_rows($idzapaa) == 0) {
	       
	        
		//if ($dan[1] == "") {
	        $sql1 = "  SELECT Wyscigi.id_wys, Wyscigi.nazwa, Nat.nazwa, Nat.flaga, Wyscigi.klaUCI, DATE(Wyscigi.dataP), Wyscigi.klaUCI, Wyscigi.dataP
		           FROM Nat INNER JOIN Wyscigi ON Nat.id_nat = Wyscigi.id_nat 
			   WHERE Wyscigi.id_wys = '$dan[0]' ";
	        $idzap1 = mysql_query($sql1) or die(mysql_error());
	        $dane = mysql_fetch_row($idzap1);
	        
	          echo '<tr><td><img src="http://fff.xon.pl/img/flagi/'.$dane[3].'" alt="'.$dane[2].'"/> <a href="wyscig.php?id_wys='.$dane[0].'">'.$dane[1].'</a> '.$dan[1].'</td><td>'.$dane[4].'</td><td>'.$dane[5].'</td></tr>
		  ';       
		//}
	      }  
	    }
	    
	    echo '</table>';
	    
	    
	    
	    //URODZINY
	     
	       echo '<h1>'.zwroc_tekst(159, $jezyk).'</h1>';
	       $miesiac_dzis = date('m');
	       $dzien_dzis = date('d');
	       
	       
	       //echo 'miesiąc = '.$miesiac_dzis.' ; dzien = '.$dzien_dzis;
	       
	        echo '<table class="wyscig" rulles="all"><tr><td class="wyscig7"></td></tr>
	     ';
	       
	       
	       //                           0             1            2               3               4           5
	       $sql_urodziny = " SELECT Kolarze.imie, Kolarze.nazw, Nat.flaga, YEAR(Kolarze.dataU), Nat.skr, Kolarze.id_kol
	                         FROM Kolarze, Nat
				 WHERE Kolarze.id_nat = Nat.id_nat AND Month(Kolarze.dataU) = '$miesiac_dzis' AND DAY(Kolarze.dataU) = '$dzien_dzis' 
				 ORDER BY Kolarze.dataU DESC";
               //echo $sql_urodziny;
	       $idz_urodziny = mysql_query($sql_urodziny) or die(mysql_error());
               while ($dan_urodziny = mysql_fetch_row($idz_urodziny)) {
                 
                 $wiek = date('Y') - $dan_urodziny[3];
                 echo '<tr><td><img src="http://fff.xon.pl/img/flagi/'.$dan_urodziny[2].'" alt="'.$dan_urodziny[5].'"/> <a href="kol.php?id_kol='.$dan_urodziny[5].'">'.$dan_urodziny[0].' <b>'.$dan_urodziny[1].'</b></a> ('.$wiek.'l),</td></tr>
		      ';
                 
                 //echo' na razie wiek = '.$dan_urodziny[3].'-><-'.date('Y').'<br/>';
	       }
	       echo '</table>';
	       
	       
	       
	     
	    
	    
	    
	    
	    
	    
	    echo zwroc_tekst(300, $jezyk)
	  ?>
	  
	  <br/> <br/>
	   
	  </div>

<?php 

    koniec();

?>       

</body>
</html>
    
