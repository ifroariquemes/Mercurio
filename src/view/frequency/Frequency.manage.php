<?php global $_MyCookie; ?>
<?php $_MyCookie->LoadView('accreditation', 'Participants.header', $data->getEvent()) ?>
<div class="panel panel-info">
    <div class="panel-heading">
        <h4><?php _e('Activity info', 'frequency') ?></h4>
    </div>
    <div class="panel-body">
        <div class="col-md-12">
            <label><?php _e('Name', 'frequency') ?>:</label>
            <?php echo $data->getName(); ?>
        </div>                
        <div class="col-md-3">
            <label><?php _e('Registred', 'frequency') ?>:</label>
            <?php echo count($data->getParticipants()) ?>
        </div>
        <div class="col-md-3">
            <label><?php _e('Confirmed', 'frequency') ?>:</label>
            <?php echo $data->getConfirmed() ?>
        </div>        
    </div>
</div>
<div id="lstData" class="row">
    <div class="col-lg-12">  
        <?php $_MyCookie->LoadView('frequency', 'Frequency.table', $data); ?>
        <div class="clear"></div>
    </div>
</div>