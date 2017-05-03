<?php
$event = $data['event'];
?>    
<header class="row">     
    <div class="col-md-12"><h2 data-i18n="event:label.<?= $data['action'] ?>_event"></h2></div>
</header>    
<div class="row" id="scr-1">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <form name="FrmEventEdit" id="FrmEventEdit" role="form" onsubmit="evt.next(event);">
                    <fieldset>
                        <div class="form-group">
                            <label for="textName"><span data-i18n="event:label.name"></span>:</label>                            
                            <input type="text" required="required" name="Name" id="textName" class="form-control" value="<?= $event->getName() ?>">                            
                        </div>             
                        <div class="form-group">
                            <label for="selectOrganization"><span data-i18n="event:label.organization"></span>:</label>                            
                            <?php \controller\organization\OrganizationController::select($event->getOrganization()) ?>
                        </div>             
                        <div class="form-group">
                            <label for="textDescription"><span data-i18n="event:label.description"></span>:</label>                            
                            <textarea id="textDescription" name="Description" class="form-control" required><?= $event->getDescription() ?></textarea>
                        </div>             
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="dateStart"><span data-i18n="event:label.starts"></span>:</label>                            
                                    <input type="date" required="required" name="StartDate" id="dateStart" class="form-control" value="<?= $event->getStartDateUS() ?>">                            
                                </div>             
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="dateEnd"><span data-i18n="event:label.ends"></span>:</label>                            
                                    <input type="date" required="required" name="EndDate" id="dateEnd" class="form-control" value="<?= $event->getEndDateUS() ?>">                            
                                </div>           
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="textAddress"><span data-i18n="event:label.address"></span>:</label>                            
                                    <input type="text" required="required" name="Address" id="textAddress" class="form-control" value="<?= $event->getAddress() ?>">                            
                                </div>             
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="checkOpen"><span data-i18n="event:label.is_open"></span>:</label>                            
                                    <input type="checkbox" name="IsOpen" id="checkOpen" value="true" <?php if ($event->getIsOpen()): ?>checked="checked"<?php endif; ?>>                            
                                </div>             
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="checkOpen"><span data-i18n="event:label.is_registration_open"></span>:</label>                            
                                    <input type="checkbox" name="IsRegistrationOpen" id="checkRegistrationOpen" value="true" <?php if ($event->getIsRegistrationOpen()): ?>checked="checked"<?php endif; ?>>                            
                                </div>             
                            </div>
                        </div>
                    </fieldset>
                    <input type="hidden" name="id" value="<?= $event->getId() ?>">                                
                    <input type="submit" style="position: absolute; visibility: hidden">
                </form>                                
            </div>
        </div>
        <?php if ($event->getId()) : ?>
            <div class="text-right">            
                <a href="#" onclick="evt.delete(event)" data-i18n="event:button.delete"></a>                
            </div>
        <?php endif; ?>
    </div>    
</div>

<?php \controller\event\ActivityController::manage($event) ?>

<nav id="admin-navbar" class="navbar navbar-default navbar-fixed-bottom" role="navigation">    
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="align-center">
        <div class="scr-1">
            <a href="#" class="navbar-link" data-i18n="[title]event:button.next" onclick="evt.next(event)">
                <i class="fa fa-arrow-circle-o-right fa-4x"></i>
            </a>
        </div>
        <div class="scr-2 hidden">
            <a href="#" class="navbar-link" data-i18n="[title]event:button.previous" onclick="evt.previous(event)">
                <i class="fa fa-arrow-circle-o-left fa-4x"></i>
            </a> &nbsp;&nbsp;&nbsp;
            <a href="#" class="navbar-link" data-i18n="[title]event:button.save" onclick="evt.submit(event)">
                <i class="fa fa-save fa-4x"></i>
            </a>
        </div>
    </div><!-- /.navbar-collapse -->
</nav>

<script type="text/javascript">
    require(['jquery', 'summernote'], function($) {
        $(function() {
            $('#textName').focus();
            $('#textDescription').summernote({height: 200});
        });
    });
</script>