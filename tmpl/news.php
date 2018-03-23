<?php
$unita=$params->get('lastcont');
$ultimoArticolo=modgglmsHelper::getUltimoArticolo($unita);

?>
<div class="news">
    <div class="text-center"><h3>CARIGE NEWS</h3></div>
    <div class="text-center">
        <h2>
            <a href="index.php?option=com_gglms&view=contenuto&alias=<?php echo $ultimoArticolo->alias; ?>">
                <?php echo $ultimoArticolo->titolo; ?>
            </a>
        </h2>
    </div>
</div>