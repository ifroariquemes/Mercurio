<div class="panel panel-info">
    <div class="panel-heading">
        <h4><?php _e('Event info', 'accreditation') ?></h4>
    </div>
    <div class="panel-body">
        <div class="col-md-6">
            <label><?php _e('Name', 'event') ?>:</label>
            <?php echo $data->getName(); ?>
        </div>        
        <div class="col-md-6">
            <label><?php _e('Organization', 'event') ?>:</label>        
            <?php echo $data->getOrganization()->getName() ?>
        </div>
        <div class="col-md-3">
            <label><?php _e('Starts', 'event') ?>:</label>
            <?php echo $data->getStartDate() ?>
        </div>
        <div class="col-md-3">
            <label><?php _e('Ends', 'event') ?>:</label>
            <?php echo $data->getEndDate() ?>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-3">
            <label><?php _e('Registred', 'event') ?>:</label>
            <?php echo count($data->getParticipants()) ?>
        </div>
        <div class="col-md-3">
            <label><?php _e('Confirmed', 'event') ?>:</label>
            <?php echo count($data->getConfirmed()) ?>
        </div>
    </div>
</div>