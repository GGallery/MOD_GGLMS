<div id="glossary">
    <a alt="Glossary" title="Glossary"  class="btn btn-success btn-large btn-glossary"   data-toggle="modal" href="#myModal">
        <span class="fa fa-book"></span>
        Glossary</a>
</div>


<!-- Modal HTML -->

<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Glossary</h4>
            </div>

            <div class="modal-body">

                <?php echo $params->get('glossario'); ?>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>

        </div>

    </div>

</div>