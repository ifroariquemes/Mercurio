<?php global $_MyCookie; ?>
<?php if ($data->count()) : ?>
    <table class="table table-striped">
        <thead>
            <tr>      
                <th data-i18n="event:organization.label.name"></th>  
                <th data-i18n="event:organization.label.city"></th>                                        
                <th data-i18n="event:organization.label.state"></th>                                         
                <th></th>
            </tr>
        </thead>
        <tbody>                                    
            <?php
            foreach ($data as $organization) :
                $url = $_MyCookie->mountLink('administrator', 'organization', 'edit', $organization->getId());
                $urlInt = $_MyCookie->mountLink('administrator', 'event', 'add', $organization->getId());
                $urlCert = $_MyCookie->mountLink('administrator', 'certificate', 'templates', $organization->getId());
                ?>
                <tr>          
                    <td>
                        <a href="<?= $url ?>"><?= $organization->getName(); ?></a>                                
                    </td> 
                    <td><?= $organization->getCity() ?></td>
                    <td><?= $organization->getState() ?></td>                            
                    <td class="hidden-sm hidden-xs text-right">                                
                        <a href="<?= $urlCert ?>" class="btn btn-default"><i class="fa fa-certificate"></i> <span data-i18n="event:organization.button.certificate_templates"></span></a>
                        <a href="<?= $urlInt ?>" class="btn btn-default"><i class="fa fa-paperclip"></i> <span data-i18n="event:organization.button.new_event"></span></a>
                        <a href="<?= $url ?>" class="btn btn-default" data-i18n="[title]mycookie:button.edit"><i class="fa fa-pencil"></i></a>                                
                    </td>
                </tr>
            <?php endforeach; ?>                                            
        </tbody>                            
    </table>
<?php else : ?>
    <br>
    <div class="alert alert-info">
        <span data-i18n="event:organization.message.empty"></span>
    </div>
<?php endif;