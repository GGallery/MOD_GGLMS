<?php
$corsiabilitati = modgglmsHelper::getCorsi();
if($corsiabilitati[0])

{
	$db = JFactory::getDbo();
	$user = JFactory::getUser();
	$userid = $user->get('id');
	echo "<ul>";
	foreach($corsiabilitati as $corsoabilitato)
	{



		// print_r($corsoabilitato);
		$title = $corsoabilitato['corso'];
		if(strlen($corsoabilitato['corso'])>40)
			$corsoabilitato['corso']=substr($corsoabilitato['corso'], 0,$params->get('lughezzatestocorso'))."...";

		echo '<li><a class="indice_corsi" title="'.$title.'" href="index.php/component/gglms/corso/'.$corsoabilitato['alias'].'.html" >'.$corsoabilitato['corso'].'</a>
		<br>['.		$corsoabilitato['crediti'].' crediti]['.		$corsoabilitato['durata'].' ore]


		</li>';
	}
	echo "</ul>";
}
else
{
	 echo "Non ci sono corsi abilitati";
}
?>
