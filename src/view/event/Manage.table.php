<?php
global $_MyCookie;
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
                        $url = $_MyCookie->mountLink('administrator', 'event', 'edit', $event->getId());
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
                                <a href="<?php echo $url ?>" class="btn btn-default"><i class="fa fa-pencil"></i></a>                                
                            </td>
                        </tr>
                    <?php endforeach; ?>                                            
                </tbody>                            
            </table>
        </div>   
    <?php endforeach; ?>     
    <div class="text-center">
        <ul class="pagination">                        
            <?php foreach ($data as $index => $page) : ?>
                <li class="<?php if ($index === 0) : ?>active<?php endif; ?>">
                    <a href="#pag_<?php echo $uid . $index ?>" data-toggle="tab"><?php echo $index + 1 ?></a>
                </li>
            <?php endforeach; ?>                                                                    
        </ul>
    </div>
</div>