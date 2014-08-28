<?php global $_MyCookie ?>
<?php $_MyCookie->LoadView('accreditation', 'Participants.header', $data['event']); ?>
<div class="panel panel-info">
    <div class="panel-heading">
        <h4><?php _e('Credentials confirmation', 'accreditation') ?></h4>
    </div>
    <div class="panel-body">
        <h4><?php echo $data['participant']->getCompleteName() ?></h4>
    </div>
</div>
<div class="row">
    <form id="FrmRegister">
        <fieldset>
            <?php foreach ($data['event']->getActivities() as $activity) : ?>
                <div class="form-group col-lg-12">
                    <input type="checkbox" name="Activity[]" id="act_<?php echo $activity->getId() ?>" 
                           <?php if ($activity->getParticipants()->contains($data['participant'])) : ?>checked="checked"<?php endif; ?>
                           value="<?php echo $activity->getId() ?>" 
                           <?php if (!$activity->hasVacancy() && !$activity->getParticipants()->contains($data['participant'])): ?>disabled="disabled"<?php endif; ?>>
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
        <input type="hidden" id="eventId" name="event" value="<?php echo $data['event']->getId() ?>">                                                    
        <input type="hidden" name="participant" value="<?php echo $data['participant']->getId() ?>">
    </form>  
</div>

<nav id="admin-navbar" class="navbar navbar-default navbar-fixed-bottom" role="navigation">    
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="align-center">
        <a href="#" onclick="accreditation.confirm(event)" class="navbar-link" title="Confirm">
            <i class="fa fa-check-circle fa-4x"></i>
        </a>
    </div><!-- /.navbar-collapse -->
</nav>