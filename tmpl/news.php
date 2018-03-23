<?php

$unitalastcontenuto=$params->get('lastcont');
echo '<div><h2>ULTIMO ARTICOLO</h2></div>';
$ultimoarticolo=modgglmsHelper::getUltimoArticolo($unitalastcontenuto);
echo '<div><h2>'.$ultimoarticolo.'</h2></div>'
?>
