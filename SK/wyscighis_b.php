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
	  $czysaetapy = false;
          $id_hiswys = $_GET['id_hiswys'];
          
          //echo $id_hiswys;
          
          $zaphis = " SELECT id_wys  
	              FROM z_a_historiawyscig
                      WHERE (((id_hiswys)= '$id_hiswys' ))
		      ORDER BY id_wys DESC ";
	  $idzhis = mysql_query($zaphis) or die('mysql_query');
  	  $danehis = mysql_fetch_row($idzhis);
  	  
  	  $zap = " SELECT Wyscigi.nazwa
	           FROM Wyscigi 
	           WHERE (Wyscigi.id_wys)= '$danehis[0]' ";
	  $idz = mysql_query($zap) or die('mysql_query');
  	  $dane = mysql_fetch_row($idz);
  	  
  	  //echo ''.$zaphis.'<br/><br/>'.$zap.'<br/><br/><br/>';
  	  
  	  echo '<h1>'.$dane[0].'</h1>
	    <table  class="wyscig" rules="all">
	    <tr><td class="wyscig1">ROK</td><td class="wyscig2">Nazwa</td><td class="wyscig1">Klas</td><td class="wyscig9">info</td></tr>
  	      
	    ';
          
          
	  $zaphis = " SELECT id_wys, info 
	              FROM z_a_historiawyscig
                      WHERE id_hiswys= '$id_hiswys'
		      ORDER BY id_wys DESC ";
	  $idzhis = mysql_query($zaphis) or die('mysql_query');
  	  while ($danehis = mysql_fetch_row($idzhis)) {
	      // tu się pojawi wyświetlanie poszczególnych lat.
	      //$zap = " SELECT Wyscigi.id_wys, Wyscigi.nazwa, Nat.id_nat, z_z_tlumacz_nat.".$jezyk.", Nat.flaga, Wyscigi.klaUCI, Wyscigi.klaPC, Wyscigi.startowe, Wyscigi.ilu_kol, Wyscigi.pri, DATE(Wyscigi.dataP), Wyscigi.dataK, TIME(Wyscigi.dataP), Wyscigi.dataP, YEAR(Wyscigi.dataP)  
	      //         FROM z_z_tlumacz_nat INNER JOIN (Wyscigi INNER JOIN Nat ON Wyscigi.id_nat = Nat.id_nat) ON Nat.id_nat = z_z_tlumacz_nat.id_nat 
	      //         WHERE (((Wyscigi.id_wys)= '$danehis[0]' )) ";
	               
	      $zap = " SELECT Wyscigi.id_wys, Wyscigi.nazwa, Nat.id_nat, z_z_tlumacz_nat.".$jezyk.", Nat.flaga, Wyscigi.klaUCI, Wyscigi.klaPC, Wyscigi.startowe, Wyscigi.ilu_kol, Wyscigi.pri, DATE(Wyscigi.dataP), Wyscigi.dataK, TIME(Wyscigi.dataP), Wyscigi.dataP, YEAR(Wyscigi.dataP)  
	               FROM z_z_tlumacz_nat, Wyscigi, Nat
	               WHERE Wyscigi.id_wys= '$danehis[0]' AND Wyscigi.id_nat = Nat.id_nat AND Nat.id_nat = z_z_tlumacz_nat.id_nat 
		       ";         
	               
	      $idz = mysql_query($zap) or die('mysql_query');
  	      $dane = mysql_fetch_row($idz);
  	      
  	      echo '<tr><td class="wyscig1">'.$dane[14].'</td><td class="wyscig2"><a href="wyscig.php?id_wys='.$danehis[0].'">'.$dane[1].'</a></td><td class="wyscig1">'.$dane[5].'</td><td class="wyscig9">'.$danehis[1].'</td></tr>';
  	      
  	      
  	      $poi = "SELECT id_co FROM Wyniki WHERE (id_co > 20 AND id_wys = '$danehis[0]')";
	  $poiu = mysql_query($poi) or die('mysql_query');
	  $poik = mysql_num_rows($poiu);
	  if ($poik > 0) {$czysaetapy=true;}
          $poi = "SELECT id_co FROM WynikiP WHERE (id_co > 20 AND id_wys = '$danehis[0]')";
	  $poiu = mysql_query($poi) or die('mysql_query');
	  $poik = mysql_num_rows($poiu);
	  if ($poik > 0) {$czysaetapy=true;}
  	      
	  }
          
          echo '</table><br/><br/>
	  ';
	  
	  
	  
	  
	  

	  
          echo ' <table  class="wyscig" rules="all">
	    <tr><td class="wyscig1">ROK</td><td class="wyscig8">Zwycięzca</td><td class="wyscig8">2 miejsce</td><td class="wyscig8">3 miejsce</td></tr>
  	      
	    ';
          
	  $zaphis = " SELECT id_wys, info 
	              FROM z_a_historiawyscig
                      WHERE (((id_hiswys)= '$id_hiswys' ))
		      ORDER BY id_wys DESC ";
	  $idzhis = mysql_query($zaphis) or die('mysql_query');
	  
	  //echo $zaphis;
	  
	  
	    
  	  
  	  while ($danehis = mysql_fetch_row($idzhis)) {
	      // tu się pojawią miejca z poszczególnych lat.
	      $roktrwania = ($danehis[0] / 1000) + 2000;
	      $roktrwania = (int)$roktrwania;
	      //echo $roktrwania;
	      
	      
	      if ($roktrwania == date('Y')) {        
              
	      $zapmie = " SELECT id_wys, miejsce, id_kol
	                  FROM Wyniki 
		          WHERE ((id_wys = '$danehis[0]') AND (id_co = 0))
		          ORDER BY miejsce 
		          LIMIT 0 , 3";

            } else {
           
	      $zapmie = " SELECT id_wys, miejsce, id_kol
	                  FROM WynikiP 
		          WHERE ((id_wys = '$danehis[0]') AND (id_co = 0))
		          ORDER BY miejsce 
		          LIMIT 0 , 3";
		       
            }
	    //echo $zapmie.'  <br/><br/>';  
	    $idzmie = mysql_query($zapmie) or die('mysql_query');
  	    $danemie = mysql_fetch_row($idzmie);
  	    
	    //$zap_opi = " SELECT Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga  
	    //             FROM Nat INNER JOIN Kolarze On Nat.id_nat = Kolarze.id_nat
	    //             WHERE Kolarze.id_kol= '$danemie[2]' ";      
            
            $zap_opi = " SELECT Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga  
	                 FROM Nat, Kolarze
	                 WHERE Kolarze.id_kol= '$danemie[2]' AND Nat.id_nat = Kolarze.id_nat "; 
            
	    $idz_opi = mysql_query($zap_opi) or die('mysql_query');
  	    $dane_opi = mysql_fetch_row($idz_opi);
	      //echo $zap_opi;		   	      
  	     	      
  	    echo '<tr><td class="wyscig1"><a href="wyscig.php?id_wys='.$danehis[0].'">'.(int)$roktrwania.'</a></td><td class="wyscig8"><img src="http://fff.xon.pl/img/flagi/'.$dane_opi[3].'" alt=""/> <a href="kol.php?id_kol='.$danemie[2].'">'.$dane_opi[1].' <b>'.$dane_opi[2].'</b></td><td class="wyscig8">';
  	    
	      
	    $danemie = mysql_fetch_row($idzmie);  
	    
	    $zap_opi = " SELECT Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga  
	                 FROM Nat, Kolarze 
	                 WHERE Kolarze.id_kol= '$danemie[2]' AND Nat.id_nat = Kolarze.id_nat "; 
			 
			      
	    $idz_opi = mysql_query($zap_opi) or die('mysql_query');
  	    $dane_opi = mysql_fetch_row($idz_opi);
	      //echo $zap_opi;		   	      
  	     	      
  	    echo '<img src="http://fff.xon.pl/img/flagi/'.$dane_opi[3].'" alt=""/> <a href="kol.php?id_kol='.$danemie[2].'">'.$dane_opi[1].' <b>'.$dane_opi[2].'</b></td><td class="wyscig8">';
  	    
	    
	       
	    $danemie = mysql_fetch_row($idzmie);
	    
	    $zap_opi = " SELECT Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Nat.flaga  
	                 FROM Nat, Kolarze
	                 WHERE Kolarze.id_kol= '$danemie[2]' AND Nat.id_nat = Kolarze.id_nat "; 
			 
			      
	    $idz_opi = mysql_query($zap_opi) or die('mysql_query');
  	    $dane_opi = mysql_fetch_row($idz_opi);
	      //echo $zap_opi;		   	      
  	     	      
  	    echo '<img src="http://fff.xon.pl/img/flagi/'.$dane_opi[3].'" alt=""/> <a href="kol.php?id_kol='.$danemie[2].'">'.$dane_opi[1].' <b>'.$dane_opi[2].'</b></td></tr>';
  	    
	  }
          
          echo '</table>
	  <br/><br/>';
          
          
          if ($czysaetapy) {
          //----------------------------------------------------------
          //Czas na statystyki na początek najwięcej wygranych etapów:
          //----------------------------------------------------------
          
          $sql="TRUNCATE TABLE z_a_historiawyscigTEMP";
          $idz = mysql_query($sql) or die('mysql_query');
          //$zapmie = " SELECT id_kol, Count(miejsce)
          //            FROM WynikiP INNER JOIN z_a_historiawyscig ON WynikiP.id_wys=z_a_historiawyscig.id_wys
          //            WHERE z_a_historiawyscig.id_hiswys='$id_hiswys' AND WynikiP.miejsce=1 AND WynikiP.id_co>20
          //            GROUP BY id_kol";
                      
          $zapmie = " SELECT id_kol, Count(miejsce)
                      FROM WynikiP, z_a_historiawyscig
                      WHERE z_a_historiawyscig.id_hiswys='$id_hiswys' AND WynikiP.miejsce=1 AND WynikiP.id_co>20 AND WynikiP.id_wys=z_a_historiawyscig.id_wys
                      GROUP BY id_kol";            
                      
          $idzmie = mysql_query($zapmie) or die('mysql_query');
          while ($danemie = mysql_fetch_row($idzmie)) 
	  {
	    $sql1="INSERT INTO z_a_historiawyscigTEMP (id_kol, ile) VALUES ('$danemie[0]', '$danemie[1]')";
	    $idzsql1 = mysql_query($sql1) or die('mysql_query');
	  }
          
          //$zapmie = " SELECT id_kol, Count(miejsce)
          //            FROM Wyniki INNER JOIN z_a_historiawyscig ON Wyniki.id_wys=z_a_historiawyscig.id_wys
          //            WHERE z_a_historiawyscig.id_hiswys='$id_hiswys' AND Wyniki.miejsce=1 AND Wyniki.id_co>20
          //            GROUP BY id_kol";
          
          $zapmie = " SELECT id_kol, Count(miejsce)
                      FROM Wyniki, z_a_historiawyscig
                      WHERE z_a_historiawyscig.id_hiswys='$id_hiswys' AND Wyniki.miejsce=1 AND Wyniki.id_co>20 AND Wyniki.id_wys=z_a_historiawyscig.id_wys
                      GROUP BY id_kol";
                      
          $idzmie = mysql_query($zapmie) or die('mysql_query');
          while ($danemie = mysql_fetch_row($idzmie)) 
	  {
	    $sql1="INSERT INTO z_a_historiawyscigTEMP (id_kol, ile) VALUES ('$danemie[0]', '$danemie[1]')";
	    $idzsql1 = mysql_query($sql1) or die('mysql_query');
	  }
          
          
          
          //$zapmie = " SELECT Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Sum(ile), Nat.flaga, Nat.skr, Nat.id_nat
          //            FROM Nat INNER JOIN (Kolarze INNER JOIN z_a_historiawyscigTEMP ON Kolarze.id_kol=z_a_historiawyscigTEMP.id_kol) ON Nat.id_nat = Kolarze.id_nat
          //            GROUP BY id_kol
          //            ORDER BY Sum(ile) DESC
	  //	      ";
          
          $zapmie = " SELECT Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Sum(ile), Nat.flaga, Nat.skr, Nat.id_nat
                      FROM Nat, Kolarze, z_a_historiawyscigTEMP 
                      GROUP BY id_kol, Kolarze.id_kol=z_a_historiawyscigTEMP.id_kol, Nat.id_nat = Kolarze.id_nat
                      ORDER BY Sum(ile) DESC
	  	      ";
	  
          $idzmie = mysql_query($zapmie) or die('mysql_query');
          echo '<h2>Najwięcej zwycięstw etapwych</h2>
	  <table class="wyscig" rules="all">
	  <tr><th class="wyscig1">lp</th><th class="wyscig7">kolarz</th><th class="wyscig6">ile razy</th><tr>';
	  $lp=1;
	  $lp2=1;
	  $poprzednio=0;
	  $niebylykropki=true;
          while ($danemie = mysql_fetch_row($idzmie)) 
	  {
	    //tu pojawia się tabela najlepszych.
	    //echo '<tr><td class="wyscig1">';
	    if ($poprzednio <> $danemie[3])
	    { 
	      $lp2=$lp;
	      if (($lp2 > 10) and $niebylykropki)
	      {
	        echo '<tr><td class="wyscig1">...</td><td class="wyscig7">...</td><td class="wyscig6">...</td></tr>';
	        $niebylykropki = false;
	      }
	      
	      if  (($lp2 < 11) OR ($danemie[6] == 52))
	      {
	        echo '<tr><td class="wyscig1">'.$lp.'</td><td class="wyscig7"><img src="http://fff.xon.pl/img/flagi/'.$danemie[4].'" alt="'.$danemie[5].'" /> <a href="kol.php?id_kol='.$danemie[0].'">'.$danemie[1].' <b>'.$danemie[2].'</b></a></td><td class="wyscig6">'.$danemie[3].'</td><tr>';
	      }
	    } else 
	    {
	      if  (($lp2 < 11) OR ($danemie[6] == 52)) 
	      {
	        echo '<tr><td class="wyscig1"></td><td class="wyscig7"><img src="http://fff.xon.pl/img/flagi/'.$danemie[4].'" alt="'.$danemie[5].'" /> <a href="kol.php?id_kol='.$danemie[0].'">'.$danemie[1].' <b>'.$danemie[2].'</b></a></td><td class="wyscig6">'.$danemie[3].'</td><tr>';
	      }
	      //echo $lp2;
	    }
	    //if ($lp2 <11) {
	    //  echo '</td><td class="wyscig7"><img src="http://fff.xon.pl/img/flagi/'.$danemie[4].'" alt="'.$danemie[5].'" /> <a href="kol.php?id_kol='.$danemie[0].'">'.$danemie[1].' <b>'.$danemie[2].'</b></a></td><td class="wyscig6">'.$danemie[3].'</td><tr>';
	    //}
	    $lp=$lp+1;
	    $poprzednio = $danemie[3];
	    
	  }
	  echo '</table>';   
          }
          
          if ($czysaetapy) {
          //----------------------------------------------------------
          //Czas na statystyki    najwięcej miejsc na podium:
          //----------------------------------------------------------
          
          $sql="TRUNCATE TABLE z_a_historiawyscigTEMP";
          $idz = mysql_query($sql) or die('mysql_query');
          $zapmie = " SELECT id_kol, Count(miejsce)
                      FROM WynikiP INNER JOIN z_a_historiawyscig ON WynikiP.id_wys=z_a_historiawyscig.id_wys
                      WHERE z_a_historiawyscig.id_hiswys='$id_hiswys' AND WynikiP.miejsce<4 AND WynikiP.id_co>20
                      GROUP BY id_kol";
          $idzmie = mysql_query($zapmie) or die('mysql_query');
          while ($danemie = mysql_fetch_row($idzmie)) 
	  {
	    $sql1="INSERT INTO z_a_historiawyscigTEMP (id_kol, ile) VALUES ('$danemie[0]', '$danemie[1]')";
	    $idzsql1 = mysql_query($sql1) or die('mysql_query');
	  }
          
          $zapmie = " SELECT id_kol, Count(miejsce)
                      FROM Wyniki INNER JOIN z_a_historiawyscig ON Wyniki.id_wys=z_a_historiawyscig.id_wys
                      WHERE z_a_historiawyscig.id_hiswys='$id_hiswys' AND Wyniki.miejsce<4 AND Wyniki.id_co>20
                      GROUP BY id_kol";
          $idzmie = mysql_query($zapmie) or die('mysql_query');
          while ($danemie = mysql_fetch_row($idzmie)) 
	  {
	    $sql1="INSERT INTO z_a_historiawyscigTEMP (id_kol, ile) VALUES ('$danemie[0]', '$danemie[1]')";
	    $idzsql1 = mysql_query($sql1) or die('mysql_query');
	  }
          
          
          
          $zapmie = " SELECT Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Sum(ile), Nat.flaga, Nat.skr, Nat.id_nat
                      FROM Nat INNER JOIN (Kolarze INNER JOIN z_a_historiawyscigTEMP ON Kolarze.id_kol=z_a_historiawyscigTEMP.id_kol) ON Nat.id_nat = Kolarze.id_nat
                      GROUP BY id_kol
                      ORDER BY Sum(ile) DESC
	  	      ";
	  
          $idzmie = mysql_query($zapmie) or die('mysql_query');
          echo '<h2>Najwięcej podium etapowych</h2>
	  <table class="wyscig" rules="all">
	  <tr><th class="wyscig1">lp</th><th class="wyscig7">kolarz</th><th class="wyscig6">ile razy</th><tr>';
	  $lp=1;
	  $lp2=1;
	  $poprzednio=0;
	  $niebylykropki=true;
          while ($danemie = mysql_fetch_row($idzmie)) 
	  {
	    //tu pojawia się tabela najlepszych.
	    //echo '<tr><td class="wyscig1">';
	    if ($poprzednio <> $danemie[3])
	    { 
	      $lp2=$lp;
	      if (($lp2 > 10) and $niebylykropki)
	      {
	        echo '<tr><td class="wyscig1">...</td><td class="wyscig7">...</td><td class="wyscig6">...</td></tr>';
	        $niebylykropki = false;
	      }
	      
	      if  (($lp2 < 11) OR ($danemie[6] == 52))
	      {
	        echo '<tr><td class="wyscig1">'.$lp.'</td><td class="wyscig7"><img src="http://fff.xon.pl/img/flagi/'.$danemie[4].'" alt="'.$danemie[5].'" /> <a href="kol.php?id_kol='.$danemie[0].'">'.$danemie[1].' <b>'.$danemie[2].'</b></a></td><td class="wyscig6">'.$danemie[3].'</td><tr>';
	      }
	    } else 
	    {
	      if  (($lp2 < 11) OR ($danemie[6] == 52)) 
	      {
	        echo '<tr><td class="wyscig1"></td><td class="wyscig7"><img src="http://fff.xon.pl/img/flagi/'.$danemie[4].'" alt="'.$danemie[5].'" /> <a href="kol.php?id_kol='.$danemie[0].'">'.$danemie[1].' <b>'.$danemie[2].'</b></a></td><td class="wyscig6">'.$danemie[3].'</td><tr>';
	      }
	      //echo $lp2;
	    }
	    //if ($lp2 <11) {
	    //  echo '</td><td class="wyscig7"><img src="http://fff.xon.pl/img/flagi/'.$danemie[4].'" alt="'.$danemie[5].'" /> <a href="kol.php?id_kol='.$danemie[0].'">'.$danemie[1].' <b>'.$danemie[2].'</b></a></td><td class="wyscig6">'.$danemie[3].'</td><tr>';
	    //}
	    $lp=$lp+1;
	    $poprzednio = $danemie[3];
	    
	  }
	  echo '</table>';  
	  }
	  
	  if ($czysaetapy) {
	  //----------------------------------------------------------
          //Czas na statystyki    najwięcej miejsc w 10:
          //----------------------------------------------------------
          
          $sql="TRUNCATE TABLE z_a_historiawyscigTEMP";
          $idz = mysql_query($sql) or die('mysql_query');
          $zapmie = " SELECT id_kol, Count(miejsce)
                      FROM WynikiP INNER JOIN z_a_historiawyscig ON WynikiP.id_wys=z_a_historiawyscig.id_wys
                      WHERE z_a_historiawyscig.id_hiswys='$id_hiswys' AND WynikiP.miejsce<11 AND WynikiP.id_co>20
                      GROUP BY id_kol";
          $idzmie = mysql_query($zapmie) or die('mysql_query');
          while ($danemie = mysql_fetch_row($idzmie)) 
	  {
	    $sql1="INSERT INTO z_a_historiawyscigTEMP (id_kol, ile) VALUES ('$danemie[0]', '$danemie[1]')";
	    $idzsql1 = mysql_query($sql1) or die('mysql_query');
	  }
          
          $zapmie = " SELECT id_kol, Count(miejsce)
                      FROM Wyniki INNER JOIN z_a_historiawyscig ON Wyniki.id_wys=z_a_historiawyscig.id_wys
                      WHERE z_a_historiawyscig.id_hiswys='$id_hiswys' AND Wyniki.miejsce<11 AND Wyniki.id_co>20
                      GROUP BY id_kol";
          $idzmie = mysql_query($zapmie) or die('mysql_query');
          while ($danemie = mysql_fetch_row($idzmie)) 
	  {
	    $sql1="INSERT INTO z_a_historiawyscigTEMP (id_kol, ile) VALUES ('$danemie[0]', '$danemie[1]')";
	    $idzsql1 = mysql_query($sql1) or die('mysql_query');
	  }
          
          
          
          $zapmie = " SELECT Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Sum(ile), Nat.flaga, Nat.skr, Nat.id_nat
                      FROM Nat INNER JOIN (Kolarze INNER JOIN z_a_historiawyscigTEMP ON Kolarze.id_kol=z_a_historiawyscigTEMP.id_kol) ON Nat.id_nat = Kolarze.id_nat
                      GROUP BY id_kol
                      ORDER BY Sum(ile) DESC
	  	      ";
	  
          $idzmie = mysql_query($zapmie) or die('mysql_query');
          echo '<h2>Najwięcej miejsc w 10</h2>
	  <table class="wyscig" rules="all">
	  <tr><th class="wyscig1">lp</th><th class="wyscig7">kolarz</th><th class="wyscig6">ile razy</th><tr>';
	  $lp=1;
	  $lp2=1;
	  $poprzednio=0;
	  $niebylykropki=true;
          while ($danemie = mysql_fetch_row($idzmie)) 
	  {
	    //tu pojawia się tabela najlepszych.
	    //echo '<tr><td class="wyscig1">';
	    if ($poprzednio <> $danemie[3])
	    { 
	      $lp2=$lp;
	      if (($lp2 > 10) and $niebylykropki)
	      {
	        echo '<tr><td class="wyscig1">...</td><td class="wyscig7">...</td><td class="wyscig6">...</td></tr>';
	        $niebylykropki = false;
	      }
	      
	      if  (($lp2 < 11) OR ($danemie[6] == 52))
	      {
	        echo '<tr><td class="wyscig1">'.$lp.'</td><td class="wyscig7"><img src="http://fff.xon.pl/img/flagi/'.$danemie[4].'" alt="'.$danemie[5].'" /> <a href="kol.php?id_kol='.$danemie[0].'">'.$danemie[1].' <b>'.$danemie[2].'</b></a></td><td class="wyscig6">'.$danemie[3].'</td><tr>';
	      }
	    } else 
	    {
	      if  (($lp2 < 11) OR ($danemie[6] == 52)) 
	      {
	        echo '<tr><td class="wyscig1"></td><td class="wyscig7"><img src="http://fff.xon.pl/img/flagi/'.$danemie[4].'" alt="'.$danemie[5].'" /> <a href="kol.php?id_kol='.$danemie[0].'">'.$danemie[1].' <b>'.$danemie[2].'</b></a></td><td class="wyscig6">'.$danemie[3].'</td><tr>';
	      }
	      //echo $lp2;
	    }
	    //if ($lp2 <11) {
	    //  echo '</td><td class="wyscig7"><img src="http://fff.xon.pl/img/flagi/'.$danemie[4].'" alt="'.$danemie[5].'" /> <a href="kol.php?id_kol='.$danemie[0].'">'.$danemie[1].' <b>'.$danemie[2].'</b></a></td><td class="wyscig6">'.$danemie[3].'</td><tr>';
	    //}
	    $lp=$lp+1;
	    $poprzednio = $danemie[3];
	    
	  }
	  echo '</table>';
	  }
	  
	  
	  
	  //----------------------------------------------------------
          //Czas na statystyki    najwięcej razy w 10 w generalce:
          //----------------------------------------------------------
          
          $sql="TRUNCATE TABLE z_a_historiawyscigTEMP";
          $idz = mysql_query($sql) or die('mysql_query');
          $zapmie = " SELECT id_kol, Count(miejsce)
                      FROM WynikiP INNER JOIN z_a_historiawyscig ON WynikiP.id_wys=z_a_historiawyscig.id_wys
                      WHERE z_a_historiawyscig.id_hiswys='$id_hiswys' AND WynikiP.miejsce<11 AND WynikiP.id_co=0
                      GROUP BY id_kol";
          $idzmie = mysql_query($zapmie) or die('mysql_query');
          while ($danemie = mysql_fetch_row($idzmie)) 
	  {
	    $sql1="INSERT INTO z_a_historiawyscigTEMP (id_kol, ile) VALUES ('$danemie[0]', '$danemie[1]')";
	    $idzsql1 = mysql_query($sql1) or die('mysql_query');
	  }
          
          $zapmie = " SELECT id_kol, Count(miejsce)
                      FROM Wyniki INNER JOIN z_a_historiawyscig ON Wyniki.id_wys=z_a_historiawyscig.id_wys
                      WHERE z_a_historiawyscig.id_hiswys='$id_hiswys' AND Wyniki.miejsce<11 AND Wyniki.id_co=0
                      GROUP BY id_kol";
          $idzmie = mysql_query($zapmie) or die('mysql_query');
          while ($danemie = mysql_fetch_row($idzmie)) 
	  {
	    $sql1="INSERT INTO z_a_historiawyscigTEMP (id_kol, ile) VALUES ('$danemie[0]', '$danemie[1]')";
	    $idzsql1 = mysql_query($sql1) or die('mysql_query');
	  }
          
          
          
          $zapmie = " SELECT Kolarze.id_kol, Kolarze.imie, Kolarze.nazw, Sum(ile), Nat.flaga, Nat.skr, Nat.id_nat
                      FROM Nat INNER JOIN (Kolarze INNER JOIN z_a_historiawyscigTEMP ON Kolarze.id_kol=z_a_historiawyscigTEMP.id_kol) ON Nat.id_nat = Kolarze.id_nat
                      GROUP BY id_kol
                      ORDER BY Sum(ile) DESC
	  	      ";
	  
          $idzmie = mysql_query($zapmie) or die('mysql_query');
          echo '<h2>Najwięcej miejsc w 10 w generalce</h2>
	  <table class="wyscig" rules="all">
	  <tr><th class="wyscig1">lp</th><th class="wyscig7">kolarz</th><th class="wyscig6">ile razy</th><tr>';
	  $lp=1;
	  $lp2=1;
	  $poprzednio=0;
	  $niebylykropki=true;
          while ($danemie = mysql_fetch_row($idzmie)) 
	  {
	    //tu pojawia się tabela najlepszych.
	    //echo '<tr><td class="wyscig1">';
	    if ($poprzednio <> $danemie[3])
	    { 
	      $lp2=$lp;
	      if (($lp2 > 10) and $niebylykropki)
	      {
	        echo '<tr><td class="wyscig1">...</td><td class="wyscig7">...</td><td class="wyscig6">...</td></tr>';
	        $niebylykropki = false;
	      }
	      
	      if  (($lp2 < 11) OR ($danemie[6] == 52))
	      {
	        echo '<tr><td class="wyscig1">'.$lp.'</td><td class="wyscig7"><img src="http://fff.xon.pl/img/flagi/'.$danemie[4].'" alt="'.$danemie[5].'" /> <a href="kol.php?id_kol='.$danemie[0].'">'.$danemie[1].' <b>'.$danemie[2].'</b></a></td><td class="wyscig6">'.$danemie[3].'</td><tr>';
	      }
	    } else 
	    {
	      if  (($lp2 < 11) OR ($danemie[6] == 52)) 
	      {
	        echo '<tr><td class="wyscig1"></td><td class="wyscig7"><img src="http://fff.xon.pl/img/flagi/'.$danemie[4].'" alt="'.$danemie[5].'" /> <a href="kol.php?id_kol='.$danemie[0].'">'.$danemie[1].' <b>'.$danemie[2].'</b></a></td><td class="wyscig6">'.$danemie[3].'</td><tr>';
	      }
	      //echo $lp2;
	    }
	    //if ($lp2 <11) {
	    //  echo '</td><td class="wyscig7"><img src="http://fff.xon.pl/img/flagi/'.$danemie[4].'" alt="'.$danemie[5].'" /> <a href="kol.php?id_kol='.$danemie[0].'">'.$danemie[1].' <b>'.$danemie[2].'</b></a></td><td class="wyscig6">'.$danemie[3].'</td><tr>';
	    //}
	    $lp=$lp+1;
	    $poprzednio = $danemie[3];
	    
	  }
	  echo '</table>';
	  
	  
	  if ($czysaetapy) {
	  //----------------------------------------------------------
          //Czas na statystyki    najwięcej zwycięstw krajami:
          //----------------------------------------------------------
          
          $sql="TRUNCATE TABLE z_a_historiawyscigTEMP";
          $idz = mysql_query($sql) or die('mysql_query');
          $zapmie = " SELECT id_nat, Count(WynikiP.miejsce)
                      FROM Kolarze INNER JOIN (WynikiP INNER JOIN z_a_historiawyscig ON WynikiP.id_wys=z_a_historiawyscig.id_wys) ON WynikiP.id_kol=Kolarze.id_kol
                      WHERE z_a_historiawyscig.id_hiswys='$id_hiswys' AND WynikiP.miejsce=1 AND WynikiP.id_co>20
                      GROUP BY id_nat";
          $idzmie = mysql_query($zapmie) or die('mysql_query');
          while ($danemie = mysql_fetch_row($idzmie)) 
	  {
	    $sql1="INSERT INTO z_a_historiawyscigTEMP (id_kol, ile) VALUES ('$danemie[0]', '$danemie[1]')";
	    $idzsql1 = mysql_query($sql1) or die('mysql_query');
	  }
          
          $zapmie = " SELECT id_nat, Count(Wyniki.miejsce)
                      FROM Kolarze INNER JOIN (Wyniki INNER JOIN z_a_historiawyscig ON Wyniki.id_wys=z_a_historiawyscig.id_wys) ON Wyniki.id_kol=Kolarze.id_kol
                      WHERE z_a_historiawyscig.id_hiswys='$id_hiswys' AND Wyniki.miejsce=1 AND Wyniki.id_co>20
                      GROUP BY id_nat";
          $idzmie = mysql_query($zapmie) or die('mysql_query');
          while ($danemie = mysql_fetch_row($idzmie)) 
	  {
	    $sql1="INSERT INTO z_a_historiawyscigTEMP (id_kol, ile) VALUES ('$danemie[0]', '$danemie[1]')";
	    $idzsql1 = mysql_query($sql1) or die('mysql_query');
	  }
          
          
          
          $zapmie = " SELECT Nat.flaga, Nat.skr, Nat.nazwa, Sum(ile), Nat.flaga, Nat.skr, Nat.id_nat
                      FROM Nat INNER JOIN z_a_historiawyscigTEMP ON z_a_historiawyscigTEMP.id_kol = Nat.id_nat
                      GROUP BY Nat.flaga
                      ORDER BY Sum(ile) DESC
	  	      ";
	  
          $idzmie = mysql_query($zapmie) or die('mysql_query');
          echo '<h2>Najwięcej zwycięstw etapowych</h2>
	  <table class="wyscig" rules="all">
	  <tr><th class="wyscig1">lp</th><th class="wyscig7">kolarz</th><th class="wyscig6">ile razy</th><tr>';
	  $lp=1;
	  $lp2 = 1;
	  $poprzednio=0;
	  $niebylykropki=true;
          while ($danemie = mysql_fetch_row($idzmie)) 
	  {
	    if (($lp2 > 10) and $niebylykropki)
	      {
	        echo '<tr><td class="wyscig1">...</td><td class="wyscig7">...</td><td class="wyscig6">...</td></tr>';
	        $niebylykropki = false;
	      }
	    //tu pojawia się tabela najlepszych.
	    if ($poprzednio <> $danemie[3]) $lp2=$lp;
	    if (($lp2<10) OR ($danemie[6] == 52)) {
	      
	      if ($poprzednio <> $danemie[3]) 
	      {
	        echo '<tr><td class="wyscig1">'.$lp.'</td><td class="wyscig7"><img src="http://fff.xon.pl/img/flagi/'.$danemie[0].'" alt="'.$danemie[1].'" /> '.$danemie[2].'</td><td class="wyscig6">'.$danemie[3].'</td><tr>';
	      } else 
	      {
	        echo '<tr><td class="wyscig1"></td><td class="wyscig7"><img src="http://fff.xon.pl/img/flagi/'.$danemie[0].'" alt="'.$danemie[1].'" /> '.$danemie[2].'</td><td class="wyscig6">'.$danemie[3].'</td><tr>';
	      }
	    
	      $poprzednio = $danemie[3];
	    }
	    $lp=$lp+1;
	  }
	  echo '</table>';
	  }
	  
	  if ($czysaetapy) {
	  //----------------------------------------------------------
          //Czas na statystyki    najwięcej podium krajami:
          //----------------------------------------------------------
          
          $sql="TRUNCATE TABLE z_a_historiawyscigTEMP";
          $idz = mysql_query($sql) or die('mysql_query');
          $zapmie = " SELECT id_nat, Count(WynikiP.miejsce)
                      FROM Kolarze INNER JOIN (WynikiP INNER JOIN z_a_historiawyscig ON WynikiP.id_wys=z_a_historiawyscig.id_wys) ON WynikiP.id_kol=Kolarze.id_kol
                      WHERE z_a_historiawyscig.id_hiswys='$id_hiswys' AND WynikiP.miejsce<4 AND WynikiP.id_co>20
                      GROUP BY id_nat";
          $idzmie = mysql_query($zapmie) or die('mysql_query');
          while ($danemie = mysql_fetch_row($idzmie)) 
	  {
	    $sql1="INSERT INTO z_a_historiawyscigTEMP (id_kol, ile) VALUES ('$danemie[0]', '$danemie[1]')";
	    $idzsql1 = mysql_query($sql1) or die('mysql_query');
	  }
          
          $zapmie = " SELECT id_nat, Count(Wyniki.miejsce)
                      FROM Kolarze INNER JOIN (Wyniki INNER JOIN z_a_historiawyscig ON Wyniki.id_wys=z_a_historiawyscig.id_wys) ON Wyniki.id_kol=Kolarze.id_kol
                      WHERE z_a_historiawyscig.id_hiswys='$id_hiswys' AND Wyniki.miejsce<4 AND Wyniki.id_co>20
                      GROUP BY id_nat";
          $idzmie = mysql_query($zapmie) or die('mysql_query');
          while ($danemie = mysql_fetch_row($idzmie)) 
	  {
	    $sql1="INSERT INTO z_a_historiawyscigTEMP (id_kol, ile) VALUES ('$danemie[0]', '$danemie[1]')";
	    $idzsql1 = mysql_query($sql1) or die('mysql_query');
	  }
          
          
          
          $zapmie = " SELECT Nat.flaga, Nat.skr, Nat.nazwa, Sum(ile), Nat.flaga, Nat.skr, Nat.id_nat
                      FROM Nat INNER JOIN z_a_historiawyscigTEMP ON z_a_historiawyscigTEMP.id_kol = Nat.id_nat
                      GROUP BY Nat.flaga
                      ORDER BY Sum(ile) DESC
	  	      ";
	  
          $idzmie = mysql_query($zapmie) or die('mysql_query');
          echo '<h2>Najwięcej razy na podium na etapie</h2>
	  <table class="wyscig" rules="all">
	  <tr><th class="wyscig1">lp</th><th class="wyscig7">kolarz</th><th class="wyscig6">ile razy</th><tr>';
	  $lp=1;
	  $lp2 = 1;
	  $poprzednio=0;
	  $niebylykropki=true;
          while ($danemie = mysql_fetch_row($idzmie)) 
	  {
	    if (($lp2 > 10) and $niebylykropki)
	      {
	        echo '<tr><td class="wyscig1">...</td><td class="wyscig7">...</td><td class="wyscig6">...</td></tr>';
	        $niebylykropki = false;
	      }
	    //tu pojawia się tabela najlepszych.
	    if ($poprzednio <> $danemie[3]) $lp2=$lp;
	    if (($lp2<10) OR ($danemie[6] == 52)) {
	      
	      if ($poprzednio <> $danemie[3]) 
	      {
	        echo '<tr><td class="wyscig1">'.$lp.'</td><td class="wyscig7"><img src="http://fff.xon.pl/img/flagi/'.$danemie[0].'" alt="'.$danemie[1].'" /> '.$danemie[2].'</td><td class="wyscig6">'.$danemie[3].'</td><tr>';
	      } else 
	      {
	        echo '<tr><td class="wyscig1"></td><td class="wyscig7"><img src="http://fff.xon.pl/img/flagi/'.$danemie[0].'" alt="'.$danemie[1].'" /> '.$danemie[2].'</td><td class="wyscig6">'.$danemie[3].'</td><tr>';
	      }
	    
	      $poprzednio = $danemie[3];
	    }
	    $lp=$lp+1;
	  }
	  echo '</table>';
          }
	  
	  
	  if ($czysaetapy) {
	  //----------------------------------------------------------
          //Czas na statystyki    najwięcej 10 krajami:
          //----------------------------------------------------------
          
          $sql="TRUNCATE TABLE z_a_historiawyscigTEMP";
          $idz = mysql_query($sql) or die('mysql_query');
          $zapmie = " SELECT id_nat, Count(WynikiP.miejsce)
                      FROM Kolarze INNER JOIN (WynikiP INNER JOIN z_a_historiawyscig ON WynikiP.id_wys=z_a_historiawyscig.id_wys) ON WynikiP.id_kol=Kolarze.id_kol
                      WHERE z_a_historiawyscig.id_hiswys='$id_hiswys' AND WynikiP.miejsce<11 AND WynikiP.id_co>20
                      GROUP BY id_nat";
          $idzmie = mysql_query($zapmie) or die('mysql_query');
          while ($danemie = mysql_fetch_row($idzmie)) 
	  {
	    $sql1="INSERT INTO z_a_historiawyscigTEMP (id_kol, ile) VALUES ('$danemie[0]', '$danemie[1]')";
	    $idzsql1 = mysql_query($sql1) or die('mysql_query');
	  }
          
          $zapmie = " SELECT id_nat, Count(Wyniki.miejsce)
                      FROM Kolarze INNER JOIN (Wyniki INNER JOIN z_a_historiawyscig ON Wyniki.id_wys=z_a_historiawyscig.id_wys) ON Wyniki.id_kol=Kolarze.id_kol
                      WHERE z_a_historiawyscig.id_hiswys='$id_hiswys' AND Wyniki.miejsce<11 AND Wyniki.id_co>20
                      GROUP BY id_nat";
          $idzmie = mysql_query($zapmie) or die('mysql_query');
          while ($danemie = mysql_fetch_row($idzmie)) 
	  {
	    $sql1="INSERT INTO z_a_historiawyscigTEMP (id_kol, ile) VALUES ('$danemie[0]', '$danemie[1]')";
	    $idzsql1 = mysql_query($sql1) or die('mysql_query');
	  }
          
          
          
          $zapmie = " SELECT Nat.flaga, Nat.skr, Nat.nazwa, Sum(ile), Nat.flaga, Nat.skr, Nat.id_nat
                      FROM Nat INNER JOIN z_a_historiawyscigTEMP ON z_a_historiawyscigTEMP.id_kol = Nat.id_nat
                      GROUP BY Nat.flaga
                      ORDER BY Sum(ile) DESC
	  	      ";
	  
          $idzmie = mysql_query($zapmie) or die('mysql_query');
          echo '<h2>Najwięcej razy w 10 na etapie</h2>
	  <table class="wyscig" rules="all">
	  <tr><th class="wyscig1">lp</th><th class="wyscig7">kolarz</th><th class="wyscig6">ile razy</th><tr>';
	  $lp=1;
	  $lp2 = 1;
	  $poprzednio=0;
	  $niebylykropki=true;
          while ($danemie = mysql_fetch_row($idzmie)) 
	  {
	    if (($lp2 > 10) and $niebylykropki)
	      {
	        echo '<tr><td class="wyscig1">...</td><td class="wyscig7">...</td><td class="wyscig6">...</td></tr>';
	        $niebylykropki = false;
	      }
	    //tu pojawia się tabela najlepszych.
	    if ($poprzednio <> $danemie[3]) $lp2=$lp;
	    if (($lp2<10) OR ($danemie[6] == 52)) {
	      
	      if ($poprzednio <> $danemie[3]) 
	      {
	        echo '<tr><td class="wyscig1">'.$lp.'</td><td class="wyscig7"><img src="http://fff.xon.pl/img/flagi/'.$danemie[0].'" alt="'.$danemie[1].'" /> '.$danemie[2].'</td><td class="wyscig6">'.$danemie[3].'</td><tr>';
	      } else 
	      {
	        echo '<tr><td class="wyscig1"></td><td class="wyscig7"><img src="http://fff.xon.pl/img/flagi/'.$danemie[0].'" alt="'.$danemie[1].'" /> '.$danemie[2].'</td><td class="wyscig6">'.$danemie[3].'</td><tr>';
	      }
	    
	      $poprzednio = $danemie[3];
	    }
	    $lp=$lp+1;
	  }
	  echo '</table>';
          }
          
          
          //----------------------------------------------------------
          //Czas na statystyki    najwięcej podium w generalce krajami:
          //----------------------------------------------------------
          
          $sql="TRUNCATE TABLE z_a_historiawyscigTEMP";
          $idz = mysql_query($sql) or die('mysql_query');
          $zapmie = " SELECT id_nat, Count(WynikiP.miejsce)
                      FROM Kolarze INNER JOIN (WynikiP INNER JOIN z_a_historiawyscig ON WynikiP.id_wys=z_a_historiawyscig.id_wys) ON WynikiP.id_kol=Kolarze.id_kol
                      WHERE z_a_historiawyscig.id_hiswys='$id_hiswys' AND WynikiP.miejsce<4 AND WynikiP.id_co=0
                      GROUP BY id_nat";
          $idzmie = mysql_query($zapmie) or die('mysql_query');
          while ($danemie = mysql_fetch_row($idzmie)) 
	  {
	    $sql1="INSERT INTO z_a_historiawyscigTEMP (id_kol, ile) VALUES ('$danemie[0]', '$danemie[1]')";
	    $idzsql1 = mysql_query($sql1) or die('mysql_query');
	  }
          
          $zapmie = " SELECT id_nat, Count(Wyniki.miejsce)
                      FROM Kolarze INNER JOIN (Wyniki INNER JOIN z_a_historiawyscig ON Wyniki.id_wys=z_a_historiawyscig.id_wys) ON Wyniki.id_kol=Kolarze.id_kol
                      WHERE z_a_historiawyscig.id_hiswys='$id_hiswys' AND Wyniki.miejsce<4 AND Wyniki.id_co=0
                      GROUP BY id_nat";
          $idzmie = mysql_query($zapmie) or die('mysql_query');
          while ($danemie = mysql_fetch_row($idzmie)) 
	  {
	    $sql1="INSERT INTO z_a_historiawyscigTEMP (id_kol, ile) VALUES ('$danemie[0]', '$danemie[1]')";
	    $idzsql1 = mysql_query($sql1) or die('mysql_query');
	  }
          
          
          
          $zapmie = " SELECT Nat.flaga, Nat.skr, Nat.nazwa, Sum(ile), Nat.flaga, Nat.skr, Nat.id_nat
                      FROM Nat INNER JOIN z_a_historiawyscigTEMP ON z_a_historiawyscigTEMP.id_kol = Nat.id_nat
                      GROUP BY Nat.flaga
                      ORDER BY Sum(ile) DESC
	  	      ";
	  
          $idzmie = mysql_query($zapmie) or die('mysql_query');
          echo '<h2>Najwięcej razy podium w generalce</h2>
	  <table class="wyscig" rules="all">
	  <tr><th class="wyscig1">lp</th><th class="wyscig7">kolarz</th><th class="wyscig6">ile razy</th><tr>';
	  $lp=1;
	  $lp2 = 1;
	  $poprzednio=0;
	  $niebylykropki=true;
          while ($danemie = mysql_fetch_row($idzmie)) 
	  {
	    if (($lp2 > 10) and $niebylykropki)
	      {
	        echo '<tr><td class="wyscig1">...</td><td class="wyscig7">...</td><td class="wyscig6">...</td></tr>';
	        $niebylykropki = false;
	      }
	    //tu pojawia się tabela najlepszych.
	    if ($poprzednio <> $danemie[3]) $lp2=$lp;
	    if (($lp2<10) OR ($danemie[6] == 52)) {
	      
	      if ($poprzednio <> $danemie[3]) 
	      {
	        echo '<tr><td class="wyscig1">'.$lp.'</td><td class="wyscig7"><img src="http://fff.xon.pl/img/flagi/'.$danemie[0].'" alt="'.$danemie[1].'" /> '.$danemie[2].'</td><td class="wyscig6">'.$danemie[3].'</td><tr>';
	      } else 
	      {
	        echo '<tr><td class="wyscig1"></td><td class="wyscig7"><img src="http://fff.xon.pl/img/flagi/'.$danemie[0].'" alt="'.$danemie[1].'" /> '.$danemie[2].'</td><td class="wyscig6">'.$danemie[3].'</td><tr>';
	      }
	    
	      $poprzednio = $danemie[3];
	    }
	    $lp=$lp+1;
	  }
	  echo '</table>';
	  
	  //----------------------------------------------------------
          //Czas na statystyki    najwięcej 10 w generalce krajami:
          //----------------------------------------------------------
          
          $sql="TRUNCATE TABLE z_a_historiawyscigTEMP";
          $idz = mysql_query($sql) or die('mysql_query');
          $zapmie = " SELECT id_nat, Count(WynikiP.miejsce)
                      FROM Kolarze INNER JOIN (WynikiP INNER JOIN z_a_historiawyscig ON WynikiP.id_wys=z_a_historiawyscig.id_wys) ON WynikiP.id_kol=Kolarze.id_kol
                      WHERE z_a_historiawyscig.id_hiswys='$id_hiswys' AND WynikiP.miejsce<11 AND WynikiP.id_co=0
                      GROUP BY id_nat";
          $idzmie = mysql_query($zapmie) or die('mysql_query');
          while ($danemie = mysql_fetch_row($idzmie)) 
	  {
	    $sql1="INSERT INTO z_a_historiawyscigTEMP (id_kol, ile) VALUES ('$danemie[0]', '$danemie[1]')";
	    $idzsql1 = mysql_query($sql1) or die('mysql_query');
	  }
          
          $zapmie = " SELECT id_nat, Count(Wyniki.miejsce)
                      FROM Kolarze INNER JOIN (Wyniki INNER JOIN z_a_historiawyscig ON Wyniki.id_wys=z_a_historiawyscig.id_wys) ON Wyniki.id_kol=Kolarze.id_kol
                      WHERE z_a_historiawyscig.id_hiswys='$id_hiswys' AND Wyniki.miejsce<11 AND Wyniki.id_co=0
                      GROUP BY id_nat";
          $idzmie = mysql_query($zapmie) or die('mysql_query');
          while ($danemie = mysql_fetch_row($idzmie)) 
	  {
	    $sql1="INSERT INTO z_a_historiawyscigTEMP (id_kol, ile) VALUES ('$danemie[0]', '$danemie[1]')";
	    $idzsql1 = mysql_query($sql1) or die('mysql_query');
	  }
          
          
          
          $zapmie = " SELECT Nat.flaga, Nat.skr, Nat.nazwa, Sum(ile), Nat.flaga, Nat.skr, Nat.id_nat
                      FROM Nat INNER JOIN z_a_historiawyscigTEMP ON z_a_historiawyscigTEMP.id_kol = Nat.id_nat
                      GROUP BY Nat.flaga
                      ORDER BY Sum(ile) DESC
	  	      ";
	  
          $idzmie = mysql_query($zapmie) or die('mysql_query');
          echo '<h2>Najwięcej razy w 10 w generalce</h2>
	  <table class="wyscig" rules="all">
	  <tr><th class="wyscig1">lp</th><th class="wyscig7">kolarz</th><th class="wyscig6">ile razy</th><tr>';
	  $lp=1;
	  $lp2 = 1;
	  $poprzednio=0;
	  $niebylykropki=true;
          while ($danemie = mysql_fetch_row($idzmie)) 
	  {
	    if (($lp2 > 10) and $niebylykropki)
	      {
	        echo '<tr><td class="wyscig1">...</td><td class="wyscig7">...</td><td class="wyscig6">...</td></tr>';
	        $niebylykropki = false;
	      }
	    //tu pojawia się tabela najlepszych.
	    if ($poprzednio <> $danemie[3]) $lp2=$lp;
	    if (($lp2<10) OR ($danemie[6] == 52)) {
	      
	      if ($poprzednio <> $danemie[3]) 
	      {
	        echo '<tr><td class="wyscig1">'.$lp.'</td><td class="wyscig7"><img src="http://fff.xon.pl/img/flagi/'.$danemie[0].'" alt="'.$danemie[1].'" /> '.$danemie[2].'</td><td class="wyscig6">'.$danemie[3].'</td><tr>';
	      } else 
	      {
	        echo '<tr><td class="wyscig1"></td><td class="wyscig7"><img src="http://fff.xon.pl/img/flagi/'.$danemie[0].'" alt="'.$danemie[1].'" /> '.$danemie[2].'</td><td class="wyscig6">'.$danemie[3].'</td><tr>';
	      }
	    
	      $poprzednio = $danemie[3];
	    }
	    $lp=$lp+1;
	  }
	  echo '</table>';
	  
	  if ($czysaetapy) {
          //----------------------------------------------------------
          //Czas na statystyki na początek najwięcej wygranych etapów ekip:
          //----------------------------------------------------------
          
          $sql="TRUNCATE TABLE z_a_historiawyscigTEMP";
          $idz = mysql_query($sql) or die('mysql_query');
          $zapmie = " SELECT id_wys
                      FROM  z_a_historiawyscig 
                      WHERE z_a_historiawyscig.id_hiswys='$id_hiswys'
                      ";
          //echo $zapmie;
          $idzmie = mysql_query($zapmie) or die('mysql_query');
          while ($danemie = mysql_fetch_row($idzmie)) 
	  {
	     $pytanko=" SELECT Kolarze.id_kol, WynikiP.miejsce, DATE(Wyscigi.dataP)
                        FROM Wyscigi INNER JOIN (WynikiP INNER JOIN Kolarze ON WynikiP.id_kol=Kolarze.id_kol) ON Wyscigi.id_wys = WynikiP.id_wys
                        WHERE WynikiP.id_wys='$danemie[0]' AND WynikiP.miejsce=1 AND WynikiP.id_co>20";
             $idzpytanko = mysql_query($pytanko) or die('mysql_query'); 
             //echo $pytanko.'<br/>
	     //------------------------------------------------<br/><br/>';
	     while ($danepytanko = mysql_fetch_row($idzpytanko)) 
	     {
	         $sqlhis = " SELECT id_do, kiedy, YEAR(kiedy)
		             FROM z_a_historiakol
		             WHERE (id_kol = '$danepytanko[0]') AND (kiedy <= '$danepytanko[2]')
		             ORDER BY kiedy DESC ";
	         $zaphis = mysql_query($sqlhis) or die('mysql_query');
	         $danhis = mysql_fetch_row($zaphis);
		 //echo $sqlhis.'<br/>';
		 
		 $sql1="INSERT INTO z_a_historiawyscigTEMP (id_kol, ile) VALUES ('$danhis[0]', 1)";
	         $idzsql1 = mysql_query($sql1) or die('mysql_query');
		 //echo $sql1.'<br/>';
		 
	    }
	    
	    $pytanko=" SELECT Kolarze.id_kol, Wyniki.miejsce, DATE(Wyscigi.dataP)
                        FROM Wyscigi INNER JOIN (Wyniki INNER JOIN Kolarze ON Wyniki.id_kol=Kolarze.id_kol) ON Wyscigi.id_wys = Wyniki.id_wys
                        WHERE Wyniki.id_wys='$danemie[0]' AND Wyniki.miejsce=1 AND Wyniki.id_co>20";
             $idzpytanko = mysql_query($pytanko) or die('mysql_query'); 
             //echo $pytanko.'<br/>
	     //------------------------------------------------<br/><br/>';
	     while ($danepytanko = mysql_fetch_row($idzpytanko)) 
	     {
	         $sqlhis = " SELECT id_do, kiedy, YEAR(kiedy)
		             FROM z_a_historiakol
		             WHERE (id_kol = '$danepytanko[0]') AND (kiedy <= '$danepytanko[2]')
		             ORDER BY kiedy DESC ";
	         $zaphis = mysql_query($sqlhis) or die('mysql_query');
	         $danhis = mysql_fetch_row($zaphis);
		 //echo $sqlhis.'<br/>';
		 
		 $sql1="INSERT INTO z_a_historiawyscigTEMP (id_kol, ile) VALUES ('$danhis[0]', 1)";
	         $idzsql1 = mysql_query($sql1) or die('mysql_query');
		 //echo $sql1.'<br/>';
		 
	    }      
	  }
 
          $zapmie = " SELECT id_kol, Sum(ile)
                      FROM z_a_historiawyscigTEMP
                      GROUP BY id_kol
                      ORDER BY Sum(ile) DESC
	  	      ";
          $idzmie = mysql_query($zapmie) or die('mysql_query');
          echo '<h2>Najwięcej zwycięstw etapowych ekip</h2>
	  <table class="wyscig" rules="all">
	  <tr><th class="wyscig1">lp</th><th class="wyscig7">ekipa</th><th class="wyscig6">ile razy</th><tr>';
	  $lp=1;
	  $lp2=1;
	  $poprzednio=0;
	  $niebylykropki=true;
          while ($danemie = mysql_fetch_row($idzmie)) 
	  {
	    $sqlhise = " SELECT z_a_historiaekip.nazwa, z_a_historiaekip.id_nat, z_a_historiaekip.skr, z_a_historiaekip.dyw, Nat.flaga, z_a_historiaekip.id_ek 
	                 FROM z_a_historiaekip INNER JOIN Nat ON z_a_historiaekip.id_nat = Nat.id_nat
	                 WHERE z_a_historiaekip.id_ek = '$danemie[0]'
			 ORDER BY z_a_historiaekip.rok DESC";
	    $zaphise = mysql_query($sqlhise) or die('mysql_query');
            $danhise = mysql_fetch_row($zaphise);
            
	    //tu pojawia się tabela najlepszych.
	    
	    if ($poprzednio <> $danemie[1])
	    { 
	      $lp2=$lp;
	      if (($lp2 > 10) and $niebylykropki)
	      {
	        echo '<tr><td class="wyscig1">...</td><td class="wyscig7">...</td><td class="wyscig6">...</td></tr>';
	        $niebylykropki = false;
	      }
	      
	      if  (($lp2 < 11))
	      {
	        echo '<tr><td class="wyscig1">'.$lp.'</td><td class="wyscig7"><img src="http://fff.xon.pl/img/flagi/'.$danhise[4].'" /> <a href="teamh.php?id_team='.$danhise[5].'&rok='.$danhis[2].'">';
		if ($danhise[5] == 1000) {
                     echo zwroc_tekst(22, $jezyk);
	          } elseif ($danhise[5] == 1001) {
                     echo zwroc_tekst(21, $jezyk);
	          } elseif ($danhise[5] == 0) {
                     echo zwroc_tekst(57, $jezyk);
                  } else {
	             echo $danhise[0];
	          }  
		 
		 echo '</a>
		 ';
		
		echo '</td><td class="wyscig6">'.$danemie[1].'</td><tr>';
	      }
	    } else 
	    {
	      if  (($lp2 < 11)) 
	      {
	        echo '<tr><td class="wyscig1"></td><td class="wyscig7"><img src="http://fff.xon.pl/img/flagi/'.$danhise[4].'" /> <a href="teamh.php?id_team='.$danhise[5].'&rok='.$danhis[2].'">';
		if ($danhise[5] == 1000) {
                     echo zwroc_tekst(22, $jezyk);
	          } elseif ($danhise[5] == 1001) {
                     echo zwroc_tekst(21, $jezyk);
	          } elseif ($danhise[5] == 0) {
                     echo zwroc_tekst(57, $jezyk);
                  } else {
	             echo $danhise[0];
	          }  
		 
		 echo '</a>
		 ';
		
		echo '</td><td class="wyscig6">'.$danemie[1].'</td><tr>';
	      }
	      
	    }
	    
	    $lp=$lp+1;
	    $poprzednio = $danemie[1];
	    
	  }
	  echo '</table>';   
          }
	  
	  
	  if ($czysaetapy) {
          //----------------------------------------------------------
          //Czas na statystyki na początek najwięcej podium ekip:
          //----------------------------------------------------------
          
          $sql="TRUNCATE TABLE z_a_historiawyscigTEMP";
          $idz = mysql_query($sql) or die('mysql_query');
          $zapmie = " SELECT id_wys
                      FROM  z_a_historiawyscig 
                      WHERE z_a_historiawyscig.id_hiswys='$id_hiswys'
                      ";
          //echo $zapmie;
          $idzmie = mysql_query($zapmie) or die('mysql_query');
          while ($danemie = mysql_fetch_row($idzmie)) 
	  {
	     $pytanko=" SELECT Kolarze.id_kol, WynikiP.miejsce, DATE(Wyscigi.dataP)
                        FROM Wyscigi INNER JOIN (WynikiP INNER JOIN Kolarze ON WynikiP.id_kol=Kolarze.id_kol) ON Wyscigi.id_wys = WynikiP.id_wys
                        WHERE WynikiP.id_wys='$danemie[0]' AND WynikiP.miejsce<4 AND WynikiP.id_co>20";
             $idzpytanko = mysql_query($pytanko) or die('mysql_query'); 
             //echo $pytanko.'<br/>
	     //------------------------------------------------<br/><br/>';
	     while ($danepytanko = mysql_fetch_row($idzpytanko)) 
	     {
	         $sqlhis = " SELECT id_do, kiedy, YEAR(kiedy)
		             FROM z_a_historiakol
		             WHERE (id_kol = '$danepytanko[0]') AND (kiedy <= '$danepytanko[2]')
		             ORDER BY kiedy DESC ";
	         $zaphis = mysql_query($sqlhis) or die('mysql_query');
	         $danhis = mysql_fetch_row($zaphis);
		 //echo $sqlhis.'<br/>';
		 
		 $sql1="INSERT INTO z_a_historiawyscigTEMP (id_kol, ile) VALUES ('$danhis[0]', 1)";
	         $idzsql1 = mysql_query($sql1) or die('mysql_query');
		 //echo $sql1.'<br/>';
		 
	    }
	    
	    $pytanko=" SELECT Kolarze.id_kol, Wyniki.miejsce, DATE(Wyscigi.dataP)
                        FROM Wyscigi INNER JOIN (Wyniki INNER JOIN Kolarze ON Wyniki.id_kol=Kolarze.id_kol) ON Wyscigi.id_wys = Wyniki.id_wys
                        WHERE Wyniki.id_wys='$danemie[0]' AND Wyniki.miejsce<4 AND Wyniki.id_co>20";
             $idzpytanko = mysql_query($pytanko) or die('mysql_query'); 
             //echo $pytanko.'<br/>
	     //------------------------------------------------<br/><br/>';
	     while ($danepytanko = mysql_fetch_row($idzpytanko)) 
	     {
	         $sqlhis = " SELECT id_do, kiedy, YEAR(kiedy)
		             FROM z_a_historiakol
		             WHERE (id_kol = '$danepytanko[0]') AND (kiedy <= '$danepytanko[2]')
		             ORDER BY kiedy DESC ";
	         $zaphis = mysql_query($sqlhis) or die('mysql_query');
	         $danhis = mysql_fetch_row($zaphis);
		 //echo $sqlhis.'<br/>';
		 
		 $sql1="INSERT INTO z_a_historiawyscigTEMP (id_kol, ile) VALUES ('$danhis[0]', 1)";
	         $idzsql1 = mysql_query($sql1) or die('mysql_query');
		 //echo $sql1.'<br/>';
		 
	    }      
	  }
 
          $zapmie = " SELECT id_kol, Sum(ile)
                      FROM z_a_historiawyscigTEMP
                      GROUP BY id_kol
                      ORDER BY Sum(ile) DESC
	  	      ";
          $idzmie = mysql_query($zapmie) or die('mysql_query');
          echo '<h2>Najwięcej podium ekip</h2>
	  <table class="wyscig" rules="all">
	  <tr><th class="wyscig1">lp</th><th class="wyscig7">ekipa</th><th class="wyscig6">ile razy</th><tr>';
	  $lp=1;
	  $lp2=1;
	  $poprzednio=0;
	  $niebylykropki=true;
          while ($danemie = mysql_fetch_row($idzmie)) 
	  {
	    $sqlhise = " SELECT z_a_historiaekip.nazwa, z_a_historiaekip.id_nat, z_a_historiaekip.skr, z_a_historiaekip.dyw, Nat.flaga, z_a_historiaekip.id_ek 
	                 FROM z_a_historiaekip INNER JOIN Nat ON z_a_historiaekip.id_nat = Nat.id_nat
	                 WHERE z_a_historiaekip.id_ek = '$danemie[0]'
			 ORDER BY z_a_historiaekip.rok DESC";
	    $zaphise = mysql_query($sqlhise) or die('mysql_query');
            $danhise = mysql_fetch_row($zaphise);
            
	    //tu pojawia się tabela najlepszych.
	    
	    if ($poprzednio <> $danemie[1])
	    { 
	      $lp2=$lp;
	      if (($lp2 > 10) and $niebylykropki)
	      {
	        echo '<tr><td class="wyscig1">...</td><td class="wyscig7">...</td><td class="wyscig6">...</td></tr>';
	        $niebylykropki = false;
	      }
	      
	      if  (($lp2 < 11))
	      {
	        echo '<tr><td class="wyscig1">'.$lp.'</td><td class="wyscig7"><img src="http://fff.xon.pl/img/flagi/'.$danhise[4].'" /> <a href="teamh.php?id_team='.$danhise[5].'&rok='.$danhis[2].'">';
		if ($danhise[5] == 1000) {
                     echo zwroc_tekst(22, $jezyk);
	          } elseif ($danhise[5] == 1001) {
                     echo zwroc_tekst(21, $jezyk);
	          } elseif ($danhise[5] == 0) {
                     echo zwroc_tekst(57, $jezyk);
                  } else {
	             echo $danhise[0];
	          }  
		 
		 echo '</a>
		 ';
		
		echo '</td><td class="wyscig6">'.$danemie[1].'</td><tr>';
	      }
	    } else 
	    {
	      if  (($lp2 < 11)) 
	      {
	        echo '<tr><td class="wyscig1"></td><td class="wyscig7"><img src="http://fff.xon.pl/img/flagi/'.$danhise[4].'" /> <a href="teamh.php?id_team='.$danhise[5].'&rok='.$danhis[2].'">';
		if ($danhise[5] == 1000) {
                     echo zwroc_tekst(22, $jezyk);
	          } elseif ($danhise[5] == 1001) {
                     echo zwroc_tekst(21, $jezyk);
	          } elseif ($danhise[5] == 0) {
                     echo zwroc_tekst(57, $jezyk);
                  } else {
	             echo $danhise[0];
	          }  
		 
		 echo '</a>
		 ';
		
		echo '</td><td class="wyscig6">'.$danemie[1].'</td><tr>';
	      }
	      
	    }
	    
	    $lp=$lp+1;
	    $poprzednio = $danemie[1];
	    
	  }
	  echo '</table>';   
          }
	  
	  
	  if ($czysaetapy) {
          //----------------------------------------------------------
          //Czas na statystyki na początek najwięcej podium ekip:
          //----------------------------------------------------------
          
          $sql="TRUNCATE TABLE z_a_historiawyscigTEMP";
          $idz = mysql_query($sql) or die('mysql_query');
          $zapmie = " SELECT id_wys
                      FROM  z_a_historiawyscig 
                      WHERE z_a_historiawyscig.id_hiswys='$id_hiswys'
                      ";
          //echo $zapmie;
          $idzmie = mysql_query($zapmie) or die('mysql_query');
          while ($danemie = mysql_fetch_row($idzmie)) 
	  {
	     $pytanko=" SELECT Kolarze.id_kol, WynikiP.miejsce, DATE(Wyscigi.dataP)
                        FROM Wyscigi INNER JOIN (WynikiP INNER JOIN Kolarze ON WynikiP.id_kol=Kolarze.id_kol) ON Wyscigi.id_wys = WynikiP.id_wys
                        WHERE WynikiP.id_wys='$danemie[0]' AND WynikiP.miejsce<11 AND WynikiP.id_co>20";
             $idzpytanko = mysql_query($pytanko) or die('mysql_query'); 
             //echo $pytanko.'<br/>
	     //------------------------------------------------<br/><br/>';
	     while ($danepytanko = mysql_fetch_row($idzpytanko)) 
	     {
	         $sqlhis = " SELECT id_do, kiedy, YEAR(kiedy)
		             FROM z_a_historiakol
		             WHERE (id_kol = '$danepytanko[0]') AND (kiedy <= '$danepytanko[2]')
		             ORDER BY kiedy DESC ";
	         $zaphis = mysql_query($sqlhis) or die('mysql_query');
	         $danhis = mysql_fetch_row($zaphis);
		 //echo $sqlhis.'<br/>';
		 
		 $sql1="INSERT INTO z_a_historiawyscigTEMP (id_kol, ile) VALUES ('$danhis[0]', 1)";
	         $idzsql1 = mysql_query($sql1) or die('mysql_query');
		 //echo $sql1.'<br/>';
		 
	    }
	    
	    $pytanko=" SELECT Kolarze.id_kol, Wyniki.miejsce, DATE(Wyscigi.dataP)
                        FROM Wyscigi INNER JOIN (Wyniki INNER JOIN Kolarze ON Wyniki.id_kol=Kolarze.id_kol) ON Wyscigi.id_wys = Wyniki.id_wys
                        WHERE Wyniki.id_wys='$danemie[0]' AND Wyniki.miejsce<11 AND Wyniki.id_co>20";
             $idzpytanko = mysql_query($pytanko) or die('mysql_query'); 
             //echo $pytanko.'<br/>
	     //------------------------------------------------<br/><br/>';
	     while ($danepytanko = mysql_fetch_row($idzpytanko)) 
	     {
	         $sqlhis = " SELECT id_do, kiedy, YEAR(kiedy)
		             FROM z_a_historiakol
		             WHERE (id_kol = '$danepytanko[0]') AND (kiedy <= '$danepytanko[2]')
		             ORDER BY kiedy DESC ";
	         $zaphis = mysql_query($sqlhis) or die('mysql_query');
	         $danhis = mysql_fetch_row($zaphis);
		 //echo $sqlhis.'<br/>';
		 
		 $sql1="INSERT INTO z_a_historiawyscigTEMP (id_kol, ile) VALUES ('$danhis[0]', 1)";
	         $idzsql1 = mysql_query($sql1) or die('mysql_query');
		 //echo $sql1.'<br/>';
		 
	    }      
	  }
 
          $zapmie = " SELECT id_kol, Sum(ile)
                      FROM z_a_historiawyscigTEMP
                      GROUP BY id_kol
                      ORDER BY Sum(ile) DESC
	  	      ";
          $idzmie = mysql_query($zapmie) or die('mysql_query');
          echo '<h2>Najwięcej 10 ekip</h2>
	  <table class="wyscig" rules="all">
	  <tr><th class="wyscig1">lp</th><th class="wyscig7">ekipa</th><th class="wyscig6">ile razy</th><tr>';
	  $lp=1;
	  $lp2=1;
	  $poprzednio=0;
	  $niebylykropki=true;
          while ($danemie = mysql_fetch_row($idzmie)) 
	  {
	    $sqlhise = " SELECT z_a_historiaekip.nazwa, z_a_historiaekip.id_nat, z_a_historiaekip.skr, z_a_historiaekip.dyw, Nat.flaga, z_a_historiaekip.id_ek 
	                 FROM z_a_historiaekip INNER JOIN Nat ON z_a_historiaekip.id_nat = Nat.id_nat
	                 WHERE z_a_historiaekip.id_ek = '$danemie[0]'
			 ORDER BY z_a_historiaekip.rok DESC";
	    $zaphise = mysql_query($sqlhise) or die('mysql_query');
            $danhise = mysql_fetch_row($zaphise);
            
	    //tu pojawia się tabela najlepszych.
	    
	    if ($poprzednio <> $danemie[1])
	    { 
	      $lp2=$lp;
	      if (($lp2 > 10) and $niebylykropki)
	      {
	        echo '<tr><td class="wyscig1">...</td><td class="wyscig7">...</td><td class="wyscig6">...</td></tr>';
	        $niebylykropki = false;
	      }
	      
	      if  (($lp2 < 11))
	      {
	        echo '<tr><td class="wyscig1">'.$lp.'</td><td class="wyscig7"><img src="http://fff.xon.pl/img/flagi/'.$danhise[4].'" /> <a href="teamh.php?id_team='.$danhise[5].'&rok='.$danhis[2].'">';
		if ($danhise[5] == 1000) {
                     echo zwroc_tekst(22, $jezyk);
	          } elseif ($danhise[5] == 1001) {
                     echo zwroc_tekst(21, $jezyk);
	          } elseif ($danhise[5] == 0) {
                     echo zwroc_tekst(57, $jezyk);
                  } else {
	             echo $danhise[0];
	          }  
		 
		 echo '</a>
		 ';
		
		echo '</td><td class="wyscig6">'.$danemie[1].'</td><tr>';
	      }
	    } else 
	    {
	      if  (($lp2 < 11)) 
	      {
	        echo '<tr><td class="wyscig1"></td><td class="wyscig7"><img src="http://fff.xon.pl/img/flagi/'.$danhise[4].'" /> <a href="teamh.php?id_team='.$danhise[5].'&rok='.$danhis[2].'">';
		if ($danhise[5] == 1000) {
                     echo zwroc_tekst(22, $jezyk);
	          } elseif ($danhise[5] == 1001) {
                     echo zwroc_tekst(21, $jezyk);
	          } elseif ($danhise[5] == 0) {
                     echo zwroc_tekst(57, $jezyk);
                  } else {
	             echo $danhise[0];
	          }  
		 
		 echo '</a>
		 ';
		
		echo '</td><td class="wyscig6">'.$danemie[1].'</td><tr>';
	      }
	      
	    }
	    
	    $lp=$lp+1;
	    $poprzednio = $danemie[1];
	    
	  }
	  echo '</table>';   
          }
	  
	  
	  
	  
          //----------------------------------------------------------
          //Czas na statystyki na początek najwięcej podium ekip:
          //----------------------------------------------------------
          
          $sql="TRUNCATE TABLE z_a_historiawyscigTEMP";
          $idz = mysql_query($sql) or die('mysql_query');
          $zapmie = " SELECT id_wys
                      FROM  z_a_historiawyscig 
                      WHERE z_a_historiawyscig.id_hiswys='$id_hiswys'
                      ";
          //echo $zapmie;
          $idzmie = mysql_query($zapmie) or die('mysql_query');
          while ($danemie = mysql_fetch_row($idzmie)) 
	  {
	     $pytanko=" SELECT Kolarze.id_kol, WynikiP.miejsce, DATE(Wyscigi.dataP)
                        FROM Wyscigi INNER JOIN (WynikiP INNER JOIN Kolarze ON WynikiP.id_kol=Kolarze.id_kol) ON Wyscigi.id_wys = WynikiP.id_wys
                        WHERE WynikiP.id_wys='$danemie[0]' AND WynikiP.miejsce<4 AND WynikiP.id_co=0";
             $idzpytanko = mysql_query($pytanko) or die('mysql_query'); 
             //echo $pytanko.'<br/>
	     //------------------------------------------------<br/><br/>';
	     while ($danepytanko = mysql_fetch_row($idzpytanko)) 
	     {
	         $sqlhis = " SELECT id_do, kiedy, YEAR(kiedy)
		             FROM z_a_historiakol
		             WHERE (id_kol = '$danepytanko[0]') AND (kiedy <= '$danepytanko[2]')
		             ORDER BY kiedy DESC ";
	         $zaphis = mysql_query($sqlhis) or die('mysql_query');
	         $danhis = mysql_fetch_row($zaphis);
		 //echo $sqlhis.'<br/>';
		 
		 $sql1="INSERT INTO z_a_historiawyscigTEMP (id_kol, ile) VALUES ('$danhis[0]', 1)";
	         $idzsql1 = mysql_query($sql1) or die('mysql_query');
		 //echo $sql1.'<br/>';
		 
	    }
	    
	    $pytanko=" SELECT Kolarze.id_kol, Wyniki.miejsce, DATE(Wyscigi.dataP)
                        FROM Wyscigi INNER JOIN (Wyniki INNER JOIN Kolarze ON Wyniki.id_kol=Kolarze.id_kol) ON Wyscigi.id_wys = Wyniki.id_wys
                        WHERE Wyniki.id_wys='$danemie[0]' AND Wyniki.miejsce<4 AND Wyniki.id_co=0";
             $idzpytanko = mysql_query($pytanko) or die('mysql_query'); 
             //echo $pytanko.'<br/>
	     //------------------------------------------------<br/><br/>';
	     while ($danepytanko = mysql_fetch_row($idzpytanko)) 
	     {
	         $sqlhis = " SELECT id_do, kiedy, YEAR(kiedy)
		             FROM z_a_historiakol
		             WHERE (id_kol = '$danepytanko[0]') AND (kiedy <= '$danepytanko[2]')
		             ORDER BY kiedy DESC ";
	         $zaphis = mysql_query($sqlhis) or die('mysql_query');
	         $danhis = mysql_fetch_row($zaphis);
		 //echo $sqlhis.'<br/>';
		 
		 $sql1="INSERT INTO z_a_historiawyscigTEMP (id_kol, ile) VALUES ('$danhis[0]', 1)";
	         $idzsql1 = mysql_query($sql1) or die('mysql_query');
		 //echo $sql1.'<br/>';
		 
	    }      
	  }
 
          $zapmie = " SELECT id_kol, Sum(ile)
                      FROM z_a_historiawyscigTEMP
                      GROUP BY id_kol
                      ORDER BY Sum(ile) DESC
	  	      ";
          $idzmie = mysql_query($zapmie) or die('mysql_query');
          echo '<h2>Najwięcej podium ekip w gen</h2>
	  <table class="wyscig" rules="all">
	  <tr><th class="wyscig1">lp</th><th class="wyscig7">ekipa</th><th class="wyscig6">ile razy</th><tr>';
	  $lp=1;
	  $lp2=1;
	  $poprzednio=0;
	  $niebylykropki=true;
          while ($danemie = mysql_fetch_row($idzmie)) 
	  {
	    $sqlhise = " SELECT z_a_historiaekip.nazwa, z_a_historiaekip.id_nat, z_a_historiaekip.skr, z_a_historiaekip.dyw, Nat.flaga, z_a_historiaekip.id_ek 
	                 FROM z_a_historiaekip INNER JOIN Nat ON z_a_historiaekip.id_nat = Nat.id_nat
	                 WHERE z_a_historiaekip.id_ek = '$danemie[0]'
			 ORDER BY z_a_historiaekip.rok DESC";
	    $zaphise = mysql_query($sqlhise) or die('mysql_query');
            $danhise = mysql_fetch_row($zaphise);
            
	    //tu pojawia się tabela najlepszych.
	    
	    if ($poprzednio <> $danemie[1])
	    { 
	      $lp2=$lp;
	      if (($lp2 > 10) and $niebylykropki)
	      {
	        echo '<tr><td class="wyscig1">...</td><td class="wyscig7">...</td><td class="wyscig6">...</td></tr>';
	        $niebylykropki = false;
	      }
	      
	      if  (($lp2 < 11))
	      {
	        echo '<tr><td class="wyscig1">'.$lp.'</td><td class="wyscig7"><img src="http://fff.xon.pl/img/flagi/'.$danhise[4].'" /> <a href="teamh.php?id_team='.$danhise[5].'&rok='.$danhis[2].'">';
		if ($danhise[5] == 1000) {
                     echo zwroc_tekst(22, $jezyk);
	          } elseif ($danhise[5] == 1001) {
                     echo zwroc_tekst(21, $jezyk);
	          } elseif ($danhise[5] == 0) {
                     echo zwroc_tekst(57, $jezyk);
                  } else {
	             echo $danhise[0];
	          }  
		 
		 echo '</a>
		 ';
		
		echo '</td><td class="wyscig6">'.$danemie[1].'</td><tr>';
	      }
	    } else 
	    {
	      if  (($lp2 < 11)) 
	      {
	        echo '<tr><td class="wyscig1"></td><td class="wyscig7"><img src="http://fff.xon.pl/img/flagi/'.$danhise[4].'" /> <a href="teamh.php?id_team='.$danhise[5].'&rok='.$danhis[2].'">';
		if ($danhise[5] == 1000) {
                     echo zwroc_tekst(22, $jezyk);
	          } elseif ($danhise[5] == 1001) {
                     echo zwroc_tekst(21, $jezyk);
	          } elseif ($danhise[5] == 0) {
                     echo zwroc_tekst(57, $jezyk);
                  } else {
	             echo $danhise[0];
	          }  
		 
		 echo '</a>
		 ';
		
		echo '</td><td class="wyscig6">'.$danemie[1].'</td><tr>';
	      }
	      
	    }
	    
	    $lp=$lp+1;
	    $poprzednio = $danemie[1];
	    
	  }
	  echo '</table>';   
          
	  //----------------------------------------------------------
          //Czas na statystyki na początek najwięcej 10 ekip:
          //----------------------------------------------------------
          
          $sql="TRUNCATE TABLE z_a_historiawyscigTEMP";
          $idz = mysql_query($sql) or die('mysql_query');
          $zapmie = " SELECT id_wys
                      FROM  z_a_historiawyscig 
                      WHERE z_a_historiawyscig.id_hiswys='$id_hiswys'
                      ";
          //echo $zapmie;
          $idzmie = mysql_query($zapmie) or die('mysql_query');
          while ($danemie = mysql_fetch_row($idzmie)) 
	  {
	     $pytanko=" SELECT Kolarze.id_kol, WynikiP.miejsce, DATE(Wyscigi.dataP)
                        FROM Wyscigi INNER JOIN (WynikiP INNER JOIN Kolarze ON WynikiP.id_kol=Kolarze.id_kol) ON Wyscigi.id_wys = WynikiP.id_wys
                        WHERE WynikiP.id_wys='$danemie[0]' AND WynikiP.miejsce<11 AND WynikiP.id_co=0";
             $idzpytanko = mysql_query($pytanko) or die('mysql_query'); 
             //echo $pytanko.'<br/>
	     //------------------------------------------------<br/><br/>';
	     while ($danepytanko = mysql_fetch_row($idzpytanko)) 
	     {
	         $sqlhis = " SELECT id_do, kiedy, YEAR(kiedy)
		             FROM z_a_historiakol
		             WHERE (id_kol = '$danepytanko[0]') AND (kiedy <= '$danepytanko[2]')
		             ORDER BY kiedy DESC ";
	         $zaphis = mysql_query($sqlhis) or die('mysql_query');
	         $danhis = mysql_fetch_row($zaphis);
		 //echo $sqlhis.'<br/>';
		 
		 $sql1="INSERT INTO z_a_historiawyscigTEMP (id_kol, ile) VALUES ('$danhis[0]', 1)";
	         $idzsql1 = mysql_query($sql1) or die('mysql_query');
		 //echo $sql1.'<br/>';
		 
	    }
	    
	    $pytanko=" SELECT Kolarze.id_kol, Wyniki.miejsce, DATE(Wyscigi.dataP)
                        FROM Wyscigi INNER JOIN (Wyniki INNER JOIN Kolarze ON Wyniki.id_kol=Kolarze.id_kol) ON Wyscigi.id_wys = Wyniki.id_wys
                        WHERE Wyniki.id_wys='$danemie[0]' AND Wyniki.miejsce<11 AND Wyniki.id_co=0";
             $idzpytanko = mysql_query($pytanko) or die('mysql_query'); 
             //echo $pytanko.'<br/>
	     //------------------------------------------------<br/><br/>';
	     while ($danepytanko = mysql_fetch_row($idzpytanko)) 
	     {
	         $sqlhis = " SELECT id_do, kiedy, YEAR(kiedy)
		             FROM z_a_historiakol
		             WHERE (id_kol = '$danepytanko[0]') AND (kiedy <= '$danepytanko[2]')
		             ORDER BY kiedy DESC ";
	         $zaphis = mysql_query($sqlhis) or die('mysql_query');
	         $danhis = mysql_fetch_row($zaphis);
		 //echo $sqlhis.'<br/>';
		 
		 $sql1="INSERT INTO z_a_historiawyscigTEMP (id_kol, ile) VALUES ('$danhis[0]', 1)";
	         $idzsql1 = mysql_query($sql1) or die('mysql_query');
		 //echo $sql1.'<br/>';
		 
	    }      
	  }
 
          $zapmie = " SELECT id_kol, Sum(ile)
                      FROM z_a_historiawyscigTEMP
                      GROUP BY id_kol
                      ORDER BY Sum(ile) DESC
	  	      ";
          $idzmie = mysql_query($zapmie) or die('mysql_query');
          echo '<h2>Najwięcej 10 ekip w gen</h2>
	  <table class="wyscig" rules="all">
	  <tr><th class="wyscig1">lp</th><th class="wyscig7">ekipa</th><th class="wyscig6">ile razy</th><tr>';
	  $lp=1;
	  $lp2=1;
	  $poprzednio=0;
	  $niebylykropki=true;
          while ($danemie = mysql_fetch_row($idzmie)) 
	  {
	    $sqlhise = " SELECT z_a_historiaekip.nazwa, z_a_historiaekip.id_nat, z_a_historiaekip.skr, z_a_historiaekip.dyw, Nat.flaga, z_a_historiaekip.id_ek 
	                 FROM z_a_historiaekip INNER JOIN Nat ON z_a_historiaekip.id_nat = Nat.id_nat
	                 WHERE z_a_historiaekip.id_ek = '$danemie[0]'
			 ORDER BY z_a_historiaekip.rok DESC";
	    $zaphise = mysql_query($sqlhise) or die('mysql_query');
            $danhise = mysql_fetch_row($zaphise);
            
	    //tu pojawia się tabela najlepszych.
	    
	    if ($poprzednio <> $danemie[1])
	    { 
	      $lp2=$lp;
	      if (($lp2 > 10) and $niebylykropki)
	      {
	        echo '<tr><td class="wyscig1">...</td><td class="wyscig7">...</td><td class="wyscig6">...</td></tr>';
	        $niebylykropki = false;
	      }
	      
	      if  (($lp2 < 11))
	      {
	        echo '<tr><td class="wyscig1">'.$lp.'</td><td class="wyscig7"><img src="http://fff.xon.pl/img/flagi/'.$danhise[4].'" /> <a href="teamh.php?id_team='.$danhise[5].'&rok='.$danhis[2].'">';
		if ($danhise[5] == 1000) {
                     echo zwroc_tekst(22, $jezyk);
	          } elseif ($danhise[5] == 1001) {
                     echo zwroc_tekst(21, $jezyk);
	          } elseif ($danhise[5] == 0) {
                     echo zwroc_tekst(57, $jezyk);
                  } else {
	             echo $danhise[0];
	          }  
		 
		 echo '</a>
		 ';
		
		echo '</td><td class="wyscig6">'.$danemie[1].'</td><tr>';
	      }
	    } else 
	    {
	      if  (($lp2 < 11)) 
	      {
	        echo '<tr><td class="wyscig1"></td><td class="wyscig7"><img src="http://fff.xon.pl/img/flagi/'.$danhise[4].'" /> <a href="teamh.php?id_team='.$danhise[5].'&rok='.$danhis[2].'">';
		if ($danhise[5] == 1000) {
                     echo zwroc_tekst(22, $jezyk);
	          } elseif ($danhise[5] == 1001) {
                     echo zwroc_tekst(21, $jezyk);
	          } elseif ($danhise[5] == 0) {
                     echo zwroc_tekst(57, $jezyk);
                  } else {
	             echo $danhise[0];
	          }  
		 
		 echo '</a>
		 ';
		
		echo '</td><td class="wyscig6">'.$danemie[1].'</td><tr>';
	      }
	      
	    }
	    
	    $lp=$lp+1;
	    $poprzednio = $danemie[1];
	    
	  }
	  echo '</table>';  
	  
	  
	  
	  
	  
	  echo'	  
	  <br/><br/>
	  Statystyki są liczone od 2005 roku.';
	  
	  
	  
	  
	  ?>
	   <br/> <br/>
	   
	   </div>

<?php 

    koniec();

?>       

</body>
</html>
    
