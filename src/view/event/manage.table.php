<?php
global $_MyCookie;
global $_User;
global $_BaseURL;
?>
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
                $urlCert = $_MyCookie->mountLink('administrator', 'event', 'printCertificates', $event->getId());
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
                        <?php if ($_User->getAccountType()->getFlag() !== 'USER') : ?>
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
                        <?php if ($_User->getAccountType()->getFlag() == 'ADMINISTRATOR') : ?>
                            <a href="<?= $urlCert ?>" class="btn btn-default hidden-sm hidden-xs">
                                <i class="fa fa-certificate"></i> Gerar certificados
                            </a>    
                            <a href="<?= $url ?>" class="btn btn-default hidden-sm hidden-xs">
                                <i class="fa fa-pencil"></i>
                            </a>    
                            <a href="#" onclick="$('#eventId').val(<?= $event->getId() ?>)" data-toggle="modal" data-target="#mensagem"><i class="fa fa-comment"></i> Mensagem</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>                                            
        </tbody>                            
    </table> 
    <div class="modal fade" id="mensagem" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Enviar mensagem para inscritos</h4>
                </div>
                <div class="modal-body">
                    <form id="FrmMensagem">
                        <textarea id="pMensagem" name="mensagem" class="form-control"></textarea>
                        <input type="hidden" name="eventId" id="eventId">
                        <input type="hidden" name="async" value="true">
                    </form>
                    <a href="<?= $_BaseURL ?>event/loadEmails/?async&eventId=<?= $event->getId() ?>" target="_blank">Carregar lista de e-mails</a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="enviarMensagem()">Enviar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <script>
        require(['jquery', 'summernote'], function ($) {
            $('#pMensagem').summernote({height: 200});
            $('#carregandoEmails').hide();
        });

        function enviarMensagem() {
            MyCookieJS.showWaitMessage('Enviando e-mails (isso pode demorar muitos minutos)');
            $.ajax({
                type: 'POST',
                url: '<?= $_BaseURL ?>event/sendMessage/?async',
                data: $('#FrmMensagem').serialize(),
                success: function (msg) {
                    if (msg === '') {
                        MyCookieJS.alert('Mensagem enviada com sucesso!', function () {
                            location.reload();
                        });
                    } else {
                        MyCookieJS.alert(msg, function () {
                            MyCookieJS.closeWaitMessage();
                            MyCookieJS.closeAllPopups();
                        });
                    }
                }
            });
        }
    </script>
<?php else : ?>
    <br>
    <div class="alert alert-info">
        <span data-i18n="event:message.empty"></span>
    </div>
<?php endif;