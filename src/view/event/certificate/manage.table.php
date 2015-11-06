<?php global $_MyCookie; ?>
<?php if ($data->count()) : ?>
    <table class="table table-striped">
        <thead>
            <tr>      
                <th data-i18n="event:certificate.label.name"></th>                  
                <th></th>
            </tr>
        </thead>
        <tbody>                                    
            <?php
            foreach ($data as $template) :
                $url = $_MyCookie->mountLink('administrator', 'event', 'certificate', 'edit', $template->getId());                
                ?>
                <tr>          
                    <td>
                        <a href="<?= $url ?>"><?= $template->getName(); ?></a>                                
                    </td>                     
                    <td class="hidden-sm hidden-xs text-right">                                                       
                        <a href="<?= $url ?>" class="btn btn-default" data-i18n="[title]mycookie:button.edit"><i class="fa fa-pencil"></i></a>                                
                    </td>
                </tr>
            <?php endforeach; ?>                                            
        </tbody>                            
    </table>
<?php else : ?>    
    <div class="alert alert-info">
        <span data-i18n="event:certificate.message.empty"></span>
    </div>
<?php endif;