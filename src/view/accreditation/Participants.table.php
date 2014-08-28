<?php global $_MyCookie ?>
<?php if (count($data->getParticipants())) : ?>
    <table class="table">
        <thead>
            <tr>
                <th><?php _e('Name', 'user') ?></th>               
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data->getParticipants() as $user) : ?>
                <tr <?php if ($data->isConfirmed($user)) : ?>class="success"<?php endif; ?>>
                    <td><a href="<?php echo $_MyCookie->mountLink('administrator', 'accreditation', 'activities', $data->getId(), $user->getId()) ?>" onclick="evt.showCredentials(event, <?php echo $data->getId() ?>, <?php echo $user->getId() ?>)"><?php echo $user->getCompleteName() ?></a></td>   
                    <td class="text-success"><?php if ($data->isConfirmed($user)) : ?> <i class="fa fa-check"></i> <?php _e('Confirmed', 'event') ?> <?php endif; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else : ?>
    <?php _e('There is no registrations in this event at the moment', 'event') ?>.
<?php endif; ?>