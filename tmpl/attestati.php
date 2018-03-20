<?php
$attestati = modgglmsHelper::getAttestati();
if($attestati[0])
{
	$db = JFactory::getDbo();
	$user = JFactory::getUser();
	$userid = $user->get('id');
	echo "<ul>";
	foreach($attestati as $attestato)
	{
		$title = $attestato['corso'];
		if(strlen($attestato['corso'])>50)
			$attestato['corso']=substr($attestato['corso'], 0,20)."...";

		echo '<li><a title="'.$title.'" href="index.php/component/gglms/attestato?student='.$userid.'&idq='.$attestato['id'].'" target="_blank">'.$attestato['corso'].'</a></li>';
	}
	echo "</ul>";
}
else
{
	echo "Non ci sono attestati da scaricare";
}
?>

