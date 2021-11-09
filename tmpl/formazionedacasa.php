<?php

$mesi = array(1=>'gennaio', 'febbraio', 'marzo', 'aprile',
    'maggio', 'giugno', 'luglio', 'agosto',
    'settembre', 'ottobre', 'novembre','dicembre');

//var_dump((int)date('m')-1);    
$mese_precedente_number=(int)date('m')-1;
//var_dump($mese_precedente_number);die;
if($mese_precedente_number==0)
    $mese_precedente_number=12;
$mese_precedente=$mesi[$mese_precedente_number];
//var_dump($mese_precedente);die;
$inizio_mese_attuale= date("Y-m-d", strtotime("first day of this month"));

$inizio_mese_precedente= date('Y-m-01', strtotime('-1 month', strtotime(date('Y-m-d'))));
//var_dump($inizio_mese_precedente);
//$inizio_mese_precedente=date('Y').'-'.(date('m')-1).'-01';
if($inizio_mese_precedente=='2020-00-01')
    $inizio_mese_precedente='2019-12-01';

$user = JFactory::getUser();
$userid = $user->get('id');

?>
<div class="row" style="height: 10%;">

    <div class="col-md-12"><span style="font-size: x-large;">Hai svolto home learning nel mese di <b><?php echo $mese_precedente?></b>? <button id="but" style="background-color:#0095ad; border-radius: 28px;" ><span class="label" id="<?php echo $inizio_mese_precedente?>" style="font-size: large; margin-top: -4px; background-color: #0095ad;">Clicca qui</span></button></span></div>
    <!--<div class="col-md-6"><span style="font-size: x-large;">Hai svolto home learning nel mese <b>attuale</b>? <button style="background-color:#0095ad; border-radius: 28px;" ><span class="but label" id="<?php //echo $inizio_mese_attuale?>"  style="font-size: large; margin-top: -4px; background-color: #0095ad;">Clicca qui</span></button></span></div>-->


</div>

<script type="text/javascript">



jQuery("#but").click(function(){

    var userid=<?php echo $userid;?>;



    jQuery.ajax({
        method: "POST",
        cache: false,
        url: 'index.php?option=com_gginterface&task=formazionedacasa.insert&userid='+userid+
        '&mese=<?php echo $inizio_mese_precedente?>'


    }).done(function() {

        alert("inserimento riuscito");
        location.reload();


    });
});

</script>


