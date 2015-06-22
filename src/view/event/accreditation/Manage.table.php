<?php
global $_MyCookie;
global $_MyCookieUser;
$uid = uniqid();
?>
<div class="tab-content">  
    <?php foreach ($data as $index => $page): ?>
        <div class="tab-pane fade <?php if ($index === 0) : ?>in active<?php endif; ?>" id="pag_<?= $uid . $index ?>">                        
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
                        $url = $_MyCookie->mountLink('administrator', 'accreditation', 'participants', $event->getId());
                        $urlFreq = $_MyCookie->mountLink('administrator', 'frequency', 'event', $event->getId());
                        ?>
                        <tr>          
                            <td>
                                <a href="<?= $url ?>"><?= $event->getName(); ?></a>                                
                            </td> 
                            <td><?= $event->getOrganization()->getName() ?></td>
                            <td><?= $event->getStartDate() ?></td>                            
                            <td><?= $event->getEndDate() ?></td>  
                            <td><?= count($event->getActivities()) ?></td>
                            <td class="hidden-sm hidden-xs text-right">    
                                <a href="<?= $urlFreq ?>" class="btn btn-default"><i class="fa fa-clock-o"></i> Frequency</a>
                                <a href="<?= $url ?>" class="btn btn-primary">                                    
                                    <i class="fa fa-file-text"></i> Participants
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
                        <a href="#pag_<?= $uid . $index ?>" data-toggle="tab"><?= $index + 1 ?></a>
                    </li>
                <?php endforeach; ?>                                                                    
            </ul>
        </div>
    <?php endif; ?>
</div>