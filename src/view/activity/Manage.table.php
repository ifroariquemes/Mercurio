<?php
$activity = $data['activity'];
$iAct = $data['iAct'];
?>
<tr>
    <td><input type="hidden" name="Name[<?php echo $iAct ?>]" value="<?php echo $activity->getName() ?>"><span><?php echo $activity->getName() ?></span></td>
    <td><input type="hidden" name="Type[<?php echo $iAct ?>]" value="<?php echo $activity->getType()->getId() ?>"><span><?php echo $activity->getType()->getName() ?></span></td>
    <td><input type="hidden" name="Duration[<?php echo $iAct ?>]" value="<?php echo $activity->getDuration() ?>"><span><?php echo $activity->getDuration() ?></span></td>
    <td>
        <?php if (!empty($activity->getSpeakers())) : ?>
            <?php foreach ($activity->getSpeakers() as $iSpk => $speaker) : ?>
                <input type="hidden" name="Speaker[<?php echo $iAct ?>][<?php echo $iSpk ?>]" value="<?php echo $speaker->getId() ?>"><?php echo $speaker->getCompleteName() ?><br>                                            
            <?php endforeach; ?>
        <?php endif; ?>
    </td>
    <td class="text-center">
        <input type="hidden" name="HasCertificate[<?php echo $iAct ?>]" value="<?php echo var_export($activity->getHasCertificate()) ?>"><i class="fa <?php if ($activity->getHasCertificate()) : ?>fa-check text-success<?php else : ?>fa-times text-danger<?php endif; ?>"></i>
    </td>
    <td class="text-center">
        <input type="hidden" name="HasSubmissions[<?php echo $iAct ?>]" value="<?php echo var_export($activity->getHasSubmissions()) ?>"><i class="fa <?php if ($activity->getHasSubmissions()) : ?>fa-check text-success<?php else : ?>fa-times text-danger<?php endif; ?>"></i>
    </td>
    <td><button type="button"><i class="fa fa-edit"></i></button></td>
</tr>