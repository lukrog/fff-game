<?php

if(isset($_POST['logowanie'])) {

	$dane = @mysql_query('SELECT login, haslo, id_user FROM User WHERE login = "'.$_POST['login'].'" AND haslo = "'.$_POST['haslo'].'"') or die(mysql_error());
	if(mysql_num_rows($dane) == 1) {
		$_SESSION['logowanie'] = 'poprawne';
	        $_SESSION['uzytkownik'] = $_POST['login'];
	        //session_register("logowanie", "uzytkownik");
	        
		
		$dzis = date('Y-m-d H:i:s');
                $wie = mysql_fetch_row($dane);
	        $sqlasd = " UPDATE User SET ost_log = '$dzis' WHERE id_user = '$wie[2]' ";
	        $danasd = @mysql_query($sqlasd);
	        
	        //sprawdzamy ostatni log logowania
	        $sql_log = "SELECT `id_log` FROM `logi_logowania` ORDER BY `id_log` DESC LIMIT 0, 1";
		$zap_log = mysql_query($sql_log) or die('mysql_query');
		$id_log = mysql_fetch_row($zap_log);
		
		echo $id_log[0];
		
		$id_log = $id_log[0]+1;
		
		$ip_logujacego = $_SERVER['REMOTE_ADDR'];
		
		$sql_Dodaj_log = "INSERT INTO `logi_logowania`(`id_log`, `ip`, `kiedy`, `kto`) VALUES ('$id_log','$ip_logujacego','$dzis','$wie[2]')";
		$zap_Dodaj_log = mysql_query($sql_Dodaj_log) or die('mysql_query');




	} else {
		$_SESSION['logowanie'] = 'Błędny login lub hasło!';
	}
	unset($_POST['logowanie']);
}

if(isset($_POST['wylogowanie'])) {
	
	unset($_SESSION['logowanie']);
	unset($_SESSION['boss']);	
	//unset($_POST['wylogowanie']);
}


function logowanie() {
	
	if($_SESSION['logowanie'] == 'poprawne') {
	
	$string  = '<form action="'.getenv(REQUEST_URI).'" method="post">';
   	$string .= '	<input class="form2" type="submit" name="wylogowanie" value="Wyloguj" />';
   	$string .= '</form>';

   	
	} else {
		
	$string  = '<form action="'.getenv(REQUEST_URI).'" method="post">';
   	$string .= '	<ul style="list-style-type: none; margin: 0; padding: 0;">';
   	
   	if(isset($_SESSION['logowanie'])) $string .= '<li>'.$_SESSION['logowanie'].'</li>';
   	
   	$string .= '		<li>Login: <input class="form" type="text" name="login" /></li>';
   	$string .= '		<li>Haslo: <input class="form" type="password" name="haslo" /></li>';
   	$string .= '		<li><input class="form2" type="submit" name="logowanie" value="Logowanie" /></li>';
   	$string .= '	</ul>';
   	$string .= '</form>';
   	
	}
	
	return $string;
	
}

?>
