<?php

require_once JPATH_BASE . '/components/com_gginterface/models/cruscottoformativo.php';
$user = JFactory::getUser();
$userid = $user->get('id');
$cruscottomodel=new  gginterfaceModelCruscottoFormativo();
$display_state_esma="display:none";
$display_state_ivass="display:none";
$display_state="display:none;";
$tipo_cruscotto;

//if($userid!=650376498 && $userid!=878237962){return;}

$abilitato_esma=$cruscottomodel->utente_abilitato_esma($userid);//restituisce bool

if($abilitato_esma){
    
    $tot_esma = 30;
    $fontesize="normal";
    $ore_esma=$cruscottomodel->ore_esma($userid);
    
    $label_esma="Aggiornamento ESMA 2021 da terminare entro dicembre: ore mancanti ";
    $label_esma_completo="hai completato il tuo percorso ESMA";
   
    if($userid==652){$ore_esma=30;}
    $percentuale_ore_esma = ($ore_esma / $tot_esma) * 100;
    $display_state_esma=null;
    $display_state=null;
    if($userid==665648758 || $userid==935554742){$display_state_esma="display:none";}    
    
       

        
    
}

//INIZIA NUOVO IVASS


$tipo_ivass=$cruscottomodel->utente_abilitato_ivass($userid);//restituisce il tipo
$display_state_ivass=null;
$display_state=null;
$scadenza_ivass='2021';
$tot_ivass=30;

if($tipo_ivass==1) {
    $ore_ivass=$cruscottomodel->ore_ivass($userid);
    $percentuale_ore_ivass=($ore_ivass/$tot_ivass)*100;
}

if($tipo_ivass==2){
    $ore_ivass=30;
    $percentuale_ore_ivass=100;
}



?>

<div class="row" style="border-bottom: 1px solid #0095ad; padding-bottom: 30px;<?php echo $display_state?>">

    <div class="col-md-6" style="<?php echo $display_state_esma?>">
        <div class="row" style="background-color: rgba(209, 237, 245, 1);">
            <div class="col-md-12" style="margin-top: 20px; ">
                <b>AGGIORNAMENTO ANNUALE ESMA</b>
            </div>
        </div>
        

        <div class="row" style="background-color: rgba(209, 237, 245, 1)">
        
            <div class="col-md-12" style="margin-top: 20px; ">
                <?php if($tot_esma>round($ore_esma,1)){?>

                    <?php echo $label_esma?>  <span class="label" style="font-size: large; margin-top: -4px; background-color: #0095ad;"><?php echo $tot_esma-round($ore_esma,1)?></b> ore</span> </b>
                <?php }else{ ?>
                    <b> <?php  echo $label_esma_completo;?></b>
                <?php }?>
            </div>
        </div>
        <div class="row" style="background-color: rgba(209, 237, 245, 1);">
            <div class="col-md-12" >

                <div class="progress" style="margin-top: 20px; background-color: rgba(209, 237, 245, 1);">
                    <div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percentuale_ore_esma?>%">

                    </div>
                </div>
            </div>
        </div>
        
        
    </div>







     <?php if($tipo_ivass){?>               
    <div class="col-md-6" style="<?php echo $display_state_ivass?>">
        <div class="row" style="background-color: rgba(242, 185, 104, 1);">
            <div class="col-md-12" style="margin-top: 20px;">
                <b>AGGIORNAMENTO ANNUALE IVASS <?php echo $scadenza_ivass;?></b>
            </div>
        </div>
        <div class="row" style="background-color:  rgba(242, 185, 104, 1);">
            <div class="col-md-12" style="margin-top: 20px; ">
            
                <?php if($tipo_ivass==1){?>

                    <?php if($tot_ivass>$ore_ivass){ 
						// anche per IVASS decimali e non più interi
						// $tot_ivass-intval($ore_ivass,2)
					?>
                        <?php echo $tot_ivass?> ore entro il 31.12.2021: ti mancano  <span class="label" style="font-size: large; margin-top: -4px; background-color: #0095ad;"><b><?php echo $tot_ivass-round($ore_ivass,1)?> ore</b></span>
                    <?php } else { ?>
                        <b>hai completato il tuo percorso IVASS </b>
                    <?php }
                } else { ?>
                    <span style="font-size: large; margin-top: -4px; background-color: rgba(242, 185, 104, 1);"><b>Aggiornamento non necessario perché abilitato nell’anno in corso</b></span>
                <?php } ?>

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
                <?php }?>

    

</div>



