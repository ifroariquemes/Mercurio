<?php global $_User; ?>
<header class="row">     
    <div class="col-md-12"><h2 data-i18n="event:register.label.title"></h2></div>
</header>    
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 data-i18n="event:register.label.information"></h4>
            </div>
            <div class="panel-body">                
                <form id="FrmEventInfo">
                    <fieldset>
                        <div class="form-group col-md-6">
                            <label for="textName"><span data-i18n="event:label.name"></span>:</label>                            
                            <br><?= $data->getName() ?>
                        </div>             
                        <div class="form-group col-md-6">
                            <label for="selectOrganization"><span data-i18n="event:label.organization"></span>:</label>                            
                            <br><?= $data->getOrganization()->getName() ?>
                        </div>             
                        <div class="form-group col-md-12">
                            <label for="textDescription"><span data-i18n="event:label.description"></span>:</label>                            
                            <br><?= $data->getDescription() ?>
                        </div>             
                        <div class="form-group col-md-12">
                            <label for="textAddress"><span data-i18n="event:label.address"></span>:</label>                            
                            <br><?= $data->getAddress() ?>
                        </div>             
                        <div class="form-group col-md-6">
                            <label for="dateStart"><span data-i18n="event:label.starts"></span>:</label>                            
                            <?= $data->getStartDate() ?>
                        </div>             
                        <div class="form-group col-md-6">
                            <label for="dateEnd"><span data-i18n="event:label.ends"></span>:</label>                            
                            <?= $data->getEndDate() ?>
                        </div>           
                    </fieldset>
                    <input type="hidden" name="id" value="<?= $data->getId() ?>">                                                    
                </form>                                
            </div>
        </div>        
    </div>    
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4 data-i18n="event:label.activities"></h4>
            </div>
            <div class="panel-body">   
                <p data-i18n="event:message.select_activities"></p>
                <form id="FrmRegister">
                    <fieldset>
                        <?php foreach ($data->getActivities() as $activity) : ?>
                            <div class="form-group col-md-4">
                                <?php if ($activity->hasVacancy() || $activity->getParticipants()->contains($_User)): ?>
                                    <input type="checkbox" name="Activity[]" id="act_<?= $activity->getId() ?>" data-disable="<?= json_encode($activity->getDisable()) ?>"                                           
                                           <?php if ($activity->getParticipants()->contains($_User)) : ?>checked="checked"<?php endif; ?>
                                           value="<?= $activity->getId() ?>">
                                       <?php endif; ?>
                                <label for="act_<?= $activity->getId() ?>" data-toogle="tooltip" data-placement="right" 
                                       title="<?= $activity->getDescription() ?>">
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
                    <input type="hidden" name="id" value="<?= $data->getId() ?>">                                                    
                </form>                                
            </div>
        </div>        
    </div>    
</div>

<?php if ($data->getParticipants()->contains($_User)) : ?>
    <div class="row">
        <div class="col-md-12">
            <p class="text-right"><a href="#" onclick="evt.deleteRegistration(event)" data-i18n="event:register.button.delete"></a></p>
        </div>
    </div>
<?php endif ?>

<nav id="admin-navbar" class="navbar navbar-default navbar-fixed-bottom" role="navigation">    
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="align-center">                    
        <a href="#" class="navbar-link" data-i18n="[title]event:button.previous" onclick="MyCookieJS.goto('administrator/event')">
            <i class="fa fa-arrow-circle-o-left fa-4x"></i>
        </a> &nbsp;&nbsp;&nbsp;
        <a href="#" class="navbar-link" data-i18n="[title]event:button.save" onclick="evt.register(event)">
            <i class="fa fa-save fa-4x"></i>
        </a>        
    </div><!-- /.navbar-collapse -->
</nav>

<script type="text/javascript">
    require(['jquery'], function ($) {
        $(function () {
            $('#textName').focus();
            $('label[data-toogle=tooltip]').tooltip();
            evt.updateDisable();
            $('input[type="checkbox"]').change(function () {
                if ($(this).is(':checked')) {
                    evt.updateDisable();
                } else {
                    evt.actEnable($.parseJSON($(this).attr('data-disable')));
                }
            });
        });

    });
</script>