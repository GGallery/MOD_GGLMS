<?php
$unitalastcontenuto=$params->get('lastcont');
$ultimoarticolo=modgglmsHelper::getUltimoArticolo($unitalastcontenuto);

?>
<div class="news">
    <div class="text-center"><h3>CARIGELEARNING NEWS</h3></div>

    <div class="text-center">
        <h2>
            <a href="index.php?option=com_gglms&view=contenuto&alias=<?php echo $ultimoarticolo->alias; ?>">
                <?php echo $ultimoarticolo->titolo; ?>
            </a>
        </h2>
    </div>
</div>