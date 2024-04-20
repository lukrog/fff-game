<?PHP

function wyswietl_jezyki($jezyk) {  
        global $jezyk;
        //echo '<img src="http://fff.xon.pl/img/flagi/'.zwroc_tekst(2, $jezyk).'" />
	//';
	
        //  <font size=1>Language/język/...</font><br/>
	        $sqljez = "SELECT PL, EN FROM z_z_tlumacz WHERE kod = 1";
	        $zapjez = mysql_query($sqljez) or die(mysql_error());
	        $rekord_jezyk = mysql_fetch_row($zapjez);
	        
		$i = 0;
	        while ($i <= 1) {
	          echo '<a href="zmienjezyk.php?nowyjezyk='.$rekord_jezyk[$i].'"><img src="http://fff.xon.pl/img/flagi/'.zwroc_tekst(2, $rekord_jezyk[$i]).'"/></a> ';
	          $i++;
	        }
	
	
	echo ' 
	      <form action="zmienjezyk.php" method="get" style="padding-right: 15px;">
	        <select class="form" name="nowyjezyk">
	           ';
		//echo '<br/>';
		$i = 0;
		while ($i <= 1) {	          
		  if($jezyk == $rekord_jezyk[$i]) {$drukuj = 'selected="selected"';} else {$drukuj = "";}
		  echo '<option style="background-image: url(http://fff.xon.pl/img/flagi/'.zwroc_tekst(2, $rekord_jezyk[$i]).'); background-repeat:no-repeat; padding-left: 21px;" value="'.$rekord_jezyk[$i].'" '.$drukuj.'>'.zwroc_tekst(3, $rekord_jezyk[$i]).'</option>
		  ';
		  $i++;
	        }
		
	echo '</select> 
	       <input class="form2" name="zmien" type="submit" value="OK" />
            </form>
	    ';
	    
	    
	    
}



if($_GET['nowyjezyk']) {
        setcookie('skarb_kibica_jezyk_pro-cycling', $_GET['nowyjezyk'], time()+30*86400);
	header("Location: ".$_SERVER['HTTP_REFERER']);
	echo 'Wybrałeś nowy język';
} else {
	wyswietl_jezyki($jezyk);
}
