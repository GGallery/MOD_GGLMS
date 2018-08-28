<?php
$user = JFactory::getUser();
$userid = $user->get('id');
//$userid=48217953;//UTENTE AL BIENNIO 2019 MA CHE LE HA GIA' FATTE COME'????
//$userid=887991;
//$userid=29036393; //UTENTE ASSENTE IN CORRISPONDENZA IVASS BIENNIO
//$userid=469206393;//VOLPES

//$userid=51715375;//paladino
//$userid=246600032; //servetto
//$userid=622389853; //lucarelli
//$userid=327494204; //casano
//$userid=384319327;//beardo

if(utente_abilitato($userid)) {
    $display_state_esma="display:none";
    if(utente_abilitato_esma($userid)) {
        $tot_esma = 30;
        //    $ore_esma = ore_esma($userid);
        //if($userid==384319327){
        $ore_esma=new_ore_esma($userid);
        //}
        $percentuale_ore_esma = ($ore_esma / $tot_esma) * 100;
        $display_state_esma=null;
    }
    //$ore_ivass=ore_ivass($userid);
    //if($userid==384319327){
    $ore_ivass=new_ore_ivass($userid);
    //}
    $scadenza_ivass=scadenza_ivass($userid);
    $tot_ivass=totale_ivass($userid);
    //$tot_ivass=30;
    $percentuale_ore_ivass=($ore_ivass/$tot_ivass)*100;
    $display_state=null;

}else{
    $display_state="display:none;";

}



?>
<div class="row" style="border-bottom: 1px solid #0095ad; padding-bottom: 30px;<?php echo $display_state?>">
    <!--    <div class="text-left"><h2>CRUSCOTTO FORMATIVO</h2></div>-->
    <div class="col-md-6" style="<?php echo $display_state_esma?>">
        <div class="row" style="background-color: rgba(209, 237, 245, 1)">
            <div class="col-md-12" style="margin-top: 20px; ">
                <b>AGGIORNAMENTO ANNUALE ESMA</b>
            </div>
        </div>
        <div class="row" style="background-color: rgba(209, 237, 245, 1)">
            <div class="col-md-12" style="margin-top: 20px; ">
                <?php if($tot_esma>$ore_esma){?>
                    <b><?php echo $tot_esma?> ore entro il 30.9.2018: ti mancano <span class="label" style="font-size: large; margin-top: -4px; background-color: #0095ad;"><b><?php echo $tot_esma-intval($ore_esma,2)?></b> ore</span> </b>
                <?php }else{ ?>
                    <b>hai completato il tuo percorso ESMA </b>
                <?php }?>
            </div>
        </div>
        <div class="row" style="background-color: rgba(209, 237, 245, 1)">
            <div class="col-md-12" >

                <div class="progress" style="margin-top: 20px; background-color: rgba(209, 237, 245, 1);">
                    <div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percentuale_ore_esma?>%">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if($userid!=835364341){ ?>
        <div class="col-md-6" >
            <div class="row" style="background-color: rgba(242, 185, 104, 1)">
                <div class="col-md-12" style="margin-top: 20px;">
                    <b>AGGIORNAMENTO ANNUALE <?php echo $scadenza_ivass?></b>
                </div>
            </div>
            <div class="row" style="background-color:  rgba(242, 185, 104, 1);">
                <div class="col-md-12" style="margin-top: 20px; ">

                    <?php if($tot_ivass>0){ ?>
                        <?php if($tot_ivass>$ore_ivass){ ?>
                            <?php echo $tot_ivass?> ore entro il 31.12.2018: ti mancano  <span class="label" style="font-size: large; margin-top: -4px; background-color: #0095ad;"><b><?php echo $tot_ivass-intval($ore_ivass,2)?> ore</b></span>
                        <?php } else { ?>
                            <b>hai completato il tuo percorso IVASS </b>
                        <?php } ?>
                    <?php }else{ echo "errore, all'utente non è attribuito un biennio IVASS";}?>

                </div>
            </div>

            <div class="row" style="background-color:  rgba(242, 185, 104, 1);">
                <div class="col-md-12" >
                    <div class="progress" style="margin-top: 20px; background-color: orange;">
                        <div class="progress-bar progress-bar-warning progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width:  <?php echo $percentuale_ore_ivass?>%">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
<?php


function utente_abilitato($userid)
{

    $db = JFactory::getDbo();
    $query = "select count(*) from cc_crg_ggif_utenti_non_abilitati_contatori where id_utente=". $userid;
    $db->setQuery($query);


    if ($db->loadResult() == 0) {

        return true;
    } else {

        return false;
    }

}

function utente_abilitato_esma($userid)
{

    $db = JFactory::getDbo();
    $query = "select count(*) from cc_crg_ggif_utenti_non_abilitati_esma where id_utente=". $userid;
    $db->setQuery($query);


    if ($db->loadResult() == 0) {

        return true;
    } else {

        return false;
    }

}

