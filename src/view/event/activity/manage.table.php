<?php
$activity = $data['activity'];
$iAct = $data['iAct'];
?>
<tr data-id="<?= $iAct ?>">
    <td><input type="hidden" name="Activity[<?= $iAct ?>][Name]" value="<?= $activity->getName() ?>"><span><?= $activity->getName() ?></span></td>
    <td><input type="hidden" name="Activity[<?= $iAct ?>][Type]" value="<?= $activity->getType()->getId() ?>"><span><?= $activity->getType()->getName() ?></span></td>
    <td><input type="hidden" name="Activity[<?= $iAct ?>][Duration]" value="<?= $activity->getDuration() ?>"><span><?= $activity->getDuration() ?></span></td>
    <td>
        <?php if (!empty($activity->getSpeakers())) : ?>
            <?php foreach ($activity->getSpeakers() as $iSpk => $speaker) : ?>
                <input type="hidden" name="Activity[<?= $iAct ?>][Speakers][<?= $iSpk ?>]" value="<?= $speaker ?>"><?= $speaker ?><br>                                            
            <?php endforeach; ?>
        <?php endif; ?>
    </td>
    <td class="text-center">
        <input type="hidden" name="Activity[<?= $iAct ?>][HasCertificate]" value="<?= var_export($activity->getHasCertificate()) ?>"><i class="fa <?php if ($activity->getHasCertificate()) : ?>fa-check text-success<?php else : ?>fa-times text-danger<?php endif; ?>"></i>
    </td>
    <td class="text-center">
        <input type="hidden" name="Activity[<?= $iAct ?>][HasSubmissions]" value="<?= var_export($activity->getHasSubmissions()) ?>"><i class="fa <?php if ($activity->getHasSubmissions()) : ?>fa-check text-success<?php else : ?>fa-times text-danger<?php endif; ?>"></i>
    </td>
    <td><input type="hidden" name="Activity[<?= $iAct ?>][Vacancies]" value="<?= $activity->getVacancies() ?>"><span><?= $activity->getVacancies() ?></span></td>
    <td><?= $activity->getParticipants()->count() ?></td>    
    <td class="text-right">
        <?php if (!empty($activity->getSessions())) : ?>
            <?php foreach ($activity->getSessions() as $iSes => $session) : ?>
                <input type="hidden" name="Activity[<?= $iAct ?>][Sessions][<?= $iSes ?>][date]" value="<?= $session->getDate() ?>">                                            
                <input type="hidden" name="Activity[<?= $iAct ?>][Sessions][<?= $iSes ?>][start]" value="<?= $session->getStart() ?>">
                <input type="hidden" name="Activity[<?= $iAct ?>][Sessions][<?= $iSes ?>][end]" value="<?= $session->getEnd() ?>">
            <?php endforeach; ?>
        <?php endif; ?>
        <input type="hidden" name="Activity[<?= $iAct ?>][Id]" value="<?= $activity->getId() ?>">        
        <input type="hidden" name="Activity[<?= $iAct ?>][Description]" value="<?= $activity->getDescription() ?>">        
        <?php if ($activity->getId()) : ?>
            <button type="button" class="btn btn-default" data-i18n="[title]event:activity.button.presence_confirmation"><i class="fa fa-users"></i></button>
        <?php endif; ?>
        <button type="button" data-i18n="[title]mycookie:button.edit" class="btn btn-default" onclick="activity.edit('<?= $iAct ?>', <?= var_export(is_null($activity->getId()) || isset($data['onSession'])) ?>)"><i class="fa fa-edit"></i></button>        
    </td>
</tr>