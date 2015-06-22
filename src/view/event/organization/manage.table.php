<?php global $_MyCookie; ?>
<?php if($data->count()) : ?>
<table class="table table-striped">
    <thead>
        <tr>      
            <th data-i18n="organization:label.name"></th>  
            <th data-i18n="organization:label.city"></th>                                        
            <th data-i18n="organization:label.state"></th>                                         
            <th></th>
        </tr>
    </thead>
    <tbody>                                    
        <?php
        foreach ($data as $organization) :
            $url = $_MyCookie->mountLink('administrator', 'event', 'organization', 'edit', $organization->getId());
            $urlInt = $_MyCookie->mountLink('administrator', 'event', 'add', $organization->getId());
            ?>
            <tr>          
                <td>
                    <a href="<?= $url ?>"><?= $organization->getName(); ?></a>                                
                </td> 
                <td><?= $organization->getCity() ?></td>
                <td><?= $organization->getState() ?></td>                            
                <td class="hidden-sm hidden-xs text-right">                                
                    <a href="<?= $urlInt ?>" class="btn btn-primary"><i class="fa fa-paperclip"></i> <span data-i18n="organization:button.new_event"></span></a>
                    <a href="<?= $url ?>" class="btn btn-default" data-i18n="[title]mycookie:button.edit"><i class="fa fa-pencil"></i></a>                                
                </td>
            </tr>
        <?php endforeach; ?>                                            
    </tbody>                            
</table>
<?php else : ?>
    <br>
    <div class="alert alert-info">
        <span data-i18n="organization:message.empty"></span>
    </div>
<?php endif;