<?php global $_MyCookie; ?>
<?php global $_User; ?>
<?php if ($data->count()) : ?>
    <table class="table table-striped">
        <thead>
            <tr>      
                <th data-i18n="user:label.name">Name</th>
                <th data-i18n="user:label.account_type">Account Type</th>
                <th data-i18n="user:label.email">E-mail</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($data as $user):
                $url = $_MyCookie->mountLink('administrator', 'user', 'edit', $user->getId());
                ?>
                <tr>          
                    <td>
                        <a href="<?= $url ?>"><?= sprintf('%s %s', $user->getFirstName(), $user->getLastName()); ?></a>
                        <?php if (!$user->getStatus()) : ?><span class="text-danger"><?= sprintf('(%s)', $user->getStatusStr()); ?></span><?php endif; ?>
                    </td>
                    <td><?= $user->getAccountType()->getName(); ?></td>
                    <td><?= $user->getEmail(); ?></td>
                    <td class="hidden-sm hidden-xs"><a href="<?= $url ?>" class="btn btn-default pull-right"><i class="fa fa-pencil"></i> <span data-i18n="mycookie:button.edit">Edit</span></a></td>
                </tr>
            <?php endforeach; ?>            
        </tbody>
    </table>
<?php else : ?>
    <span data-i18n="user:message.empty">There is no user with this account type</span>
<?php endif; ?>