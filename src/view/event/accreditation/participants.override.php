<?php global $_MyCookie ?>
<?php $_MyCookie->loadView('event/accreditation', 'participants.header', $data['event']); ?>
<div class="panel panel-info">
    <div class="panel-heading">
        <h4 data-i18n="event:accreditation.label.credentials_confirmation"></h4>
    </div>
    <div class="panel-body">
        <h4><?= $data['participant']->getName() ?></h4>
    </div>
</div>
<div class="alert alert-danger text-center">    
    <h2 data-i18n="event:accreditation.message.overriding">Be careful, you are overriding every rule of vacancy system now!</h2>
</div>
<div class="row">
    <form id="FrmRegister">
        <fieldset>
            <?php foreach ($data['event']->getActivities() as $activity) : ?>
                <div class="form-group col-md-4">                    
                    <input type="checkbox" name="Activity[]" id="act_<?= $activity->getId() ?>" 
                           <?php if ($activity->getParticipants()->contains($data['participant'])) : ?>checked="checked"<?php endif; ?>                           
                           value="<?= $activity->getId() ?>">                                                      
                    <label for="act_<?= $activity->getId() ?>">
                        <?= $activity->getName() ?>                                
                        <?php if ($activity->remainingVacancies() !== 'Unlimited') : ?>
                            (<?php if ($activity->hasVacancy()) : ?>
                                <span data-i18n="event:message.remaining_vacancies"></span>: <?= $activity->remainingVacancies() ?>                                                   
                            <?php else : ?>
                                <span data-i18n="event:message.no_vacancy" class="text-danger"></span>                                                   
                            <?php endif; ?>)
                        <?php endif; ?>
                    </label>                            
                    <br>
                </div>             
            <?php endforeach; ?>                                 
        </fieldset>                    
        <input type="hidden" id="eventId" name="id" value="<?= $data['event']->getId() ?>">                                                    
        <input type="hidden" name="participant" value="<?= $data['participant']->getId() ?>">
    </form>  
</div>

<nav id="admin-navbar" class="navbar navbar-default navbar-fixed-bottom" role="navigation">    
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="align-center">
        <a href="#" onclick="accreditation.override(event)" class="navbar-link" title="Confirm">
            <i class="fa fa-check-circle fa-4x"></i>
        </a>
    </div><!-- /.navbar-collapse -->
</nav>