<?php global $_MyCookie ?>
<?php global $_User ?>
<?php if (count($data['participants'])) : ?>
    <table class="table">
        <thead>
            <tr>
                <th data-i18n="user:label.name"></th>               
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['participants'] as $user) : ?>
                <tr <?php if ($data['event']->isConfirmed($user)) : ?>class="success"<?php endif; ?>>
                    <td><a href="<?= $_MyCookie->mountLink('administrator', 'event', 'accreditation', 'activities', $data['event']->getId(), $user->getId()) ?>" onclick="evt.showCredentials(event, <?= $data['event']->getId() ?>, <?= $user->getId() ?>)"><?= $user->getName() ?></a></td>   
                    <td class="text-right">
                        <?php if ($data['event']->isConfirmed($user)) : ?>
                            <?php if ($_User->getAccountType()->getFlag() == 'ADMINISTRATOR') : ?>
                                <a href="<?= $_MyCookie->mountLink('administrator', 'event', 'accreditation', 'override', $data['event']->getId(), $user->getId()) ?>" class="btn btn-default"><i class="fa fa-exchange"></i> <span data-i18n="event:accreditation.label.override_activities"></span></a>
                            <?php endif; ?>
                            <span class="text-success"><i class="fa fa-check"></i> <span data-i18n="event:accreditation.label.confirmed"></span></span>
                        <?php endif; ?>                        
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else : ?>
    <br>
    <div class="alert alert-info">
        <span data-i18n="event:accreditation.message.empty"></span>
    </div>    
<?php endif; ?>