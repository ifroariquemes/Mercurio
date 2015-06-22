<?php global $_MyCookie ?>
<?php if ($data->getParticipants()->count() && $data->getConfirmed() > 0) : ?>
    <table class="table">
        <thead>
            <tr>
                <th data-i18n="event:activity.label.name"></th>                               
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data->getParticipants() as $participant) : ?>
                <?php if ($data->getEvent()->getConfirmed()->contains($participant)) : ?>
                    <tr>
                        <td>
                            <input type="checkbox" onclick="frequency.check(this)" value="<?php echo $participant->getId() ?>" id="us_<?php echo $participant->getId() ?>" <?php if ($data->getPresent()->contains($participant)) : ?>checked="checked"<?php endif; ?>> 
                            <label for="us_<?php echo $participant->getId() ?>"><?php echo $participant->getName() ?></label>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
    <input type="hidden" id="actId" value="<?php echo $data->getId() ?>">
<?php else : ?>
    <br>
    <div class="alert alert-info">
        <span data-i18n="event:frequency.message.empty_participant"></span>
    </div>    
<?php endif; 