<?php global $_MyCookie; ?>
<?php global $_User; ?>
<h2>Certificados</h2>
<?php if (count($data)) : ?>    
    <table class="table table-striped">
        <thead>
            <tr>      
                <th data-i18n="event:label.name"></th>  
                <th data-i18n="event:label.organization"></th>                                        
                <th data-i18n="event:label.starts"></th>                                         
                <th data-i18n="event:label.ends"></th>
                <th></th>
            </tr>
        </thead>
        <tbody>                                    
            <?php
            foreach ($data as $event) :
                $url = $_MyCookie->mountLink('cert', $event->getId()) . "{$_User->getId()}.pdf";
                ?>
                <tr>          
                    <td>
                        <a target="_blank" href="<?= $url ?>"><?= $event->getName(); ?></a>                                
                    </td> 
                    <td><?= $event->getOrganization()->getName() ?></td>
                    <td><?= $event->getStartDate() ?></td>                            
                    <td><?= $event->getEndDate() ?></td>  
                    <td class="text-right">
                        <a target="_blank" href="<?= $url ?>" class="btn btn-default hidden-sm hidden-xs">
                            <i class="glyphicon glyphicon-certificate"></i> Emitir certificado
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