/*function ore_esma($userid)
{
    $db = JFactory::getDbo();
    //$contenuti_esma=getContenutiTema(1);

    //$corsi_esma=getCorsiTema(1);
    $query = "select sum(durata)/3600 from crg_gg_report as r INNER JOIN crg_gg_contenuti as c on r.id_contenuto=c.id inner join crg_ggif_edizione_unita_gruppo as e on e.id_unita=r.id_corso
              where r.stato=1 and e.id_tema like '%1%' and r.id_utente=".$userid;
   // echo $query;
    $db->setQuery($query);
    $ore_fad=$db->loadResult();

    $query = "select sum(res.ore) from cc_crg_ggif_logres as res where id_utente=" . $userid . " and res.id_tema=1 ";
    // echo $query;
    $db->setQuery($query);
    $ore_res=$db->loadResult();
    //echo 'ore_fad_esma:'.$ore_fad.'ore_esma_res:'.$ore_res;
    return $ore_fad+$ore_res;
}

function ore_ivass($userid){
    $db = JFactory::getDbo();
    //$contenuti_ivass=getContenutiTema(2);
    //$corsi_ivass=getCorsiTema(2);
    $query = "select sum(durata)/3600 from crg_gg_report as r INNER JOIN crg_gg_contenuti as c on r.id_contenuto=c.id inner join crg_ggif_edizione_unita_gruppo as e on e.id_unita=r.id_corso
              where r.stato=1 and e.id_tema like '%2%' and r.id_utente=".$userid;
    $db->setQuery($query);
    $ore_fad=$db->loadResult();

    $query="select sum(res.ore) from cc_crg_ggif_logres as res where id_utente=".$userid." and res.id_tema=2";
    $db->setQuery($query);
    $ore_res=$db->loadResult();
    //echo 'ore_fad_ivass:'.$ore_fad.'ore_res_ivass:'.$ore_res;
    return $ore_res+$ore_fad;
}
*/
function scadenza_ivass($userid){

    $db = JFactory::getDbo();
    $query="select temabiennio from cc_crg_ggif_scadenza_temabiennio where id = (select id_scadenza_temabiennio from cc_crg_ggif_corrispondenza_utente_ivass where id_utente=".$userid.")";
    $db->setQuery($query);

    return $db->loadResult();
}

function totale_ivass($userid){

    $db = JFactory::getDbo();
    $query="select ore from cc_crg_ggif_corrispondenza_utente_ivass where id_utente=".$userid;

    $db->setQuery($query);
    return $db->loadResult();

}

function new_ore_ivass($userid){
    $db = JFactory::getDbo();
    //$contenuti_ivass=getContenutiTema(2);
    //$corsi_ivass=getCorsiTema(2);
    /*$query = "select e.anno as anno, sum(durata)/3600 as ore from crg_gg_report as r INNER JOIN crg_gg_contenuti as c on r.id_contenuto=c.id inner join crg_ggif_edizione_unita_gruppo as e on e.id_unita=r.id_corso
              where r.stato=1 and e.id_tema like '%2%' and r.id_utente=".$userid." group by e.anno";*/
    $query="select YEAR(u.data_fine) as anno, sum(durata)/3600 as ore from crg_gg_report as r INNER JOIN crg_gg_contenuti as c on r.id_contenuto=c.id inner join crg_ggif_edizione_unita_gruppo as e on e.id_unita=r.id_corso
            inner join crg_gg_unit as u on u.id=r.id_corso inner join crg_gg_view_stato_user_corso as v on r.id_corso=v.id_corso and r.id_anagrafica=v.id_anagrafica
            where v.stato=1 and r.stato=1 and e.id_tema like '%2%' and r.id_utente=".$userid." group by YEAR(u.data_fine)";
    $db->setQuery($query);
    $ore_fad=$db->loadAssocList('anno');

    $query="select YEAR(data_corso) as anno, sum(res.ore) as ore from cc_crg_ggif_logres as res where id_utente=".$userid." and res.id_tema=2 group by YEAR(data_corso)";
    $db->setQuery($query);
    $ore_res=$db->loadAssocList('anno');
    //echo 'ore_fad_ivass:'.$ore_fad.'ore_res_ivass:'.$ore_res;
    return aggiusta45($ore_fad,$ore_res);
}

function new_ore_esma($userid)
{
    $db = JFactory::getDbo();
    //$contenuti_esma=getContenutiTema(1);

    //$corsi_esma=getCorsiTema(1);
    $query = "select sum(durata)/3600 as ore from crg_gg_report as r INNER JOIN crg_gg_contenuti as c on r.id_contenuto=c.id inner join crg_ggif_edizione_unita_gruppo as e on e.id_unita=r.id_corso 
              inner join crg_gg_view_stato_user_corso as v on r.id_corso=v.id_corso and r.id_anagrafica=v.id_anagrafica where v.stato=1 and r.stato=1 and e.id_tema like '%1%' and r.id_utente=".$userid;
    // echo $query;
    $db->setQuery($query);
    $ore_fad=$db->loadResult();

    $query = "select sum(res.ore) as ore from cc_crg_ggif_logres as res where id_utente=" . $userid . " and res.id_tema=1 and data_corso>STR_TO_DATE(CONCAT(YEAR(DATE_ADD(NOW(), INTERVAL -1 YEAR)),'-',MONTH('2000-09-01'),'-',DAY('2000-09-01')),'%Y-%m-%d' )";
    // echo $query;
    $db->setQuery($query);
    $ore_res=$db->loadResult();
    //echo 'ore_fad_esma:'.$ore_fad.'ore_esma_res:'.$ore_res;
    return $ore_fad+$ore_res;
}

function aggiusta45($ore_fad,$ore_res){

    //var_dump($ore_fad);var_dump($ore_res);die;
    //$anni=array(2017,2018,2019,2020,2021,2022);
    //var_dump(array_column($ore_fad,'anno'));var_dump(array_column($ore_res,'anno'));die;
    $anni=array_merge(array_column($ore_fad,'anno'),array_column($ore_res,'anno'));
    $totale_array=array();
    //var_dump($anni);die;
    foreach ($anni as $anno){

        //echo $anno . ' : fad:' . $ore_fad[$anno] . ' res:' . $ore_res[$anno];
        $totale_array[$anno] = ($ore_fad[$anno]['ore'] + $ore_res[$anno]['ore'] < 46 ? $ore_fad[$anno]['ore'] + $ore_res[$anno]['ore'] : 45);

    }
    $totale=0;
    foreach ($totale_array as $tot){
        $totale=$totale+$tot;
    }
    return $totale;
}
?>

