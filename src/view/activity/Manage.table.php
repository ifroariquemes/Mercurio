<?php
$activity = $data['activity'];
$iAct = $data['iAct'];
?>
<tr data-id="<?php echo $iAct ?>">
    <td><input type="hidden" name="Activity[<?php echo $iAct ?>][Name]" value="<?php echo $activity->getName() ?>"><span><?php echo $activity->getName() ?></span></td>
    <td><input type="hidden" name="Activity[<?php echo $iAct ?>][Type]" value="<?php echo $activity->getType()->getId() ?>"><span><?php echo $activity->getType()->getName() ?></span></td>
    <td><input type="hidden" name="Activity[<?php echo $iAct ?>][Duration]" value="<?php echo $activity->getDuration() ?>"><span><?php echo $activity->getDuration() ?></span></td>
    <td>
        <?php if (!empty($activity->getSpeakers())) : ?>
            <?php foreach ($activity->getSpeakers() as $iSpk => $speaker) : ?>
                <input type="hidden" name="Activity[<?php echo $iAct ?>][Speakers][<?php echo $iSpk ?>]" value="<?php echo $speaker ?>"><?php echo $speaker ?><br>                                            
            <?php endforeach; ?>
        <?php endif; ?>
    </td>
    <td class="text-center">
        <input type="hidden" name="Activity[<?php echo $iAct ?>][HasCertificate]" value="<?php echo var_export($activity->getHasCertificate()) ?>"><i class="fa <?php if ($activity->getHasCertificate()) : ?>fa-check text-success<?php else : ?>fa-times text-danger<?php endif; ?>"></i>
    </td>
    <td class="text-center">
        <input type="hidden" name="Activity[<?php echo $iAct ?>][HasSubmissions]" value="<?php echo var_export($activity->getHasSubmissions()) ?>"><i class="fa <?php if ($activity->getHasSubmissions()) : ?>fa-check text-success<?php else : ?>fa-times text-danger<?php endif; ?>"></i>
    </td>
    <td><input type="hidden" name="Activity[<?php echo $iAct ?>][Vacancies]" value="<?php echo $activity->getVacancies() ?>"><span><?php echo $activity->getVacancies() ?></span></td>
    <td><?php echo count($activity->getParticipants()) ?></td>
    <td>
        <?php if ($activity->getId()) : ?>
            <button type="button" class="btn btn-default" onclick="" title="<?php _e('Presence confirmation', 'activity') ?>"><i class="fa fa-users"></i></button>
        <?php endif; ?>
    </td>
    <td>
        <input type="hidden" name="Activity[<?php echo $iAct ?>][Id]" value="<?php echo $activity->getId() ?>">        
        <input type="hidden" name="Activity[<?php echo $iAct ?>][Description]" value="<?php echo $activity->getDescription() ?>">        
        <button type="button" title="<?php _e('Edit', 'activity') ?>" class="btn btn-default" onclick="activity.edit('<?php echo $iAct ?>', <?php var_export(is_null($activity->getId())) ?>)"><i class="fa fa-edit"></i></button>        
    </td>
</tr>