<?php global $_MyCookie ?>
<?php if ($data->getConfirmed()->count()) : ?>
    <table class="table">
        <thead>
            <tr>
                <th data-i18n="event:activity.label.name"></th>               
                <th data-i18n="event:accreditation.label.registred"></th>                    
                <th data-i18n="event:accreditation.label.confirmed"></th>
                <th data-i18n="event:frequency.label.presents"></th>
                <th data-i18n="event:frequency.label.signature_list"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data->getActivities() as $activity) : ?>
                <tr>
                    <td><a href="<?= $_MyCookie->mountLink('administrator', 'event', 'frequency', 'activity', $activity->getId()) ?>"><?= $activity->getName() ?></a></td>                       
                    <td><?= $activity->getParticipants()->count() ?></td>
                    <td><?= $activity->getConfirmed() ?></td>
                    <td><?= $activity->getPresent()->count() ?></td>
                    <td><a target="_blank" href="<?= $_MyCookie->mountLink('event', 'frequency', 'printList', $activity->getId()) ?>?async=true" class="btn btn-default"><i class="fa fa-list"></i></a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else : ?>
    <br>
    <div class="alert alert-info">
        <span data-i18n="event:frequency.message.empty"></span>
    </div>    
<?php endif; ?>