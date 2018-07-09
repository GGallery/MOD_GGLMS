<?php
$user = JFactory::getUser();
$userid = $user->get('id');
//$userid=48217953;//UTENTE AL BIENNIO 2019 MA CHE LE HA GIA' FATTE COME'????
//$userid=887991;
//$userid=29036393; //UTENTE ASSENTE IN CORRISPONDENZA IVASS BIENNIO
//$userid=469206393;//VOLPES

$userid=51715375;//paladino
$userid=246600032; //servetto
if(utente_abilitato($userid)) {
    $display_state_esma="display:none";
    if(utente_abilitato_esma($userid)) {
        $tot_esma = 30;
        $ore_esma = ore_esma($userid);
        $percentuale_ore_esma = ($ore_esma / $tot_esma) * 100;
        $display_state_esma=null;
    }
    $ore_ivass=ore_ivass($userid);
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
                    <b><?php echo $tot_esma?> ore entro il 30.9.2018: ti mancano <span class="label" style="font-size: large; margin-top: -4px; background-color: #0095ad;"><b><?php echo $tot_esma-round($ore_esma,2)?></b> ore</span> </b>
                <?php }else{ ?>
                    <b>hai completato il tuo aggiornamento ESMA con <?php echo round($ore_esma,2)?>ore</span></b>
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
                        <?php echo $tot_ivass?> ore entro il 31.12.2018: ti mancano  <span class="label" style="font-size: large; margin-top: -4px; background-color: #0095ad;"><b><?php echo $tot_ivass-round($ore_ivass,2)?> ore</b></span>
                    <?php } else { ?>
                        <b>hai completato il tuo aggiornamento IVASS con <?php echo round($ore_ivass,2)?> ore</span></b>
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

function ore_esma($userid)
{
    $db = JFactory::getDbo();
    $contenuti_esma=getContenutiTema(1);
    $query = "select sum(durata)/3600 from crg_gg_report as r INNER JOIN crg_gg_contenuti as c on r.id_contenuto=c.id where r.stato=1 and r.id_utente=" . $userid . " and c.id in (".$contenuti_esma.")";
    // echo $query;
    $db->setQuery($query);
    $ore_fad=$db->loadResult();

    $query = "select sum(res.ore) from cc_crg_ggif_logres as res where id_utente=" . $userid . " and res.id_tema=1";
    // echo $query;
    $db->setQuery($query);
    $ore_res=$db->loadResult();

    return $ore_fad+$ore_res;
}

function ore_ivass($userid){
    $db = JFactory::getDbo();
    $contenuti_ivass=getContenutiTema(2);

    $query="select sum(durata)/3600 from crg_gg_report as r INNER JOIN crg_gg_contenuti as c on r.id_contenuto=c.id where r.stato=1 and r.id_utente=".$userid." and c.id in (".$contenuti_ivass.")";
    $db->setQuery($query);
    $ore_fad=$db->loadResult();

    $query="select sum(res.ore) from cc_crg_ggif_logres as res where id_utente=".$userid." and res.id_tema=2";
    $db->setQuery($query);
    $ore_res=$db->loadResult();
//echo $ore_res;
    return $ore_res+$ore_fad;
}

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

function getContenutiTema($id_tema){


    $contenutiesma=array();
    $db = JFactory::getDbo();
    $query="select u.id from crg_gg_unit as u inner join crg_ggif_edizione_unita_gruppo as e on u.id=e.id_unita inner join cc_crg_ggif_corrispondenza_edizionefad_tema as t on t.id_edizione=e.id_edizione
            where u.is_corso= 1 and t.id_tema=".$id_tema;

    $db->setQuery($query);

    $id_corsi_esma=$db->loadAssocList();
    $result=null;
    foreach ($id_corsi_esma as $id_corso_esma){

        //echo $id_corso_esma['id'].'<br>';
        array_push($contenutiesma,getContenutiArrayList($id_corso_esma['id']));

    }
    //var_dump($contenutiesma);
    foreach ($contenutiesma[0] as $contenutoesma){

        //echo $contenutoesma[0].['id'];
        //var_dump($contenutoesma);
        //echo $contenutoesma['id'];
        $result=$result.$contenutoesma['id'].',';
    }

    //echo rtrim($result,',');
    return rtrim($result,',');

}

function getContenutiArrayList($item=0){
    $contenuti=array();
    foreach (getContenutiUnitaArrayList($item) as $contenuto) {
        array_push($contenuti, $contenuto);
    }

    $unitas=getSottoUnitaArrayList($item);

    foreach ($unitas as $unita){

        foreach (getContenutiUnitaArrayList($unita['id']) as $contenuto) {
            array_push($contenuti, $contenuto);
        }
    }
    return $contenuti;
}

function getSottoUnitaArrayList($item = 0) {
    $tree = array();
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);

    $query->select('id');
    $query->from('#__gg_unit');
    $query->where("unitapadre=" . $item);

    $db->setQuery($query);

    $tmptree = $db->loadAssocList();
    foreach ($tmptree as $item) {
        array_push($tree, $item);
        foreach (getSottoUnitaArrayList($item['id']) as $item2) {
            //$item2['titolo'] = $item2['titolo'];
            array_push($tree, $item2);
        }

    }
    unset($tmptree);
    return $tree;
}

function getContenutiUnitaArrayList($item) {

    try {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select('c.id as id');
        $query->from('#__gg_unit_map AS a');
        $query->join('inner', '#__gg_contenuti AS c on c.id = a.idcontenuto');
        $query->where("idunita=" . $item);
        $query->order('a.ordinamento');

        $db->setQuery($query);
        $data = $db->loadAssocList();

        return $data;
    }catch (Exception $e){



    }
}


?>
