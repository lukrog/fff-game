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
   <title>SKARB KIBICA - Cookie</title>
   
   
   <!-- Begin Cookie Consent plugin by Silktide - http://silktide.com/cookieconsent -->
   <script type="text/javascript">
    window.cookieconsent_options = {"message":"This website uses cookies to ensure you get the best experience on our website","dismiss":"Got it!","learnMore":"More info","link":"http://fff.xon.pl/SK/cookie.php","theme":"dark-top"};
   </script>


   
   
</head>
<body>

<?php 

    poczatek();

?>

	  <div id="TRESC">
	  
	  <?php 
	    if ($jezyk == "PL") {
	    echo '<h2>Pliki cookie</h2>
                  Aby zapewnić sprawne funkcjonowanie tego portalu, czasami umieszczamy na komputerze użytkownika (bądź innym urządzeniu) małe pliki - tzw. cookies ("ciasteczka"). Podobnie postępuje większość dużych witryn internetowych.
                  <h2>Czym są pliki cookie?</h2>
                  "Cookie" to mały plik tekstowy, który strona internetowa zapisuje na komputerze lub urządzeniu przenośnym internauty w chwili, gdy ten ją przegląda. Strona ta może w ten sposób zapamiętać na dłużej czynności i preferencje internauty (takie jak nazwa użytkownika, język, rozmiar czcionki i inne opcje). Dzięki temu użytkownik nie musi wpisywać tych samych informacji za każdym razem, gdy powróci na tę stronę lub przejdzie z jednej strony na inną. 
                  <h2>Jak używamy plików cookie?</h2>
                  Zapamiętujemy jakiego języka chcesz używać.
                  <h2>Jak kontrolować pliki cookie</h2>
                  Pliki cookie można samodzielnie kontrolować i usuwać - szczegóły są dostępne na stronie aboutcookies.org.  Można usunąć wszystkie pliki cookie zamieszczone na swoim komputerze, a w większości przeglądarek wybrać ustawienie, które uniemożliwia instalowanie tych plików. W takim przypadku może się okazać konieczne dostosowanie niektórych preferencji przy każdej wizycie na danej stronie, a część opcji i usług może być niedostępna.

                  ';
            } else {
 
 
            echo '<h2>Cookies</h2>
                  To make this site work properly, we sometimes place small data files called cookies on your device. Most big websites do this too.
                  <h2>What are cookies?</h2>
                  A cookie is a small text file that a website saves on your computer or mobile device when you visit the site. It enables the website to remember your actions and preferences (such as login, language, font size and other display preferences) over a period of time, so you don`t have to keep re-entering them whenever you come back to the site or browse from one page to another. 
                  <h2>How do we use cookies?</h2>
                  We remember what is your preffered language
                  <h2>How to control cookies</h2>
                  You can control and/or delete cookies as you wish - for details, see aboutcookies.org. You can delete all cookies that are already on your computer and you can set most browsers to prevent them from being placed. If you do this, however, you may have to manually adjust some preferences every time you visit a site and some services and functionalities may not work.
                  ';
           }
	  
	  ?>
	  
	  <br/> <br/>
	   
	  </div>

<?php 

    koniec();

?>       

</body>
</html>
    
