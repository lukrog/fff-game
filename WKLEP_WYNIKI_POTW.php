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
   <title>FFF - obliczanie wyścigu</title>
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
         $id_wys =  $_POST['idwys'];
         echo '<input type="hidden" name="idwys" value="'.$_POST['itwys'].'" />';  
         if ($_SESSION['boss'] >= 1) {
	 $zap = " SELECT Wyscigi.id_wys, Wyscigi.nazwa, Nat.id_nat, Nat.nazwa, Nat.flaga, Wyscigi.klaUCI, Wyscigi.klaPC, DATE(Wyscigi.dataP), Wyscigi.dataK FROM Wyscigi INNER JOIN Nat ON Wyscigi.id_nat = Nat.id_nat WHERE (((Wyscigi.id_wys)= '$id_wys' ))";
	  $idz = mysql_query($zap) or die('mysql_query');
  	  $dane = mysql_fetch_row($idz);
  	  
  	  //zaczynamy formularz zatwierdzający!!!!
  	  echo '<form action="WKLEP_WYNIKI_POTW_EXE.php" method="post">
	       ';
	  echo '<input type="hidden" name="idwys" value="'.$id_wys.'" />';     
	       
	  echo '<table id="menu2">';
          echo '<tr><td><i>id wyścigu: </i></td><td>'.$id_wys.'</td></tr> 
	        <tr><td><i>nazwa wyścigu: </i></td><td>[size=20]'.$dane[1].'[/size]</td></tr> 
		<tr><td><i>kraj rozgrywania: </i></td><td>'.$dane[3].' <img src="img/flagi/'.$dane[4].'" alt="'.$dane[3].'"/></td></tr> 
		<tr><td><i>klasyfikacja UCI: </i></td><td>'.$dane[5].'</td></tr> 
		<tr><td><i>klasyfikacja P-C: </i></td><td>'.$dane[6].'</td></tr> 
		<tr><td><i>Data początku: </i></td><td>'.$dane[7].'</td></tr> 
		<tr><td><i>Data końca: </i></td><td>'.$dane[8].'</td></tr>
		';
          
	  //Sprawdzamy ile dni trwa wyścig.
          $ile_dni_różnicy = strtotime($dane[8]) - strtotime($dane[7]);
          $ile_dni_różnicy = date('d',$ile_dni_różnicy);
          echo '<tr><td><i>w związku z tym trwa dni: </i></td><td>'.$ile_dni_różnicy.'</td></tr>';
          //czy to jedno czy wieloetapowy.
          if ($ile_dni_różnicy == 1) {
            $jaki_wyscig = "jednodniowy";
          } else {
            $jaki_wyscig = "wielodniowy";
          }
          echo '<tr><td><i>i jest to wyścig:</i></td><td>'.$jaki_wyscig.'</td></tr>
	       ';
          
          //sprawdzamy, czy był dodatkowy etap:
          echo '<input type="hidden" name="dod" value="'.$_POST['dod'].'" />';  
          if ($_POST['dod'] == "on") {
             $ile_dni_różnicywyslane = $ile_dni_różnicy + 1;
          } else {
             $ile_dni_różnicywyslane = $ile_dni_różnicy;
          }
          echo '<tr><td><i>a to będzie etapów: </i></td><td>'.$ile_dni_różnicywyslane.'</td></tr>
	       ';
	  
	  echo '<tr><td><i>podaj kategorię wyścigu: </i></td><td>'.$_POST['kat'].'</td></tr>
	        <tr><td><i>podaj punktację wyścigu: </i></td><td>'.$_POST['pun'].'</td></tr>
	       ';
	  // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!11
	  echo '<input type="hidden" name="kat" value="'.$_POST['kat'].'" />';     
	  echo '<input type="hidden" name="pun" value="'.$_POST['pun'].'" />';   
	  //Za drugim razem też rozbijemy.
	  echo '<input type="hidden" name="wynikiKON" value="'.$_POST['wynikiKON'].'" />';   
	  
	  	  //podaj to do formularza jako hiden dalej
	  
	  echo '</table>
	        ';
	 
	 
         echo '<h5><font color=green>Klasyfikacja końcowa </font></h5> wpisałeś to:<br/>
	      Kategoria '.$_POST['kat1_00'].' -=- Peleton '.$_POST['peleton_00'].' dnia: '.$_POST['data00'].'<br/>
	      
	      <input type="hidden" name="kat1_00" value="'.$_POST['kat1_00'].'" />
	      <input type="hidden" name="peleton_00" value="'.$_POST['peleton_00'].'" />
	      <input type="hidden" name="data00" value="'.$_POST['data00'].'" />
	      ';   
                
         
         //Rozbicie na części tych co dojechali
         $miejsca=explode(";",$_POST["wynikiKON"]);
	 
	 echo '<br/>wpisano '.count($miejsca).' miejsc <br/>'; 
	 echo 'Analizuję zawodników wg nazwiska imienia i narodowości<br/><br/>';
	 
	 for($i=0;$i<count($miejsca)-1;$i++)
         {
            $danekol=explode("|",$miejsca[$i]);
            
            
            
	    echo $danekol[0].'. '.$danekol[2].' ('.$danekol[1].') - '.$danekol[3]." = ".$danekol[4].' w bazie ma numer: ';
	    $kolzap = "SELECT idkol, nazw, nat FROM Kolarze_nazw WHERE nazw = \"".$danekol[2]."\" AND nat = \"".$danekol[1]."\" ";
	    $kolzapX = mysql_query($kolzap) or die('mysql_query');
  	    $Kolarz = mysql_fetch_row($kolzapX);
  	    
  	    //warto by sprawdzić czy ekipa o tym skrócie istnieje u nas w bazie
                         $sql_o_ekipien = "SELECT `id_team` FROM `Ekipy` WHERE skr = \"".$danekol[3]."\" ";
		         $zap_o_ekipien = mysql_query($sql_o_ekipien) or die('mysql_query');
		         if (mysql_num_rows($zap_o_ekipien) == 0) {
		           echo '<br/><font color=orange> Nie znaleziono ekipy o skrócie <b>'.$danekol[3].'</b> (może wyedytuj skróty ekip)</font><br/>';
			   } else {
			     //a tu można sprawdzić czy kolarz ma to samo id co tu...
			     $id_ekipy_ze_skrotu = mysql_fetch_row($zap_o_ekipien);
			     //wiemy już że skrót ekipy ma id $id_ekipy_ze_skrotu[0]
			     
			     //sprawdzamy id_team z Kolarzy
			     $sql_ekipa_kolarza = "SELECT id_team FROM Kolarze WHERE id_kol = '$Kolarz[0]'";
			     $idz_ekipa_kolarza = mysql_query($sql_ekipa_kolarza) or die('mysql_query');
			     
			     $ekipa_kolarza = mysql_fetch_row($idz_ekipa_kolarza);
			     
			     if ($ekipa_kolarza[0] == $id_ekipy_ze_skrotu[0]) {
			       //Ekipa z bazy i wyników kolarza się zgadza
			       //echo 'ekipa OK!';
			     } else {
			       echo '<br/><font color=orange>Ekipa z wyników nie zgadza się z ekipą z bazy kolarza</font>
			             <br/> <a href="kolr.php?id_kol='.$Kolarz[0].'#Hist" target="_blank">
				     Wejdź na stronę kolarza by wyedytować jego transfery</a>
				     <br/> Ale może też tak zostać ';
			     }
			     
			   }
  	    
  	    
  	    if ($Kolarz[0] > 0) {
	           echo ' <b>'.$Kolarz[0].'</b>';
	        } else {
    	           echo '<font color="red">uwaga nie ma kolarza w bazie?</font> <br/> 
		         <font color="blue">Jeśli istnieje to znajdź kolarza w nowej karcie i tam dodaj<br/>mu nową pisownię nazwiska</font>
		         <font color="green">Bądż edytuj jego dane</font><br/>
		         <font color="violet">Jeśli nie to tu <a href="kol_DODAJ.php" target="_blank">link do stworzenia kolarza</a></font><br/>
		         ';
		         //wypadałoby dodać link do ekipy
		         
		         $sql_o_ekipie = "SELECT `id_team` FROM `Ekipy` WHERE skr = \"".$danekol[3]."\" ";
		         //echo $sql_o_ekipie;
		         $zap_o_ekipie = mysql_query($sql_o_ekipie) or die('mysql_query');
		         if (mysql_num_rows($zap_o_ekipie) > 0) {
		           $dane_o_ekipie = mysql_fetch_row($zap_o_ekipie);
			   echo ' Tu link do ekipy w której powinien być: <a href="team.php?id_team='.$dane_o_ekipie[0].'" target="_blank">'.$danekol[3].'</a> (kliknij środkowym przyciskiem - nowa karta)';
			 } else {
			   echo ' nie znaleziono ekipy o skrócie '.$danekol[3].' ';
			 }
		echo '<br/>';	 

                }
	    echo '<br/>';
         }
         //rozbicie na części tych co nie dojechali
	 $miejsca=explode(";",$_POST["wynikiDNE"]);
	 
	 echo '<input type="hidden" name="wynikiDNE" value="'.$_POST['wynikiDNE'].'" />';     
	 
	 echo '<br/><br/><font color=green><b>Nie ukończyli </b></font>(wpisano '.count($miejsca).' miejsc) <br/>'; 
	 echo 'Analizuję zawodników wg nazwiska imienia i narodowości<br/><br/>';
	 //echo '1 = '.$miejsca[0].'<br/>';
	 //echo '2 = '.$miejsca[1].'<br/><br/>';
	 for($i=0;$i<count($miejsca)-1;$i++)
         {
            $danekol=explode("|",$miejsca[$i]);
	    echo $danekol[0].'. '.$danekol[2].' ('.$danekol[1].') - '.$danekol[3]." = ".$danekol[4].' w bazie ma numer: ';
	    $kolzap = "SELECT idkol, nazw, nat FROM Kolarze_nazw WHERE nazw = \"".$danekol[2]."\" AND nat = \"".$danekol[1]."\" ";
	    $kolzapX = mysql_query($kolzap) or die('mysql_query');
  	    $Kolarz = mysql_fetch_row($kolzapX);
  	    
  	    //echo '<br/>'.$kolzap.' ';
  	    if ($Kolarz[0] > 0) {
	           echo ' <b>'.$Kolarz[0].'</b>';
	        } else {
    	           echo '<font color="red">uwaga nie ma kolarza w bazie?</font> <br/> 
		         <font color="blue">Jeśli istnieje to tu link do dodania nowej pisowni bądź narodowości</font><br/>
		         <font color="green">Edytuj kolarza i dodaj nową pisownię lub narodowość</font><br/>
		         <font color="violet">Jeśli nie to tu <a href="kol_DODAJ.php" target="_blank">link do stworzenia kolarza</a></font><br/>
		         ';
                }
	    echo '<br/>';
         }
         
         //teraz jeśli to była jednoetapówka to już koniec, a jak nie to dzieje się to:
         echo 'ile dni różnicy '.$ile_dni_różnicy.'<br/>';
         
         //echo 'WIPS -> '.$_POST["wyniki_10"];
         
         if ($ile_dni_różnicy == 1) {
	   // w sumie to nic się nie dzieje jak jest 1 dzień
	 } else {
	   //jeśli jednak trwa więcej niż jeden dzień to mamy etapówkę i trzeba sprawdzić lidera
	    //rozbicie na części tych co liderowali
	 //echo 'lid -> '.$_POST["wyniki_10lider"].'   <br/>';
	 
	 $miejsca = explode(";",$_POST["wyniki_10lider"]);
	 
	 echo '<input type="hidden" name="wyniki_10lider" value="'.$_POST['wyniki_10lider'].'" />'; 
	 
	 echo '<br/><br/><font color=green><b>liderzy etapów </b></font>(wpisano '.count($miejsca).' miejsc) <br/>'; 
	 echo 'Analizuję liderów wg nazwiska imienia i narodowości<br/><br/>';
	
	 for($i=0;$i<count($miejsca)-1;$i++)
         {
            $danekol=explode("|",$miejsca[$i]);
	    echo $danekol[0].'. '.$danekol[2].' ('.$danekol[1].') - '.$danekol[3]." = ".$danekol[4].' w bazie ma numer: ';
	    $kolzap = "SELECT idkol, nazw, nat FROM Kolarze_nazw WHERE nazw = \"".$danekol[2]."\" AND nat = \"".$danekol[1]."\" ";
	    $kolzapX = mysql_query($kolzap) or die('mysql_query');
  	    $Kolarz = mysql_fetch_row($kolzapX);
  	    
  	    //echo '<br/>'.$kolzap.' ';
  	    if ($Kolarz[0] > 0) {
	           echo ' <b>'.$Kolarz[0].'</b>';
	        } else {
    	           echo '<font color="red">uwaga nie ma kolarza w bazie?</font> <br/> 
		         <font color="blue">Jeśli istnieje to tu link do dodania nowej pisowni bądź narodowości</font><br/>
		         <font color="green">Edytuj kolarza i dodaj nową pisownię lub narodowość</font><br/>
		         <font color="violet">Jeśli nie to tu <a href="kol_DODAJ.php" target="_blank">link do stworzenia kolarza</a></font><br/>
		         ';
                }
	    echo '<br/>';
         }
         //koniec liderów
         
         
         
         echo '<br/><br/>';
         //zaczynamy etapy
         echo '<input type="hidden" name="pro" value="'.$_POST['pro'].'" />';  
         if ($_POST['pro'] == "on") {
	      echo 'pro='.$_POST['pro'].' - był prolog więc zaczynamy od etapu 0 (1000)<br/><br/>';
	      $poczatek = 0;
	    } else {
	      echo 'pro='.$_POST['pro'].' - prologu nie było więc zaczynamy od etapu 1 (1010) [bo np etap 1a to 1011 a 4b to 1042]<br/><br/>';
	      $poczatek = 1;
	    }
         for ($i=$poczatek; $i <= $ile_dni_różnicywyslane+$poczatek+1; $i++) {
	   //lecimy po etapach:
	    
	   echo '<br/><br/><b><font color=green>'.$i.' etap ('.$_POST["etap".$i.""].')</font></b><br/>
	        data: '.$_POST["data".$i.""].'<br/>
		Peleton dojechał na miejscu '.$_POST["peleton_".$i.""].' = 
		kategoria wyścigu: '.$_POST["kat1_".$i.""].'<br/>
		';
		
	   echo '<input type="hidden" name="wyniki_'.$i.'" value="'.$_POST['wyniki_'.$i.''].'" />';
	   echo '<input type="hidden" name="etap'.$i.'" value="'.$_POST['etap'.$i.''].'" />';
	   echo '<input type="hidden" name="peleton_'.$i.'" value="'.$_POST['peleton_'.$i.''].'" />';	
	   echo '<input type="hidden" name="kat1_'.$i.'" value="'.$_POST['kat1_'.$i.''].'" />';
	   echo '<input type="hidden" name="data'.$i.'" value="'.$_POST['data'.$i.''].'" />';
	   //rozbicie na części tych z etapów
	   $miejsca=explode(";",$_POST["wyniki_".$i.""]);
	
	   for($j=0;$j<count($miejsca)-1;$j++)
           {
            $danekol=explode("|",$miejsca[$j]);
	    echo $danekol[0].'. '.$danekol[2].' ('.$danekol[1].') - '.$danekol[3]." = ".$danekol[4].' w bazie ma numer: ';
	    $kolzap = "SELECT idkol, nazw, nat FROM Kolarze_nazw WHERE nazw = \"".$danekol[2]."\" AND nat = \"".$danekol[1]."\" ";
	    $kolzapX = mysql_query($kolzap) or die('mysql_query');
  	    $Kolarz = mysql_fetch_row($kolzapX);
  	    
  	    //echo '<br/>'.$kolzap.' ';
  	    if ($Kolarz[0] > 0) {
	           echo ' <b>'.$Kolarz[0].'</b>';
	        } else {
    	           echo '<font color="red">uwaga nie ma kolarza w bazie?</font> <br/> 
		         <font color="blue">Jeśli istnieje to tu link do dodania nowej pisowni bądź narodowości</font><br/>
		         <font color="green">Edytuj kolarza i dodaj nową pisownię lub narodowość</font><br/>
		         <font color="violet">Jeśli nie to tu <a href="kol_DODAJ.php" target="_blank">link do stworzenia kolarza</a></font><br/>
		         ';
                }
	    echo '<br/>';
           }
	  }
         
	 } //tu koniec etapówek
         
	 
	 echo '<br/><br/><font color=green>A teraz po dodaniu wszystkich kolarzy odśwież tą stronę (sprawdzając wcześniej czy jesteś zalogowany) i sprawdź czy wszystko się naprawiło.</font>
	      <br/><input class="form2" type=submit value="Zatwierdź" />
	      </form>
	      ';
	      
	
	      
	 } else {
           echo '<h4>Nie masz uprawnień do tej strony</h4>';
         }
         
         
         
         
         echo koniec();
      ?>
  
    
    
    
   
