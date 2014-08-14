<?php
$event = $data['event'];
?>    
<header class="row">     
    <div class="col-lg-12"><h2><?php _e(sprintf('%s event', $data['action']), 'event') ?></h2></div>
</header>    
<div class="row" id="scr-1">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <form name="FrmEventEdit" id="FrmEventEdit" role="form" onsubmit="evt.next(event);">
                    <fieldset>
                        <div class="form-group">
                            <label for="textName"><?php _e('Name', 'event') ?>:</label>                            
                            <input type="text" required="required" name="Name" id="textName" class="form-control" value="<?php echo $event->getName() ?>">                            
                        </div>             
                        <div class="form-group">
                            <label for="selectOrganization"><?php _e('Organization', 'event') ?>:</label>                            
                            <?php \controller\organization\OrganizationController::select($event->getOrganization()) ?>
                        </div>             
                        <div class="form-group">
                            <label for="textDescription"><?php _e('Description', 'event') ?>:</label>                            
                            <input type="text" required="required" name="Description" id="textDescription" class="form-control" value="<?php echo $event->getDescription() ?>">                            
                        </div>             
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="dateStart"><?php _e('Starts', 'event') ?>:</label>                            
                                    <input type="date" required="required" name="StartDate" id="dateStart" class="form-control" value="<?php echo $event->getStartDateUS() ?>">                            
                                </div>             
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="dateEnd"><?php _e('Ends', 'event') ?>:</label>                            
                                    <input type="date" required="required" name="EndDate" id="dateEnd" class="form-control" value="<?php echo $event->getEndDateUS() ?>">                            
                                </div>           
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="textAddress"><?php _e('Address', 'event') ?>:</label>                            
                                    <input type="text" required="required" name="Address" id="textAddress" class="form-control" value="<?php echo $event->getAddress() ?>">                            
                                </div>             
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="checkOpen"><?php _e('Is it opened?', 'event') ?>:</label>                            
                                    <input type="checkbox" name="IsOpen" id="checkOpen" value="true" <?php if ($event->getIsOpen()): ?>checked="checked"<?php endif; ?>>                            
                                </div>             
                            </div>
                        </div>
                    </fieldset>
                    <input type="hidden" name="id" value="<?php echo $event->getId() ?>">                                
                    <input type="submit" style="position: absolute; visibility: hidden">
                </form>                                
            </div>
        </div>
        <?php if ($event->getId()) : ?>
            <div class="text-right">            
                <a href="#" onclick="evt.delete(event)"><?php _e('Delete event', 'event') ?></a>                
            </div>
        <?php endif; ?>
    </div>    
</div>

<?php \controller\activity\ActivityController::manage($event) ?>

<nav id="admin-navbar" class="navbar navbar-default navbar-fixed-bottom" role="navigation">    
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="align-center">
        <div class="scr-1">
            <a href="#" class="navbar-link" title="<?php _e('Next', 'event') ?>" onclick="evt.submitEvent(event)">
                <i class="fa fa-arrow-circle-o-right fa-4x"></i>
            </a>
        </div>
        <div class="scr-2 hidden">
            <a href="#" class="navbar-link" title="<?php _e('Previous', 'event') ?>" onclick="evt.previous(event)">
                <i class="fa fa-arrow-circle-o-left fa-4x"></i>
            </a> &nbsp;&nbsp;&nbsp;
            <a href="#" class="navbar-link" title="<?php _e('Save', 'event') ?>" onclick="evt.submit(event)">
                <i class="fa fa-save fa-4x"></i>
            </a>
        </div>
    </div><!-- /.navbar-collapse -->
</nav>

<script type="text/javascript">
    require(['jquery'], function($) {
        $(function() {
            $('#textName').focus();
        });
    });
</script>