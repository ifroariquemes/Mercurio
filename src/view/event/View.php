<?php
global $_User;
global $_BaseURL;
$event = $data;
$url = controller\event\EventController::urlManage($event);
$urlReg = controller\event\EventController::urlManage($event, true);
$urlAccreditation = $_MyCookie->mountLink('administrator', 'event', 'accreditation', 'participants', $event->getId());
$urlFrequency = $_MyCookie->mountLink('administrator', 'event', 'frequency', 'manage', $event->getId());
$urlCert = $_MyCookie->mountLink('administrator', 'event', 'printCertificates', $event->getId());
$urlCertSpk = $_MyCookie->mountLink('administrator', 'event', 'printSpeakerCertificates', $event->getId());
$urlCertSpkLook = $_MyCookie->mountLink('cert', $event->getId(), 'speakers');
?>

<h1><?= $event->getName() ?></h1>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 data-i18n="event:register.label.information"></h4>
            </div>
            <div class="panel-body">                
                <form id="FrmEventInfo">
                    <fieldset>
                        <div class="form-group col-md-3">
                            <label for="selectOrganization"><span data-i18n="event:label.organization"></span>:</label>                            
                            <br><?= $event->getOrganization()->getName() ?>
                        </div>             
                        <div class="form-group col-md-3">
                            <label for="dateStart"><span data-i18n="event:label.starts"></span>:</label>                            
                            <br><?= $event->getStartDate() ?>
                        </div>             
                        <div class="form-group col-md-3">
                            <label for="dateEnd"><span data-i18n="event:label.ends"></span>:</label>                            
                            <br><?= $event->getEndDate() ?>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="dateEnd"><span data-i18n="event:label.registred_activities"></span>:</label>                            
                            <br><?= $event->getActivities()->count() ?>
                        </div>
                        <?php if (!$event->getIsOpen()) : ?>
                            <div class="col-md-12">
                                <label for="certSpk">Certificado dos ministrantes: </label>
                                <a href="<?= $urlCertSpkLook ?>" target="_blank">Abrir pasta</a>
                            </div>
                        <?php endif; ?>
                    </fieldset>
                    <input type="hidden" name="id" value="<?= $event->getId() ?>">                                                    
                </form>                                
            </div>
        </div>        
        <div id="admin-tile-section">            
            <?php if ($_User->getAccountType()->getFlag() !== 'USER') : ?>
                <?php if ($event->getIsOpen()) : ?>
                    <a class="thumbnail tile fa-links tile-yellow tile-double" href="<?= $urlAccreditation ?>">
                        <h1>Credenciamento</h1>
                        <i class="fa-3x fa fa-star"></i>
                    </a>                   
                    <a class="thumbnail tile fa-links tile-yellow tile-double" href="<?= $urlFrequency ?>">
                        <h1>Frequência</h1>
                        <i class="fa-3x fa fa-clock-o"></i>
                    </a>                                  
                <?php else : ?>
                    <a class="thumbnail tile fa-links tile-blue tile-auto" data-toggle="modal" data-target="#gerar-cert">
                        <h1>Gerar certificados</h1>
                        <i class="fa fa-3x fa-certificate"></i>
                    </a>                                 
                <?php endif; ?>
                <?php if ($event->getIsRegistrationOpen()) : ?>    
                    <a class="thumbnail tile fa-links tile-blue tile-double" href="<?= $urlReg ?>">                                                
                        <?php if (!$event->getParticipants()->contains($_User)) : ?>
                            <h1>Registrar</h1>
                            <i class="fa fa-3x fa-sign-in"></i>
                        <?php else: ?>
                            <h1>Atualizar registro</h1>
                            <i class="fa fa-3x fa-edit"></i>
                        <?php endif; ?>
                    </a>  
                <?php endif; ?>
            <?php endif; ?>
            <?php if ($_User->getAccountType()->getFlag() == 'ADMINISTRATOR') : ?>
                <a class="thumbnail tile fa-links tile-blue" href="<?= $url ?>">                                                
                    <h1>Editar</h1>
                    <i class="fa fa-3x fa-pencil"></i>
                </a>  
                <a class="thumbnail tile fa-links tile-blue tile-auto" onclick="$('#eventId').val(<?= $event->getId() ?>)" data-toggle="modal" data-target="#mensagem">                                                
                    <h1>Enviar mensagem</h1>
                    <i class="fa fa-3x fa-comment"></i>
                </a> 
            <?php endif; ?>
        </div>
    </div>    
</div>
<div class="modal fade" id="gerar-cert" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Gerar certificados</h4>
            </div>
            <form role="form" onsubmit="gerarCertificado()">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="textLivro">Livro para registro:</label>                            
                                <input type="text" required="required" name="Livro" id="textLivro" class="form-control">
                            </div>             
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="textFolha">Última folha utilizada:</label>                            
                                <input type="number" required="required" name="Folha" id="textFolha" class="form-control">
                            </div>             
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="textRegistro">Último registro utilizado:</label>                            
                                <input type="number" required="required" name="Registro" id="textRegistro" class="form-control">
                            </div>             
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="selectCertificado">Tipo de certificado:</label>                            
                                <select name="Certificado" id="selectCertificado" class="form-control">
                                    <option>Participante</option>
                                    <option>Ministrante</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success">Gerar</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="mensagem" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="tr                                        ue">&times;</span></button>
                <h4 cla                                    ss="modal-title">Enviar mensagem para                                        inscritos</h4>
            </div>
            <div class="modal-body">
                <form id="FrmMensagem">
                    <textarea id="pMensagem" name=                                                                "mensagem" class="form-control"></textarea>
                    <input                                                                type="hidden" name="eventId" id="eventId">
                    <input type="hidden" name="async" value="true">
                </form>
                <a href="<?= $_BaseURL ?>event/loadEmails/?async&eventId=<?= $event->getId() ?>" target="_blank">Carregar lista de e-mails</a>
            </div>
            <div class="modal-footer">
                <button type                                                        ="button" class="btn btn-primary" oncli                                                    ck="enviarMensagem()">Enviar</butt                                                on>
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

    function gerarCertificado() {
        MyCookieJS.showWaitMessage('Gerando certificados (isso pode demorar muitos minutos)');
        theUrl = ($('#selectCertificado').val() == 'Participante') ? 
            '<?= $urlCert ?>?async' : '<?= $urlCertSpk ?>?async';
        $.ajax({
            type: 'POST',
            url: theUrl,
            data: $('#FrmCert').serialize(),
            success: function (msg) {
                if (msg === '') {
                    MyCookieJS.alert('Certificados gerados com sucesso!', function () {
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