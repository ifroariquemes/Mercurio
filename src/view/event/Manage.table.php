<?php
global $_MyCookie;
global $_MyCookieUser;
$uid = uniqid();
?>
<div class="tab-content">  
    <?php foreach ($data as $index => $page): ?>
        <div class="tab-pane fade <?php if ($index === 0) : ?>in active<?php endif; ?>" id="pag_<?php echo $uid . $index ?>">                        
            <table class="table table-striped">
                <thead>
                    <tr>      
                        <th><?php _e('Name', 'event') ?></th>  
                        <th><?php _e('Organization', 'event') ?></th>                                        
                        <th><?php _e('Starts', 'event') ?></th>                                         
                        <th><?php _e('Ends', 'event') ?></th>
                        <th><?php _e('Registred activities', 'event') ?></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>                                    
                    <?php
                    foreach ($page as $event) :
                        $url = controller\event\EventController::urlManage($event);
                        ?>
                        <tr>          
                            <td>
                                <a href="<?php echo $url ?>"><?php echo $event->getName(); ?></a>                                
                            </td> 
                            <td><?php echo $event->getOrganization()->getName() ?></td>
                            <td><?php echo $event->getStartDate() ?></td>                            
                            <td><?php echo $event->getEndDate() ?></td>  
                            <td><?php echo count($event->getActivities()) ?></td>
                            <td class="hidden-sm hidden-xs text-right">                                                                                                                                
                                <a href="<?php echo $url ?>" class="btn btn-default">
                                    <?php if ($_MyCookieUser->getAccountType()->getFlag() == 'ADMINISTRATOR') : ?>
                                        <i class="fa fa-pencil"></i>
                                    <?php elseif (!$event->getParticipants()->contains($_MyCookieUser)) : ?>
                                        <i class="fa fa-sign-in"></i> <?php _e('Register', 'event') ?>
                                    <?php else: ?>
                                        <i class="fa fa-edit"></i> <?php _e('Update registration', 'event') ?>
                                    <?php endif; ?>
                                </a>                                
                            </td>
                        </tr>
                    <?php endforeach; ?>                                            
                </tbody>                            
            </table>
        </div>   
    <?php endforeach; ?>     
    <?php if (count($data) > 1) : ?>
        <div class="text-center">
            <ul class="pagination">                        
                <?php foreach ($data as $index => $page) : ?>
                    <li class="<?php if ($index === 0) : ?>active<?php endif; ?>">
                        <a href="#pag_<?php echo $uid . $index ?>" data-toggle="tab"><?php echo $index + 1 ?></a>
                    </li>
                <?php endforeach; ?>                                                                    
            </ul>
        </div>
    <?php endif; ?>
</div>