<?php global $_MyCookie; ?>
<?php global $_User; ?>
<?php if (count($data['events'])) : ?>    
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
                $url = $_MyCookie->mountLink('event', 'register', $event->getId());
                ?>
                <tr>          
                    <td>
                        <a href="<?= $url ?>"><?= $event->getName(); ?></a>                                
                    </td> 
                    <td><?= $event->getOrganization()->getName() ?></td>
                    <td><?= $event->getStartDate() ?></td>                            
                    <td><?= $event->getEndDate() ?></td>  
                    <td><?= $event->getActivities()->count() ?></td>
                    <td class="text-right">
                        <a href="<?= $url ?>" class="btn btn-default hidden-sm hidden-xs">
                            <?php if (!$event->getParticipants()->contains($_User)) : ?>
                                <i class="fa fa-sign-in"></i> <span data-i18n="event:button.register"></span>
                            <?php else: ?>
                                <i class="fa fa-edit"></i> <span data-i18n="event:button.update"></span>
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