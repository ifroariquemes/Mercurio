<?php global $_MyCookie ?>
<?php if (count($data->getActivities())) : ?>
    <table class="table">
        <thead>
            <tr>
                <th><?php _e('Name', 'user') ?></th>               
                <th>Registred</th>                    
                <th>Confirmed</th>
                <th>Presents</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data->getActivities() as $activity) : ?>
                <tr>
                    <td><a href="<?php echo $_MyCookie->mountLink('administrator', 'frequency', 'activity', $activity->getId()) ?>"><?php echo $activity->getName() ?></a></td>                       
                    <td><?php echo count($activity->getParticipants()) ?></td>
                    <td><?php echo $activity->getConfirmed() ?></td>
                    <td><?php echo count($activity->getPresent()) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else : ?>
    <?php _e('There is no registrations in this event at the moment', 'event') ?>.
<?php endif; ?>