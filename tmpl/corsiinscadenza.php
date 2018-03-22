<?php


$corsiinscadenza = modgglmsHelper::getCorsiInScadenza();
echo '<div class="bg-danger corsiinscadenzabox"> <H3>CORSI IN SCADENZA:</H3>';
if(count($corsiinscadenza)>0) {

    echo '<ul>';
	foreach ($corsiinscadenza as $corso){

		echo '<li>'.$corso.'</li>';

	}
	echo '</ul></div>';

}
else {

	 echo "Non ci sono corsi in scadenza";
}
?>
