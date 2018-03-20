<div id="wizardbreadcrumbar">
    <?php

    if(!$alert)
        $nav = '
        <ol class="breadcrumb">
        <span class="divider" style="margin-right: 10px;">
                <img src="components/com_wizard/images/gufo.png" width="30" />
            You are working on:
        </span>
    <li><a href="usecase2.html">Wizard</a></li>';
    else
        $nav = '
        <ol class="breadcrumb big">
        <span class="divider" style="margin-right: 10px;">
                <img src="components/com_wizard/images/gufo.png" width="50" />
            Return on wizard :
        </span>
    <li>Wizard</li>';

    switch ($step){

        case 'a':

            $nav .= '
                    <span class="divider"><img src="media/system/images/arrow.png" alt="">
                    </span><li><a href="usecase2?view=case2&tipo=a">Country</a></li>';
            break;

        case 'a1':
            if(!$alert)
                $nav .= '
                    <span class="divider"><img src="media/system/images/arrow.png" alt=""></span>
                    <li><a href="usecase2?view=case2&tipo=a">Country</a></li>';
            else
                $nav .= '
                    <span class="divider"><img src="media/system/images/arrow.png" alt=""></span>
                    <li>Country</li>';


            $nav.='
                    <span class="divider"><img src="media/system/images/arrow.png" alt=""></span>
                    <li class="active"><a href="usecase2?view=case2&tipo=a1">Country</a></li>';
            break;

        case 'a2':
            if(!$alert)
                $nav .= '
                    <span class="divider"><img src="media/system/images/arrow.png" alt=""></span>
                    <li><a href="usecase2?view=case2&tipo=a">Country</a></li>';
            else
                $nav .= '
                    <span class="divider"><img src="media/system/images/arrow.png" alt=""></span>
                    <li>Country</li>';

            $nav.='
                    <span class="divider"><img src="media/system/images/arrow.png" alt=""></span>
                    <li class="active"><a href="usecase2?view=case2&tipo=a2">Country Needs</a></li>';
            break;
        case 'a3':
            if(!$alert)
                $nav .= '
                    <span class="divider"><img src="media/system/images/arrow.png" alt=""></span>
                    <li><a href="usecase2?view=case2&tipo=a">Country</a></li>';
            else
                $nav .= '
                    <span class="divider"><img src="media/system/images/arrow.png" alt=""></span>
                    <li>Country</li>';

            $nav.=' <span class="divider"><img src="media/system/images/arrow.png" alt=""></span>
                    <li class="active"><a href="usecase2?view=case2&tipo=a3">Country challenges</a></li>';
            break;
        case 'b':
            $nav .= '
                    <span class="divider"><img src="media/system/images/arrow.png" alt=""></span>
                    <li><a href="usecase2?view=case2&tipo=b">HHCP</a></li>';
            break;
        case 'c':
            $nav .= '
                    <span class="divider"><img src="media/system/images/arrow.png" alt=""></span>
                    <li><a href="usecase2?view=case2&tipo=c">HHCP in a Country</a></li>';
            break;
        case 'c1':
            if(!$alert)
                $nav .= '
                    <span class="divider"><img src="media/system/images/arrow.png" alt=""></span>
                    <li><a href="usecase2?view=case2&tipo=c">HHCP in a Country</a></li>';
            else
                $nav .= '
                    <span class="divider"><img src="media/system/images/arrow.png" alt=""></span>
                    <li>HHCP in a Country</li>';

            $nav.= ' <span class="divider"><img src="media/system/images/arrow.png" alt=""></span>
                    <li><a href="usecase2?view=case2&tipo=c1">HHCP in a Country</a></li>';
            break;
        case 'c2':
            if(!$alert)
                $nav .= '
                    <span class="divider"><img src="media/system/images/arrow.png" alt=""></span>
                    <li><a href="usecase2?view=case2&tipo=c">HHCP in a Country</a></li>';
            else
                $nav .= '
                    <span class="divider"><img src="media/system/images/arrow.png" alt=""></span>
                    <li>HHCP in a Country</li>';

            $nav.='
                    <span class="divider"><img src="media/system/images/arrow.png" alt=""></span>
                    <li><a href="usecase2?view=case2&tipo=c2">Learning Outcome of a VET Course</a></li>';
            break;
        case 'c3':
            if(!$alert)
                $nav .= '
                    <span class="divider"><img src="media/system/images/arrow.png" alt=""></span>
                    <li><a href="usecase2?view=case2&tipo=c">HHCP in a Country</a></li>';
            else
                $nav .= '
                    <span class="divider"><img src="media/system/images/arrow.png" alt=""></span>
                    <li>HHCP in a Country</li>';

            $nav.='<span class="divider"><img src="media/system/images/arrow.png" alt=""></span>
                   <li><a href="usecase2?view=case2&tipo=c3">KSC</a></li>';
            break;
    }



    if($alert)
        $nav .= '<li><div id="alert">You are working on framework, to come back to wizard click here!</div></li>';


    $nav.="</ol>";

    if($step != '')
        echo $nav;
    ?>


</div>



<?php
if($step != ''){
?>
    <div id="exitbox">
        <input type="button" class="btn btn-primary btn-small " id="exitbtn" value="Exit Wizard">
    </div>
<?php
}
?>





<script type="application/javascript">
    jQuery(document).ready(function($){

        $("#exitbtn").click(function(){
            var url = window.location.href;
            url = encodeURI(url);
            window.location.replace("index.php?option=com_wizard&task=wizardoff&url="+url);

        });
    });
</script>

