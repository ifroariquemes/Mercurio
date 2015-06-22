<?php global $_MyCookie; ?>
<?php $_MyCookie->loadView('event/accreditation', 'participants.header', $data) ?>
<h2 data-i18n="event:frequency.label.event_activities"></h2>

<div id="lstDataParticipant" class="row">
    <div class="col-lg-12">  
        <?php $_MyCookie->loadView('event/frequency', 'activities.table', $data); ?>
        <div class="clear"></div>
    </div>
</div>