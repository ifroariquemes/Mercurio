<div class="panel panel-info">
    <div class="panel-heading">
        <h4 data-i18n="event:accreditation.label.event_info"></h4>
    </div>
    <div class="panel-body">
        <div class="col-md-6">
            <label><span data-i18n="event:label.name"></span>:</label>
            <?= $data->getName(); ?>
        </div>        
        <div class="col-md-6">
            <label><span data-i18n="event:label.organization"></span>:</label>        
            <?= $data->getOrganization()->getName() ?>
        </div>
        <div class="col-md-3">
            <label><span data-i18n="event:label.starts"></span>:</label>
            <?= $data->getStartDate() ?>
        </div>
        <div class="col-md-3">
            <label><span data-i18n="event:label.ends"></span>:</label>
            <?= $data->getEndDate() ?>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-3">
            <label><span data-i18n="event:accreditation.label.registred"></span>:</label>
            <?= count($data->getParticipants()) ?>
        </div>
        <div class="col-md-3">
            <label><span data-i18n="event:accreditation.label.confirmed"></span>:</label>
            <?= count($data->getConfirmed()) ?>
        </div>
    </div>
</div>