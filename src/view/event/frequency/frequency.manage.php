<?php global $_MyCookie; ?>
<?php $_MyCookie->LoadView('event/accreditation', 'participants.header', $data->getEvent()) ?>
<div class="panel panel-info">
    <div class="panel-heading">
        <h4 data-i18n="event:frequency.label.activity_info"></h4>
    </div>
    <div class="panel-body">
        <div class="col-md-12">
            <label><span data-i18n="event:activity.label.name"></span>:</label>
            <?= $data->getName(); ?>
        </div>                
        <div class="col-md-3">
            <label><span data-i18n="event:accreditation.label.registred"></span>:</label>
            <?= $data->getParticipants()->count() ?>
        </div>
        <div class="col-md-3">
            <label><span data-i18n="event:accreditation.label.confirmed"></span>:</label>
            <?= $data->getConfirmed() ?>
        </div>        
    </div>
</div>
<div id="lstData" class="row">
    <div class="col-lg-12">  
        <?php $_MyCookie->loadView('event/frequency', 'frequency.table', $data); ?>
        <div class="clear"></div>
    </div>
</div>