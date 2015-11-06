<?php global $_MyCookie; ?>
<?php global $_User; ?>
<?php if ($data['events']->count()) : ?>    
    <table class="table table-striped">
        <thead>
            <tr>      
                <th data-i18n="event:label.name"></th>  
                <th data-i18n="event:label.organization"></th>                                        
                <th data-i18n="event:label.starts"></th>                                         
                <th data-i18n="event:label.ends"></th>
                <th data-i18n="event:label.registred_activities"></th>
                <th></th>
            </tr>
        </thead>
        <tbody>                                    
            <?php
            foreach ($data['events'] as $event) :
                $url = controller\event\EventController::urlManage($event);
                $urlReg = controller\event\EventController::urlManage($event, true);
                $urlAccreditation = $_MyCookie->mountLink('administrator', 'event', 'accreditation', 'participants', $event->getId());
                $urlFrequency = $_MyCookie->mountLink('administrator', 'event', 'frequency', 'manage', $event->getId());
                ?>
                <tr>          
                    <td>
                        <a href="<?= $url ?>"><?= $event->getName(); ?></a>                                
                    </td> 
                    <td><?= $event->getOrganization()->getName() ?></td>
                    <td><?= $event->getStartDate() ?></td>                            
                    <td><?= $event->getEndDate() ?></td>  
                    <td><?= count($event->getActivities()) ?></td>
                    <td class="text-right">
                        <?php if ($_User->getAccountType()->getFlag() == 'ADMINISTRATOR') : ?>
                            <?php if ($event->getIsOpen()) : ?>
                                <a href="<?= $urlFrequency ?>" class="btn btn-default"><i class="fa fa-clock-o"></i> <span data-i18n="event:button.frequency"></span></a>
                                <a href="<?= $urlAccreditation ?>" class="btn btn-default hidden-sm hidden-xs"><i class="fa fa-star"></i> <span data-i18n="event:button.accreditation"></span></a>
                            <?php endif; ?>
                            <?php if ($event->getIsRegistrationOpen()) : ?>    
                                <a href="<?= $urlReg ?>" class="btn btn-default hidden-sm hidden-xs">                                                           
                                    <?php if (!$event->getParticipants()->contains($_User)) : ?>
                                        <i class="fa fa-sign-in"></i> <span data-i18n="event:button.register"></span>
                                    <?php else: ?>
                                        <i class="fa fa-edit"></i> <span data-i18n="event:button.update"></span>                            
                                    <?php endif; ?>
                                </a>                                          
                            <?php endif; ?>
                        <?php endif; ?>
                        <a href="<?= $url ?>" class="btn btn-default hidden-sm hidden-xs">
                            <?php if ($_User->getAccountType()->getFlag() == 'ADMINISTRATOR') : ?>
                                <i class="fa fa-pencil"></i>
                            <?php elseif ($event->getIsRegistrationOpen()) : ?>  
                                <?php if (!$event->getParticipants()->contains($_User)) : ?>
                                    <i class="fa fa-sign-in"></i> <span data-i18n="event:button.register"></span>
                                <?php else: ?>
                                    <i class="fa fa-edit"></i> <span data-i18n="event:button.update"></span>
                                <?php endif; ?>
                            <?php endif; ?>
                        </a>                                
                    </td>
                </tr>
            <?php endforeach; ?>                                            
        </tbody>                            
    </table>                
<?php else : ?>
    <br>
    <div class="alert alert-info">
        <span data-i18n="event:message.empty"></span>
    </div>
<?php endif;