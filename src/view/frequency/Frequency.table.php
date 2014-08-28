<?php global $_MyCookie ?>
<?php if (count($data->getParticipants())) : ?>
    <table class="table">
        <thead>
            <tr>
                <th><?php _e('Name', 'user') ?></th>                               
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data->getParticipants() as $participant) : ?>
                <tr>
                    <td><input type="checkbox" onclick="frequency.check(this)" data-id="<?php echo $participant->getId() ?>" <?php if ($data->getPresent()->contains($participant)) : ?>checked="checked"<?php endif; ?>> <?php echo $participant->getCompleteName() ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else : ?>
    <?php _e('There is no participants in this activity', 'frequency') ?>.
<?php endif; 