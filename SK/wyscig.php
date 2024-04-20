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
   <title>SKARB KIBICA - <?php echo zwroc_tekst(118, $jezyk); ?></title>
</head>
<body>

<?php 

    poczatek();

?>

	  <div id="TRESC"><br/>
	  <?php    
          $id_wys = $_GET['id_wys'];
	  //$zap = " SELECT Wyscigi.id_wys, Wyscigi.nazwa, Nat.id_nat, z_z_tlumacz_nat.".$jezyk.", Nat.flaga, Wyscigi.klaUCI, Wyscigi.klaPC, Wyscigi.startowe, Wyscigi.ilu_kol, Wyscigi.pri, DATE(Wyscigi.dataP), Wyscigi.dataK, TIME(Wyscigi.dataP), Wyscigi.dataP, YEAR(Wyscigi.dataP)  
	  //         FROM z_z_tlumacz_nat INNER JOIN (Wyscigi INNER JOIN Nat ON Wyscigi.id_nat = Nat.id_nat) ON Nat.id_nat = z_z_tlumacz_nat.id_nat 
	  //         WHERE (((Wyscigi.id_wys)= '$id_wys' )) ";
	           
	  $zap = " SELECT Wyscigi.id_wys, Wyscigi.nazwa, Nat.id_nat, z_z_tlumacz_nat.".$jezyk.", Nat.flaga, Wyscigi.klaUCI, Wyscigi.klaPC, Wyscigi.startowe, Wyscigi.ilu_kol, Wyscigi.pri, DATE(Wyscigi.dataP), Wyscigi.dataK, TIME(Wyscigi.dataP), Wyscigi.dataP, YEAR(Wyscigi.dataP)  
	           FROM z_z_tlumacz_nat, Wyscigi, Nat  
	           WHERE Wyscigi.id_wys= '$id_wys' AND Wyscigi.id_nat = Nat.id_nat AND Nat.id_nat = z_z_tlumacz_nat.id_nat
		   ";         
	           
	  $idz = mysql_query($zap) or die('mysql_query');
  	  $dane = mysql_fetch_row($idz);
  	  
  	  echo '<h1>'.$dane[1].'</h1>';
  	  
	  echo '<table class="wyscig" rules="all">
	  <tr><td><i>'.zwroc_tekst(23, $jezyk).': </i></td><td>'.$dane[3].' <img src="http://fff.xon.pl/img/flagi/'.$dane[4].'" alt="'.$dane[3].'"/></td></tr>
          <tr><td><i>'.zwroc_tekst(63, $jezyk).': </i></td><td>'.$dane[5].'</td></tr>
	  <!-- <tr><td><i>klasyfikacja P-C: </i></td><td>'.$dane[6].'</td></tr> -->
	  <tr><td><i>'.zwroc_tekst(64, $jezyk).': </i></td><td>'.$dane[10].'</td></tr>
	  <tr><td><i>'.zwroc_tekst(65, $jezyk).': </i></td><td>'.$dane[11].'</td></tr>
	  </table>
	  '; 
	  $czas_wyscigu = $dane[10];
	  
	  $sqlka = " SELECT id_hiswys 
	             FROM z_a_historiawyscig
		     WHERE id_wys = '$id_wys' ";
	  $idzka = mysql_query($sqlka) or die('mysql_query');
  	  $danka = mysql_fetch_row($idzka);
  	  
  	  
  	  
	  echo '<i><a href="wyscighis.php?id_hiswys='.$danka[0].'">'.zwroc_tekst(157, $jezyk).'</a></i>
	  
	  <br/><br/><br/>
	  
	  <table class="wysciga" rules="all">
	  <tr><td class="wyscig10"> </td><td class="wyscig8"> </td><td class="wyscig6">'.zwroc_tekst(121, $jezyk).'</td><td class="wyscig3">'.zwroc_tekst(122, $jezyk).'</td><td class="wyscig4">'.zwroc_tekst(124, $jezyk).'</td></tr>
	  ';
          
          $rok_wyscigu = $dane[14];
          
          $zapy = "SELECT Co.id_co, Co.nazwa_pełna FROM Co ORDER BY Co.id_co";
	  $idzz = mysql_query($zapy) or die('mysql_query');
  	  while ($da = mysql_fetch_row($idzz)) {
  	    if ($da[0] <> 10) {
  	    
            $teraz_omawiane = $da[0];
            
            //echo $dane[14].' OOOooooOOO '.date('Y');
	         
	    if ($rok_wyscigu == date('Y')) {        
              //$zap = " SELECT Wyniki.id_wyn, Wyniki.miejsce, Kolarze.imie, Kolarze.nazw, Nat.nazwa , Nat.flaga , Ekipy.nazwa , Ekipy.nazwa, Kolarze.id_team, Kolarze.id_nat, Kolarze.id_kol, Wyniki.punkty, Ekipy.nazwa, Wyniki.wynik 
	      //         FROM Ekipy INNER JOIN (Nat INNER JOIN (Kolarze INNER JOIN Wyniki ON Kolarze.id_kol = Wyniki.id_kol) ON Nat.id_nat = Kolarze.id_nat) ON Ekipy.id_team = Kolarze.id_team 
	      //        WHERE ((((Wyniki.id_co) = '$teraz_omawiane' )) AND (((Wyniki.id_wys)= '$id_wys' )))
	      //        ORDER BY Wyniki.miejsce, Wyniki.wynik ";
	      
	      $zap = " SELECT Co.id_co, Wyniki.id_wys
	               FROM Co, Wyniki
		       WHERE Wyniki.id_wys = '$id_wys' AND Wyniki.id_co = '$teraz_omawiane' AND Co.id_co = Wyniki.id_co
		       ";
		       
	      	       
		       
	      $zap_opi = " SELECT Kolarze.imie, Kolarze.nazw, Kolarze.id_kol, Wyniki.miejsce
                           FROM Kolarze, Wyniki 
                           WHERE Wyniki.id_wys = '$id_wys' AND Wyniki.id_co = '$teraz_omawiane' AND Kolarze.id_kol = Wyniki.id_kol
			   ORDER BY Wyniki.miejsce
                           LIMIT 0 , 1";     
	      //echo $zap_opi.' ;>>>>///  ';
            } else {
              //$zap = " SELECT WynikiP.id_wyn, WynikiP.miejsce, Kolarze.imie, Kolarze.nazw, Nat.nazwa , Nat.flaga , Ekipy.nazwa , Ekipy.nazwa, Kolarze.id_team, Kolarze.id_nat, Kolarze.id_kol, WynikiP.punkty, Ekipy.nazwa, WynikiP.wynik 
              //        FROM Ekipy INNER JOIN (Nat INNER JOIN (Kolarze INNER JOIN WynikiP ON Kolarze.id_kol = WynikiP.id_kol) ON Nat.id_nat = Kolarze.id_nat) ON Ekipy.id_team = Kolarze.id_team 
	      //        WHERE ((((WynikiP.id_co) = '$teraz_omawiane' )) AND (((WynikiP.id_wys)= '$id_wys' )))
	      //        ORDER BY WynikiP.miejsce, WynikiP.wynik ";      
	      $zap = " SELECT Co.id_co, WynikiP.id_wys
	               FROM Co, WynikiP 
		       WHERE WynikiP.id_wys = '$id_wys' AND WynikiP.id_co = '$teraz_omawiane' AND Co.id_co = WynikiP.id_co
		       ";
		       
		       
              //$zap_opi = " SELECT Kolarze.imie, Kolarze.nazw, Kolarze.id_kol, WynikiP.miejsce 
	      //             FROM Kolarze INNER JOIN WynikiP ON Kolarze.id_kol = WynikiP.id_kol
	//	           WHERE ((WynikiP.id_wys = '$id_wys') AND (WynikiP.id_co = '$teraz_omawiane')) 
	//		   ORDER BY WynikiP.miejsce
	//		   LIMIT 0, 1";
			   
	      $zap_opi = " SELECT Kolarze.imie, Kolarze.nazw, Kolarze.id_kol, WynikiP.miejsce 
	                   FROM Kolarze, WynikiP 
		           WHERE WynikiP.id_wys = '$id_wys' AND WynikiP.id_co = '$teraz_omawiane' AND Kolarze.id_kol = WynikiP.id_kol
			   ORDER BY WynikiP.miejsce
			   LIMIT 0, 1";		   
            }
            
            //echo $zap.' zapytanie 81 <br/><br/>';
	     // echo $zap_opi.' zapytanie 84 <br/><br/>';
            
	    $idz_opi = mysql_query($zap_opi) or die('mysql_query');	 
	    $dan_opi = mysql_fetch_row($idz_opi);	 
	
	    //echo 'przerwa <br/><Br/>';
		 
	    $idz = mysql_query($zap) or die('mysql_query');
	    $num_rows = mysql_num_rows($idz); 

            if ($num_rows > 0) {
                $zapty = " SELECT z_EtapyKat.data, z_Kategorie.kategoria, z_Kategorie2.skrot, z_Kategorie.jpg 
		           FROM z_Kategorie AS z_Kategorie2, z_EtapyKat, z_Kategorie 
		           WHERE z_EtapyKat.id_wys = '$id_wys' AND id_co = '$teraz_omawiane' AND z_EtapyKat.id_kat = z_Kategorie.id_kat AND z_EtapyKat.id_kat2 = z_Kategorie2.id_kat  ";
		
		//echo $zapty.'  /// <br/><br/>';           
		           
                $idzty = mysql_query($zapty) or die('mysql_query');
                //echo 'test'.mysql_num_rows($idzty).'  ';
                if (mysql_num_rows($idzty) == 0) {
	        //echo 'owanie   <br/>';
                echo '<a name="'.$teraz_omawiane.'"/>
	        ';
	        $zmiannapomocnicza = $teraz_omawiane + 20000;
	        echo ' <tr><td><a href="wyjskr.php" style="color: #ffffff;"><img src="graf/typetapu/brak.jpg" style="width: 18px; height: 18px;" /></a></td><td>
		<a href="wyscigetap.php?id_wys='.$id_wys.'&id_co='.$teraz_omawiane.'">'.zwroc_tekst($zmiannapomocnicza, $jezyk).'</a>
		</td><td></td><td>'.$num_rows.'
		</td><td>';
	        if ($dan_opi[3] > 1) {echo $dan_opi[3].' ';}
		
		
		echo '<a href="kol.php?id_kol='.$dan_opi[2].'">'.$dan_opi[0].' <b>'.$dan_opi[1].'</b></a></td></tr>
	        ';
	        } else {
              
                $danety = mysql_fetch_row($idzty);
                echo '<a name="'.$teraz_omawiane.'"/>
	        ';
	        $zmiannapomocnicza = $teraz_omawiane + 20000;
	        echo '<tr><td><a href="wyjskr.php" style="color: #ffffff;"><img src="graf/typetapu/'.$danety[3].'" style="width: 18px; height: 18px;" /></a></td><td>
		<a href="wyscigetap.php?id_wys='.$id_wys.'&id_co='.$teraz_omawiane.'">'.zwroc_tekst($zmiannapomocnicza, $jezyk).'</a>
		</td><td>'.$danety[0].'</td><td>'.$num_rows.'
		</td><td>';
		
		if ($dan_opi[3] > 1) {echo $dan_opi[3].' ';}
		
		echo '<a href="kol.php?id_kol='.$dan_opi[2].'">'.$dan_opi[0].' <b>'.$dan_opi[1].'</b></a></td></tr>
		';
	       
	       
	       }
	        
	      } else {
                
	      }
	      
	      
	      
              
            }

            
            }
          echo '</table>';
	     
	     
	       
	  ?>
	   <br/> <br/>
	   
	   </div>

<?php 

    koniec();

?>       

</body>
</html>
    
