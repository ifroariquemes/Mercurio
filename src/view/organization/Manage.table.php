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
                        <th><?php _e('Name', 'organization') ?></th>  
                        <th><?php _e('City', 'organization') ?></th>                                        
                        <th><?php _e('State', 'organization') ?></th>                                         
                        <th></th>
                    </tr>
                </thead>
                <tbody>                                    
                    <?php
                    foreach ($page as $organization) :
                        $url = $_MyCookie->mountLink('administrator', 'organization', 'edit', $organization->getId());
                        $urlInt = $_MyCookie->mountLink('administrator', 'event', 'add', $organization->getId());
                        ?>
                        <tr>          
                            <td>
                                <a href="<?php echo $url ?>"><?php echo $organization->getName(); ?></a>                                
                            </td> 
                            <td><?php echo $organization->getCity() ?></td>
                            <td><?php echo $organization->getState() ?></td>                            
                            <td class="hidden-sm hidden-xs text-right">                                
                                <a href="<?php echo $urlInt ?>" class="btn btn-primary"><i class="fa fa-paperclip"></i> <?php _e('New event', 'organization') ?></a>
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