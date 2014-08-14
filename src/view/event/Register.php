<?php global $_MyCookieUser; ?>
<header class="row">     
    <div class="col-lg-12"><h2><?php _e('Registering', 'event') ?></h2></div>
</header>    
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4><?php _e('Event information', 'event') ?></h4>
            </div>
            <div class="panel-body">                
                <form id="FrmEventInfo">
                    <fieldset>
                        <div class="form-group col-lg-6">
                            <label for="textName"><?php _e('Name', 'event') ?>:</label>                            
                            <br><?php echo $data->getName() ?>
                        </div>             
                        <div class="form-group col-lg-6">
                            <label for="selectOrganization"><?php _e('Organization', 'event') ?>:</label>                            
                            <br><?php echo $data->getOrganization()->getName() ?>
                        </div>             
                        <div class="form-group col-lg-12">
                            <label for="textDescription"><?php _e('Description', 'event') ?>:</label>                            
                            <br><?php echo $data->getDescription() ?>
                        </div>             
                        <div class="form-group col-lg-12">
                            <label for="textAddress"><?php _e('Address', 'event') ?>:</label>                            
                            <br><?php echo $data->getAddress() ?>
                        </div>             
                        <div class="form-group col-lg-6">
                            <label for="dateStart"><?php _e('Starts', 'event') ?>:</label>                            
                            <?php echo $data->getStartDate() ?>
                        </div>             
                        <div class="form-group col-lg-6">
                            <label for="dateEnd"><?php _e('Ends', 'event') ?>:</label>                            
                            <?php echo $data->getEndDate() ?>
                        </div>           
                    </fieldset>
                    <input type="hidden" name="id" value="<?php echo $data->getId() ?>">                                                    
                </form>                                
            </div>
        </div>        
    </div>    
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4><?php _e('Activites', 'event') ?></h4>
            </div>
            <div class="panel-body">   
                <p><?php _e('Please, select activities you want to participate', 'event') ?></p>
                <form id="FrmRegister">
                    <fieldset>
                        <?php foreach ($data->getActivities() as $activity) : ?>
                            <div class="form-group col-lg-12">
                                <input type="checkbox" name="Activity[]" id="act_<?php echo $activity->getId() ?>" 
                                       <?php if ($activity->getParticipants()->contains($_MyCookieUser)) : ?>checked="checked"<?php endif; ?>
                                       value="<?php echo $activity->getId() ?>" 
                                       <?php if (!$activity->hasVacancy() && !$activity->getParticipants()->contains($_MyCookieUser)): ?>disabled="disabled"<?php endif; ?>>
                                <label for="act_<?php echo $activity->getId() ?>" data-toogle="tooltip" data-placement="right" 
                                       title="<?php echo $activity->getDescription() ?>">
                                           <?php echo $activity->getName() ?> 
                                           <?php
                                           if ($activity->remainingVacancies() != 'Unlimited') {
                                               if ($activity->hasVacancy()) {
                                                   printf('(%s: %s)', __('Remaining vacancies', 'event'), $activity->remainingVacancies());
                                               } else {
                                                   printf('(%s)', __('No vacancy', 'event'));
                                               }
                                           }
                                           ?>
                                </label>                            
                                <br>
                            </div>             
                        <?php endforeach; ?>                                 
                    </fieldset>                    
                    <input type="hidden" name="id" value="<?php echo $data->getId() ?>">                                                    
                </form>                                
            </div>
        </div>        
    </div>    
</div>

<nav id="admin-navbar" class="navbar navbar-default navbar-fixed-bottom" role="navigation">    
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="align-center">                    
        <a href="#" class="navbar-link" title="<?php _e('Previous', 'event') ?>" onclick="MyCookieJS.goto('administrator/event')">
            <i class="fa fa-arrow-circle-o-left fa-4x"></i>
        </a> &nbsp;&nbsp;&nbsp;
        <a href="#" class="navbar-link" title="<?php _e('Save', 'event') ?>" onclick="evt.register(event)">
            <i class="fa fa-save fa-4x"></i>
        </a>        
    </div><!-- /.navbar-collapse -->
</nav>

<script type="text/javascript">
    require(['jquery'], function($) {
        $(function() {
            $('#textName').focus();
            $('label[data-toogle=tooltip]').tooltip();
        });
    });
</script>