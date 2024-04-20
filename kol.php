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
   <title>FFF - kolarz</title>
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
    
    
    
    
    
	$id_kol = $_GET['id_kol'];
	$dzis=date("Y-m-d");
	$czyTrans="NIE";
	$czyFA="NIE";
        $sql1 = " SELECT dok, typ FROM wydarzenia "
              . " WHERE dataP <= '$dzis' AND dataK >= '$dzis' AND typ = 1 ";
        $zap1  = mysql_query($sql1) or die('mysql_query');
        if(mysql_num_rows($zap1) > 0) {
          $czyTrans="OK";
        }
        $sql2 = " SELECT dok, typ FROM wydarzenia "
              . " WHERE dataP <= '$dzis' AND dataK >= '$dzis' AND typ = 2 ";
        $zap2  = mysql_query($sql2) or die('mysql_query');
        if(mysql_num_rows($zap2) > 0) {
          $czyFA="OK";
        }
        $sql213 = " SELECT dok, typ FROM wydarzenia "
                . " WHERE dataP <= '$dzis' AND dataK >= '$dzis' AND typ = 3 ";
        $zap213  = mysql_query($sql213) or die('mysql_query');
        if(mysql_num_rows($zap213) > 0) {
          $czyFA="OK2";
        }
        
          //zmienione	  
	  //$sql = " SELECT Kolarze.imie , Kolarze.nazw, Kolarze.dataU , Nat.nazwa , Nat.flaga , Ekipy.nazwa , User.ekipa, Kolarze.id_team, Kolarze.id_nat, Kolarze.przed, User.id_user, Kolarze.dataU, Kolarze.cena, Kolarze.pts_poprz, User.login, Kolarze.zdjecie "
          //     . " FROM User INNER JOIN ( Ekipy INNER JOIN ( Nat INNER JOIN Kolarze ON Nat.id_nat = Kolarze.id_nat ) ON Ekipy.id_team = Kolarze.id_team ) ON User.id_user = Kolarze.id_user "
          //     . " WHERE  Kolarze.id_kol  = '$id_kol' ";
               
          $sql = " SELECT Kolarze.imie , Kolarze.nazw, Kolarze.dataU , Nat.nazwa , Nat.flaga , Ekipy.nazwa , User.ekipa, Kolarze.id_team, Kolarze.id_nat, Kolarze.przed, User.id_user, Kolarze.dataU, Kolarze.cena, Kolarze.pts_poprz, User.login, Kolarze.zdjecie "
               . " FROM User, Ekipy, Nat, Kolarze "
               . " WHERE  Kolarze.id_kol  = '$id_kol' AND Nat.id_nat = Kolarze.id_nat AND Ekipy.id_team = Kolarze.id_team AND User.id_user = Kolarze.id_user ";
	       
               
          $idzapytania = mysql_query($sql) or die(mysql_error());
          
          $dane = mysql_fetch_row($idzapytania);
          echo '<img src="'.$dane[15].'" alt="zdjęcie: '.$dane[0].' '.$dane[1].'" align=right />
	  <table id="menu2">
	    <tr><td class="wyscig2"><i>id kolarza: </i></td><td class="wyscig2">'.$id_kol.'</td></tr>
	    <tr><td><i>kolarz: </i></td><td>'.$dane[0].' <b>'.$dane[1].'</b></td></tr>
	    <tr><td></td></tr>
	    <tr><td><i>data urodzenia: </i></td><td>'.$dane[2].'</td></tr>
	    ';
          $dzis = strtotime(date("Y-m-d"));
	  $wiek = strtotime($dane[2]);
	  $wiek = $dzis - $wiek;
	  $wiek = floor($wiek / (3600 * 24 * 365));
	  echo '<tr><td><i>wiek: </i></td><td>'.$wiek.'</td></tr>
	  <tr><td><i>narodowość: </i></td><td><a href="nat.php?id_nat='.$dane[8].'">'.$dane[3].'</a> <img src="img/flagi/'.$dane[4].'" alt="'.$dane[3].'"/></td></tr>
	  <tr><td><i>ekipa: </i></td><td><a href="team.php?id_team='.$dane[7].'">'.$dane[5].'</a></td></tr>
	  ';
	  
          if($_SESSION['logowanie'] == 'poprawne') 
	  {
            echo '<tr><td></td></tr>
	    <tr><td><i>drużyna fff:</i></td><td><a href="user.php?id_user='.$dane[10].'">'.$dane[6].'</a> <i>'.$dane[14].'</i></td></tr><tr><td><i>cena kolarza:</i></td><td>'.$dane[12].'</td></tr>';
	    echo '<tr><td><i>punkty w poprz. sez.:</i></td><td>'.$dane[13].'</td></tr>
	    ';
	  } else {}
	  
	  $pun = 0;
	  
	  $pocz = 1000 * (date("Y"-2000));
	  $kon = 1000 * (date("Y")+1-2000);
  	  $sql113 = "SELECT punkty FROM Wyniki WHERE id_kol = '$id_kol' AND id_wys > '$pocz' AND id_wys < '$kon'";
	  $zap113 = mysql_query($sql113) or die('mysql_query');
  	  while ($dan113 = mysql_fetch_row($zap113)) {
            $pun = $pun + $dan113[0];
          }
          echo '<tr><td><i>punkty: </i></td><td>'.$pun.'</td></tr>
	  ';
	  
	  if ($_SESSION['boss'] >= 1) {
	     echo '<tr><td><br/><i>--------------------------------</i></td><td><br/>-----------B-O-S-S--------------------</td></tr>
	           <tr><td><i>edytuj kolarza: </i></td><td><a href=kol_EDIT.php?id_kol='.$id_kol.'>EDYCJA KOLARZA</a></td></tr>
	           <tr><td>.</td><td></td></tr>
	           <tr><td>.</td><td></td></tr>
	           <tr><td><i>kolarz występuje w bazie jako:</td><td>';
	     $sql_nazwiska =  "SELECT nazw, nat FROM Kolarze_nazw WHERE idkol = '$id_kol'"; 
	     $zap_nazwiska = mysql_query($sql_nazwiska) or die('mysql_query'); 
	     while ($dan113 = mysql_fetch_row($zap_nazwiska)) {
                echo '- '.$dan113[0].' ('.$dan113[1].')<br/>';
             } 
	     echo '</td></tr>';  
	     //edycja nazwiska do wklepywania wyników
	     echo '<tr><td>dodaj nazwisko do wyników:</td><td>';
	     //dodajemy formularz z dodaniem nazwiska :D
	     echo '<form action="kol_nazw_EXE.php?id_kol='.$id_kol.'" method="POST"> 
	            
		    <input class="form" type="input" name="nazw" /> 
		     ';
		  
	     
	     
	     $sql_narodowosci = "SELECT id_nat, skr, flaga, nazwa FROM Nat WHERE id_nat >0 ORDER BY nazwa ";
	     
	     $zap_narodowosci = mysql_query($sql_narodowosci) or die('mysql_query'); 
	     echo ' <select class="form4"  name="narodowosc">';
	     while ($dan_narodowosci = mysql_fetch_row($zap_narodowosci)) {
                
		//echo $dan_narodowosci[2];
		echo '<option value="'.$dan_narodowosci[1].'" ';
                if ($dan_narodowosci[2] == $dane[4]) {
		   echo ' selected="selected" ';
		}
                echo ' style="background-image: url(http://fff.xon.pl/img/flagi/'.$dan_narodowosci[2].'); background-repeat:no-repeat; padding-left: 21px;" >'.$dan_narodowosci[1].'</option>
		';
		
             } 
             
	     echo '</select>';	  
		     
	     echo '
		     <input class="form2" type=submit value="Dodaj" /> 
		   </form></td></tr> ';
	     
	  echo '<tr><td>Zmieniano</td><td>';
	  // teraz możnaby wyświetlić ostatnie zmiany wykonane w tym kolarzu :D
	  $sql_a_edyt = "SELECT  id_edyt, było, jest, kto, kiedy, co, id FROM a_edycje WHERE co=\"KO\" AND id=".$id_kol." ORDER BY kiedy DESC LIMIT 0, 5 ";
	  $idz_a_edyt = mysql_query($sql_a_edyt) or die('mysql_query');
  	  while ($dane_a_edyt = mysql_fetch_row($idz_a_edyt)) {
	      echo 'użytkownik: '.$dane_a_edyt[3].', dnia: '.$dane_a_edyt[4].' <br/>zmienił z '.$dane_a_edyt[1].'<br/>na '.$dane_a_edyt[2].'<br/><br/>';
	    }
	  echo '</td></tr>';  
	  
	  }
	  
	  echo '</table><br/><br/>
	  
	  <a href=\'kolr.php?id_kol='.$id_kol.'\'>kliknij by rozwinąć listę wyników kolarza</a> <br/>
	  <a href=\'SK/kol.php?id_kol='.$id_kol.'\' target=new>kliknij by przejść do skarbu kibica</a> 
	  
	  <br/><br/>
	  
	  ';
          
          
         if($_SESSION['logowanie'] == 'poprawne') 
	 {	
	  echo '<h5>Licytacje, transfery itp</h5>
	  
	  ';
	   if ($dane[10] == $idek) {
	     echo 'To jest Twój kolarz <br/>
	     Możesz go zwolnić <a href="kolZ.php?id_kol='.$id_kol.'">Przejdź do strony zwolnień</a>
	     ';
	   } else {	    
	     if ($dane[10] > 0) {
	       if ($czyTrans == "OK") {
	         $sql123 = "SELECT id_kol FROM transzaak WHERE id_kol='$id_kol' AND (typ = 0 OR typ = 3)";
	         $zap123 = mysql_query($sql123) or die('mysql_query');

                 if (mysql_num_rows($zap123) >= 2) {
	              echo ' Ten kolarz już 2 razy zmienił barwy w tym sezonie<br/><br/>
		      ';
                 } else {
                    if (mysql_num_rows($zap123) == 1) {
	              echo '<font color=red> Ten kolarz zmienił już raz barwy w tym sezonie <br/> Jeśli go kupisz nie będziesz mógł już go sprzedać</font><br/><br/>
		      ';
                    }
 	            echo ' Podaj kwotę za którą chciałbyś kupić kolarza:
		      <form action="kolT.php?id_kol='.$id_kol.'" method="POST"> 
		        <input class="form" type="input" name="ile" /> CR 
		        <input class="form2" type=submit value="Zaproponuj transfer" /> 
		      </form> 
		      ';
                    
//-----------------------------------------------------------------------------------------------------                        
                        echo 'lub wymień go na:
			
			
			<form action="transW.php?id_kol='.$id_kol.'" method="POST">
			  <select class="form3"  name="zakogo">
			  ';
                        
                        $sqlp6 = " SELECT imie, nazw, id_kol FROM Kolarze WHERE id_user = '$idek' ";
                        $zapp6 = mysql_query($sqlp6) or die('mysql_query');
                        while ($danp6 = mysql_fetch_row($zapp6)) {  
			  echo '  <option value='.$danp6[2].'>'.$danp6[0].' <b>'.$danp6[1].'</b></OPTION>
			  ';
			}

                        echo '</select>
			 <input class="form2" type=submit value="Proponuj transfer" />
                        </form>';
                        
//-----------------------------------------------------------------------------------------------------
                    
                   }
                } else {
                  echo ' Okno transferowe zamknięte
		  ';
                }
           
             }
             if ($czyFA == "OK") {
               if ($dane[10] == 0) {
	         echo ' Podaj kwotę za którą chciałbyś licytować kolarza:
		   <form action="licyt.php?id_kol='.$id_kol.'" method="POST">
		   <input class="form" type="input" name="ile" /> CR
		   <input class="form2" type=submit value="Licytuj kolarza" />
		 </form>';
               } else {
                 echo 'Nie możesz licytować kolarza, który należy do kogoś innego
		 ';
               }
	       } elseif ($czyFA == "OK2") {
                 if ($dane[10] == 0) {
                 $sql4321 = " SELECT data "
                          . " FROM licytacje "
                          . " WHERE id_kol = '$id_kol' "
                          . " ORDER BY data DESC "
		          . " LIMIT 0, 1 ";
                 $zap4321 = mysql_query($sql4321) or die('mysql_query');
                 $dan4321 = mysql_fetch_row($zap4321);
             
                 $dane24pobidzie = strtotime($dan4321[0]) + 24 * 3600;
                 $dane24pobidzie = date("Y-m-d H:i:s",$dane24pobidzie);

                 $czasa = date("Y-m-d H:i:s");
               
                 if ($czasa > $dane24pobidzie ) 
	         { 
                   echo 'Licytacja zakończona z powodu braku aktywności przez 24 godziny
		   ';
	         } else 
		 {
		 //---------------------------------------------
		 //-  Sprawdzam czy danego kolarza licytowałeś -
		 //---------------------------------------------
		 
		 $sql513 = " SELECT id_kol, id_user "
                         . " FROM licytacje "
                         . " WHERE id_kol = '$id_kol' AND id_user = '$idek' ";
                 $zap513 = mysql_query($sql513) or die('mysql_query');
                 if ( mysql_num_rows($zap513) >0 ) {
		   
	         echo ' Podaj kwotę za którą chciałbyś licytować kolarza:
		  <form action="licyt.php?id_kol='.$id_kol.'" method="POST">
		    <input class="form" type="input" name="ile" /> CR
		    <input class="form2" type=submit value="Licytuj kolarza" />
		  </form>
		  
		  Wybierz 0 by się wycofać z licytacji';
                 
                 
               $sqll1 = " SELECT User.login, licytacje.ile, licytacje.data "
                      . " FROM User, licytacje "
                      . " WHERE licytacje.id_kol = '$id_kol' AND User.id_user = licytacje.id_user "
                      . " ORDER BY licytacje.ile desc, licytacje.data, licytacje.id_lic ";
               $zapl1 = mysql_query($sqll1) or die('mysql_query');       
               
               echo '<table id="menu2">
	       <tr><td class="wyscig2">licytujący</td><td class="wyscig2">ile</td><td class="wyscig2">kiedy</td></tr>
	       ';
               
               while ($danl1 = mysql_fetch_row($zapl1)) {
                 echo '<tr><td class="wyscig2">'.$danl1[0].'</td><td class="wyscig2">'.$danl1[1].'</td><td class="wyscig2">'.$danl1[2].'</td></tr>
		 ';
               }
               echo '</table>
	       ';
                 
                 
                 } else {
                   echo ' Tego kolarza nie licytowałeś do tej pory. <br/> Nie możesz dołączać do licytacji w tracie II rundy 
		   ';
                 }
                 }
               } else {
                 echo 'Nie możesz licytować kolarza, który należy do kogoś innego
		 ';
               }	    
	     } else { 
	       echo' Licytacje zamknięte
	       ';
	     }
	     
	     
	     //----------------------------------------------------------
	     // Do wklejenia 3 runda licytacji //
	     //----------------------------------------------------------
	     
	     if ($_SESSION['boss'] > 2 AND (($idek == 20) OR ($czyFA == "OK2"))){
               
               $sqll1 = " SELECT User.login, licytacje.ile, licytacje.data "
                      . " FROM User, licytacje "
                      . " WHERE licytacje.id_kol = '$id_kol' AND User.id_user = licytacje.id_user "
                      . " ORDER BY licytacje.ile desc, licytacje.data, licytacje.id_lic ";
               $zapl1 = mysql_query($sqll1) or die('mysql_query');       
              echo '
	      <br/><br/>
	      ';
              echo '<table id="menu2">
	      ';
              echo '<tr><td class="wyscig2">licytujący</td><td class="wyscig2">ile</td><td class="wyscig2">kiedy</td></tr>
	      ';
               
               while ($danl1 = mysql_fetch_row($zapl1)) {
                 echo '<tr><td class="wyscig2">'.$danl1[0].'</td><td class="wyscig2">'.$danl1[1].'</td><td class="wyscig2">'.$danl1[2].'</td></tr>
		 ';
               }
               echo '</table>
	       ';
               
               
               
             }
	      
      //----------------------------
      //koniec wklejania
      //----------------------------
      
	     
	     
	     
	     
	     
	     
           
           }
                  $sql3 = " SELECT Kolarze.imie , Kolarze.nazw , transzaak.kiedy , transzaak.ile , User_1.login , User.login, transzaak.id_tpZ, transzaak.poprzednia_cena, User_1.id_user , User.id_user, transzaak.typ "
                       .  " FROM User AS User_1 INNER JOIN ( User INNER JOIN ( transzaak INNER JOIN Kolarze ON transzaak.id_kol = Kolarze.id_kol ) ON User.id_user = transzaak.id_userK ) ON User_1.id_user = transzaak.id_userS" 
                       .  " WHERE (Kolarze.id_kol = '$id_kol') "
                       .  " ORDER BY transzaak.kiedy DESC, transzaak.id_tpZ DESC "  ;
                  $zap3 = mysql_query($sql3) or die('mysql_query');
                  echo '
		  <br/><br/>
		  
		  <h5>historia transferów kolarza</h5>
		  <table class="wyscig">
		  <tr><td class="wyscig6" style="text-align: middle;"><b> kiedy zapr. </b></td><td class="wyscig6" style="text-align: middle;"><b> Sprzedający </b></td><td class="wyscig6" style="text-align: middle;"><b> Kupujący </b></td><td class="wyscig1" style="text-align: right;"><b> za ile </b></td><td class="wyscig6" style="text-align: middle;"><b> ile kosztował poprzednio </b></td><td class="wyscig6" style="text-align: middle;"><b> za kogo </b>/co to było</td></tr>
		  ';
                
                  if (mysql_num_rows($zap3) == 0 ) {
                        
                    echo '<tr><td> brak </td><td> transferów </td><td></td><td></td><td></td></tr>
		    ';
                  } else {
                  
                    $wydane = 0;
                    $zarobione = 0;
                    

                    while ($dan3 = mysql_fetch_row($zap3)) 
                    {
                      if ($dan3[10] == 3) {
                        $idkol = ($dan3[3] * (-1));
                        $sqlp4 = " SELECT imie, nazw, id_kol FROM Kolarze WHERE id_kol = '$idkol' ";
                        $zapp4 = mysql_query($sqlp4) or die('mysql_query');
                        $danp4 = mysql_fetch_row($zapp4);
                        echo '<tr><td class="wyscig6" style="text-align: middle;">'.$dan3[2].'</td><td class="wyscig6" style="text-align: middle;"> '.$dan3[4].'</td><td class="wyscig6" style="text-align: middle;"> '.$dan3[5].'</td><td class="wyscig1" style="text-align: right;">
			Wym. </td><td class="wyscig6" style="text-align: right;"> '.$dan3[7].'C </td><td>';
			
			echo $danp4[0].' <b>'.$danp4[1].'</b>
			';
			 
			echo '</td></tr>
			';
                        
                        
                      } else {
                        echo '<tr><td class="wyscig6" style="text-align: middle;">'.$dan3[2].'</td><td class="wyscig6" style="text-align: middle;"> '.$dan3[4].'</td><td class="wyscig6" style="text-align: middle;"> '.$dan3[5].'</td><td class="wyscig1" style="text-align: right;"> <b>
			';
	                echo $dan3[3].'C </b></td><td class="wyscig6" style="text-align: right;"> '.$dan3[7];
	                echo 'C </td>
			
			<td>';
			
                        switch($dan3[10])
			{ 
			  case 0:
			    echo '<font size=-3>sprzedaż</font>';
			    break;
			  case 1:
			    echo '<font size=-3>zwolnienie</font>';
			    break;
			  case 2:
			    echo '<font size=-3>zatrudnienie</font>';
			    break;  
			  case 4:
			    echo '<font size=-3>przedłużenie</font>';
			    break;  
			  case 5:
			    echo '<font size=-3>obniżka ceny</font>';
			    break;    
			  case 6;
			    echo '<font size=-3>ponowne FA</font>';
			    break;      
	                  default:
			    echo '';
			}

			
			echo '</td>
			</tr>
			';
	              }
	              
	              
                  }
                  

                  
                  }

                  $sql3 = " SELECT Kolarze.imie , Kolarze.nazw , transzaakST.kiedy , transzaakST.ile , User_1.login , User.login, transzaakST.id_tpZ, transzaakST.poprzednia_cena, User_1.id_user , User.id_user, transzaakST.typ "
                       .  " FROM User AS User_1 INNER JOIN ( User INNER JOIN ( transzaakST INNER JOIN Kolarze ON transzaakST.id_kol = Kolarze.id_kol ) ON User.id_user = transzaakST.id_userK ) ON User_1.id_user = transzaakST.id_userS" 
                       .  " WHERE (Kolarze.id_kol = '$id_kol') "
                       .  " ORDER BY transzaakST.kiedy DESC, transzaakST.id_tpZ DESC "  ;
                  $zap3 = mysql_query($sql3) or die('mysql_query');
                  
                  echo '<tr><td><b>poprzednie</b></td><td><b>lata:</b></td><td></td><td><td></td></td></tr>
		  ';
                  if (mysql_num_rows($zap3) == 0 ) {
                    echo '<tr><td> brak </td><td> transferów </td><td></td><td></td><td></td></tr>
		    
		    </table>
		    ';
                  } else {
                  
                    $wydane = 0;
                    $zarobione = 0;
                    

                    while ($dan3 = mysql_fetch_row($zap3)) 
                    {
                      if ($dan3[10] == 3) {
                        $idkol = ($dan3[3] * (-1));
                        $sqlp4 = " SELECT imie, nazw, id_kol FROM Kolarze WHERE id_kol = '$idkol' ";
                        $zapp4 = mysql_query($sqlp4) or die('mysql_query');
                        $danp4 = mysql_fetch_row($zapp4);
                        echo '<tr><td class="wyscig6" style="text-align: middle;">'.$dan3[2].'</td><td class="wyscig6" style="text-align: middle;"> '.$dan3[4].'</td><td class="wyscig6" style="text-align: middle;"> '.$dan3[5].'</td><td class="wyscig1" style="text-align: right;">
			';
	                echo 'Wym. </td><td class="wyscig6" style="text-align: right;"> '.$dan3[7];
	                echo 'C </td><td>
			';
			
			echo $danp4[0].' <b>'.$danp4[1].'</b>
			';
			 
			echo '</td></tr>
			';
                        
                        
                      } else {
                        echo '<tr><td class="wyscig6" style="text-align: middle;">'.$dan3[2].'</td><td class="wyscig6" style="text-align: middle;"> '.$dan3[4].'</td><td class="wyscig6" style="text-align: middle;"> '.$dan3[5].'</td><td class="wyscig1" style="text-align: right;"> <b>';
	                echo $dan3[3].'C </b></td><td class="wyscig6" style="text-align: right;"> '.$dan3[7];
	                echo 'C </td>
			
			<td>';
			
                        switch($dan3[10])
			{ 
			  case 0:
			    echo '<font size=-3>sprzedaż</font>';
			    break;
			  case 1:
			    echo '<font size=-3>zwolnienie</font>';
			    break;
			  case 2:
			    echo '<font size=-3>zatrudnienie</font>';
			    break;  
			  case 4:
			    echo '<font size=-3>przedłużenie</font>';
			    break;  
			  case 5:
			    echo '<font size=-3>obniżka ceny</font>';
			    break;    
			  case 6;
			    echo '<font size=-3>ponowne FA</font>';
			    break;     
	                  default:
			    echo '';
			}

			
			echo '</td>
			</tr>
			';
	              }
	              
	              
                  }
                  echo '</table>
		  ';

                  
                  }


         }
         
         
         
         
         
         echo koniec();
         
        ?>

    
    
    
