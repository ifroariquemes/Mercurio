<?php if (!empty($data->getParticipants())) : ?>
    <table class="table">
        <thead>
            <tr>
                <th><?php _e('Name', 'user') ?></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data->getParticipants() as $user) : ?>
                <tr>
                    <td><a href="#" onclick="evt.showCredentials(event, <?php echo $data->getId() ?>, <?php echo $user->getId() ?>)"><?php echo $user->getCompleteName() ?></a><?php if ($data->isConfirmed($user)) : ?> (<?php _e('Confirmed', 'event') ?>)<?php endif; ?></td>   
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else : ?>
    <?php _e('There is no registrations in this event at the moment', 'event') ?>.
<?php endif; ?>