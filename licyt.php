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
   <title>FFF - licytacje</title>
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
        $wymadane = 0;
        $ile = $_POST['ile'];
        $id_kol = $_GET['id_kol'];
        $dzis = date ("Y-m-d");
        
        $ktora_runda = "0" ;
        
        
        
	$sql1 = " SELECT dok, typ FROM wydarzenia "
              . " WHERE dataP <= '$dzis' AND dataK >= '$dzis' AND  typ = 2 ";
        $zap1  = mysql_query($sql1) or die('mysql_query');
        if(mysql_num_rows($zap1) > 0) 
	{ 
	  $ktora_runda = "I";
        }

        
	$sql1551 = " SELECT dok, typ FROM wydarzenia "
                 . " WHERE dataP <= '$dzis' AND dataK >= '$dzis' AND  typ = 3 ";
        $zap1551  = mysql_query($sql1551) or die('mysql_query');        
        if(mysql_num_rows($zap1551) > 0) 
	{ 
	  $ktora_runda = "II"; 
	}
	$dzis = date ("Y-m-d H:i:s");
	echo $dzis.'<br/>';
	//echo '  ; '.$dzis;
        //echo '  ; '.$ktora_runda;
        if ($ktora_runda == "I" OR $ktora_runda == "II") {

        
        // wybieramy kolarza o którego nam chodzi -------------------------------
        $sql1 = " SELECT imie, nazw, dataU, cena, id_user, id_kol "
              . " FROM Kolarze "
              . " WHERE id_kol = '$id_kol' ";
        
        $zap1 = mysql_query($sql1) or die(mysql_error());
        $dan1 = mysql_fetch_row($zap1);
        
        
        
        if ($ktora_runda == "II") {
          
          echo 'druga runda<br/>';
          $sql1151 = " SELECT id_lic, ile "
	           . " FROM licytacje "
	           . " WHERE id_kol = '$id_kol'"
		   . " ORDER BY ile DESC";
          $zap1151 = mysql_query($sql1151) or die('mysql_query');
          $dan1151 = mysql_fetch_row($zap1151);
          echo '<br/>';
          if ($dan1151[1]*0.05 > 5) {
            $wymagane = round($dan1151[1]*1.05, 2);
            echo 'Wymagana kwota: '.$dan1151[1].' * 5% + '.$dan1151[1].' = '.$wymagane.'<br/>';
          } else {
            $wymagane = $dan1151[1] + 5;
            echo 'Wymagana kwota: '.$dan1151[1].' + 5C = '.$wymagane;
          }
        
          
        } else 
	{
          echo 'pierwsza runda<br/>';
	  $wymagane = $dan1[3] / 2 ;
	}

        
        
        //echo '<br/>'.$dan1[4].'..................>'.$dan1151[1].'>.................'.$wymagane.'<br/>';


        if ($dan1[4] > 0) {
          echo 'Nie wolno licytować kolarza związanego z inną ekipą';
        } else {
        echo 'Wybrałeś: <br/>';
        echo $dan1[0].' '.$dan1[1].'('.$dan1[5].'), który kosztując: <b>'.$dan1[3].'C</b> urodzony: '.$dan1[2].'.<br/>';
        echo 'Ty zaproponowałeś: <b>'.$ile.'C</b> <br/><br/>';
        
       
	

	if ( $ile == 0 ) {

            echo ' Chcesz spasować w licytacji <br/>';

	    $sql4321 = " SELECT data, id_user "
                     . " FROM licytacje "
                     . " WHERE id_kol = '$id_kol' "
                     . " ORDER BY ile DESC, id_lic "
		     . " LIMIT 0, 1 ";
            $zap4321 = mysql_query($sql4321) or die('mysql_query');
            $dan4321 = mysql_fetch_row($zap4321);

                 


	    if (($dan4321[1] == $idek) AND ($ktora_runda == "II"))
	    {
              echo '<h4 style="color: red;">Nie możesz spasować gdy prowadzisz w licytacji </h4>';
            } else {
	  
	    
            $sql115 = " SELECT id_lic "
	            . " FROM licytacje "
	            . " WHERE id_kol = '$id_kol' AND id_user = '$idek'";
  	    $zap115 = mysql_query($sql115) or die('mysql_query');
            $dan115 = mysql_fetch_row($zap115);  
	    echo 'dzis mamy: '.$dzis;
	    echo '<br/><br/>Ile Twoich licytacji tego kolarza = '.mysql_num_rows($zap115);
            if (mysql_num_rows($zap115) == 0 ) {
              echo '<h5 style="color: red;">TO ZA MAŁO. Musisz zaproponować więcej niż '.$wymagane.' (50%)</h5>';
            } else {
              echo '<br/><br/>Tego kolarza już licytowałeś<br/>';

              echo 'sprawdzam numer poprzedniego zgłoszenia - '.$dan115[0].' <br/><br/>';
            
              $sql222 = " DELETE FROM licytacje "
	              . " WHERE id_lic = '$dan115[0]' ";
              $zap222 = mysql_query($sql222) or die('mysql_query');
              echo '<br/>Kasuję zgłoszenie!<br/><br/>';
              
              
            }
            }
          } else {
	    
          
	if ($ile < $wymagane) 
	{
          echo '<h5 style="color: red;">TO ZA MAŁO. Musisz zaproponować więcej niż '.$wymagane.' ';
	  
	  if ($ktora_runda == "I") {
            $stringi = '(50%)</h5>';
          } else {
            $stringi = '(najwyższa oferta)';
          }
	  
	  echo $stringi;
	  
	  
	  
        } else {
          echo 'zaproponowałeś więcej niż <b>'.$wymagane.'C </b> '.$stringi.' <br/>';
          
          echo 'Co za tym idzie dodaję kolarza do bazy licytacji<br/><br/>';
          
          
	  echo 'Sprawdzam czy licytowałeś już tego kolarza? <br/><br/>';
	  $sql112 = " SELECT id_lic "
	          . " FROM licytacje "
	          . " WHERE id_kol = '$id_kol' AND id_user = '$idek'";
	  $zap112 = mysql_query($sql112) or die('mysql_query');
          $dan112 = mysql_fetch_row($zap112);  
	  echo 'dzis mamy: '.$dzis;
	  echo '<br/><br/>Ile Twoich licytacji tego kolarza = '.mysql_num_rows($zap112);
          if (mysql_num_rows($zap112) == 0 ) {
            echo 'pierwszy raz licytujesz tego kolarza <br/>';
	  
            $sql311 = " SELECT id_lic"
                    . " FROM licytacje"
                    . " ORDER BY id_lic DESC"
                    . " LIMIT 0, 1";
            $zap311 = mysql_query($sql311) or die('mysql_query');
            $dan311 = mysql_fetch_row($zap311);
            $id_lic = $dan311[0] + 1;
                     
            echo '<br/>Wstawiam: <br/>id licytacji: '.$id_lic.'<br/>id kolarza: '.$id_kol.'<br/>id fff: '.$idek.'<br/>za ile: '.$ile.'<br/>Kiedy: '.$dzis;
            
            $sql411 = " INSERT INTO licytacje VALUES ('$id_lic', '$id_kol', '$idek', '$ile', '$dzis') ";
            $zap411 = mysql_query($sql411) or die('mysql_query');
          
            echo '<br/><br/>Dodaję twoją propozycję<br/>';
	  } else {
            echo '<br/><br/>Tego kolarza już licytowałeś<br/>';

            echo 'sprawdzam numer poprzedniego zgłoszenia - '.$dan112[0].' <br/><br/>';
            
            $sql4321 = " SELECT data, ile "
                     . " FROM licytacje "
                     . " WHERE id_kol = '$id_kol' "
                     . " ORDER BY data DESC "
		     . " LIMIT 0, 1 ";
            $zap4321 = mysql_query($sql4321) or die('mysql_query');
            $dan4321 = mysql_fetch_row($zap4321);
            
            $dane24pobidzie = strtotime($dan4321[0]) + 24 * 3600;
            $dane24pobidzie = date("Y-m-d H:i:s",$dane24pobidzie);
            
	    
	    $sql4324 = " SELECT data, ile "
                     . " FROM licytacje "
                     . " WHERE id_kol = '$id_kol' AND id_user = '$idek' "
                     . " ORDER BY data DESC "
		     . " LIMIT 0, 1 ";
            $zap4324 = mysql_query($sql4324) or die('mysql_query');
            $dan4324 = mysql_fetch_row($zap4324);
            
            $dane24pobidziem = strtotime($dan4324[0]) + 48 * 3600;
            $dane24pobidziem = date("Y-m-d H:i:s",$dane24pobidziem);
            
	    
	    
	    
	    
	    
	    
	    
	    
	    if ($ktora_runda == "II") {
	    echo 'Data krytyczna licytacji: '.$dane24pobidzie;
	    echo '<br/>
	          Data krtytyczna swojego bidu: '.$dane24pobidziem.'<br/>';
            }
            if ($dzis > $dane24pobidzie AND $ktora_runda == "II") {
              
              echo '<br/>Ten kolarz ostatni raz był licytowany ponad 24 godziny temu<br/>';
              echo '<h4 style="color: red;">Przegrałeś tą licytację</h4>';
              
              
              
            } else {
              
              if ($dzis > $dane24pobidziem AND $ktora_runda == "II") {
                
                echo '<br/>Tego kolarza ostatni raz licytowałeś ponad 48 godziny temu<br/>';
                //echo '<h4 style="color: red;">Przegrałeś tą licytację</h4>';
		
	      } else {
	      }  
            
            $sumawygranych = 0;
            $zap3 = "SELECT ile, id_kol
                     FROM licytacje
                     WHERE id_user='$idek'";
            $idzap3 = mysql_query($zap3) or die('mysql_query');
            $czy_prowadze_u_tego_kolarza = "NIE";
            while ($dan3 = mysql_fetch_row($idzap3)) 
	    {
               $zap4 = "SELECT id_user
                        FROM licytacje
                        WHERE id_kol = '$dan3[1]'
                        ORDER BY ile DESC, id_lic
                        LIMIT 0, 1";
               $idzap4 = mysql_query($zap4) or die('mysql_query');
               $dan4 = mysql_fetch_row($idzap4);
               if ($dan4[0] == $idek) 
	       {
                  $sumawygranych = $sumawygranych + $dan3[0];
                  if ($id_kol == $dan3[1]) 
                  {
                     $czy_prowadze_u_tego_kolarza = "TAK";
                  }
               } 
               
               
            }
            
            $zap5 = "SELECT kasa
                     FROM User
                     WHERE id_user='$idek'";
            $idzap5 = mysql_query($zap5) or die('mysql_query');
            $dan5 = mysql_fetch_row($idzap5);
            
            if ($czy_prowadze_u_tego_kolarza == "TAK") 
            {
               $podwyzka = $ile - $dan4321[1];
            } else {
               $podwyzka = $ile;
            }
            
            $bilans_przed_wygraniem = $dan5[0]-$sumawygranych;

            $bilans_po_wygraniu = $dan5[0]-$sumawygranych-$podwyzka;
            
            $maxzadl = - 100;
            
            if ($ktora_runda == "II") {
            echo " <br/><br/>Wygrywając wszystkie licytacje zgłoszone do tej pory zapłaciłbyś: ".$bilans_przed_wygraniem."C <br/>
	            proponujesz o ".$podwyzka."C (".$ile."-".$dan4321[1].") więcej za tego kolarza niż poprzednio <br/>(biorąc pod uwagę, że ";
           
            if ($czy_prowadze_u_tego_kolarza == "NIE") 
            {
               echo " nie ";
            }

            echo "prowadziłeś do tej pory),<br/> a więc twoja kasa po zatwierdzeniu wszystkich wygranych licytacji wyniosłaby ".$bilans_po_wygraniu.'C <br/>
		    ';
            if (($bilans_po_wygraniu < $maxzadl) AND ($ktora_runda == "II")) {
              
	      echo '<br/><br/><br/>
	      
	      	    <h2>UWAGA</h2>
	      
	            Co za tym idzie przekroczyłbyś zasadę -100C w II rundzie.
		    
		    <h1 style="color: red;">NIE MOŻESZ ZA TYLE ZALICYTOWAĆ TEGO KOLARZA ZA TYLE</h1>
		    
		    ';
	            
	    } else {
	      $sql222 = " UPDATE licytacje
	                  SET ile = '$ile', data = '$dzis'
		          WHERE id_lic = '$dan112[0]' ";
              $zap222 = mysql_query($sql222) or die('mysql_query');
              echo '<br/>Aktualizuję zgłoszenie!<br/><br/>';
	    }
	    } else {
	      $sql222 = " UPDATE licytacje
	                  SET ile = '$ile', data = '$dzis'
		          WHERE id_lic = '$dan112[0]' ";
              $zap222 = mysql_query($sql222) or die('mysql_query');
              echo '<br/>Aktualizuję zgłoszenie!<br/><br/>';
	    }


            
            
            
          }
          }
         
        }

	}
	echo ' <h4>Przeliczania skończone --- Możesz przejść do innych stron</h4>';
	
	
	}
	} else {
          echo '<h4>teraz nie trwa czas licytacji poczekaj na następne okienko licytayjne</h4>';
        }
      } else {
        echo 'Nie masz uprawnień dostępu do tej strony';
        
      }
      
      
      
      
      
      
      
      
      
      
      
      echo koniec();
    ?>
    

    
