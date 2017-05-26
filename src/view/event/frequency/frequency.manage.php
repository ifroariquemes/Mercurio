<?php
global $_MyCookie;
global $_User;
$notConfirmed = $data->getParticipantsNotConfirmed()->toArray();
?>
<?php $_MyCookie->LoadView('event/accreditation', 'participants.header', $data->getEvent()) ?>
<div class="panel panel-info">
    <div class="panel-heading">
        <h4 data-i18n="event:frequency.label.activity_info"></h4>
    </div>
    <div class="panel-body">
        <div class="col-md-12">
            <label><span data-i18n="event:activity.label.name"></span>:</label>
            <?= $data->getName(); ?>
        </div>                
        <div class="col-md-3">
            <label><span data-i18n="event:accreditation.label.registred"></span>:</label>
            <?= $data->getParticipants()->count() ?>
        </div>
        <div class="col-md-3">
            <label><span data-i18n="event:accreditation.label.confirmed"></span>:</label>
            <?= $data->getConfirmed() ?>
        </div>        
    </div>
</div>
<?php if (count($notConfirmed)) : ?>
    <div class="panel panel-info">
        <div class="panel-heading">
            <h4>Inscritos não confirmados 
                <?php if ($_User->getAccountType()->getFlag() === 'ADMINISTRATOR'): ?>
                    <a class="btn btn-danger pull-right" href="#" onclick="removerTodos(<?= $data->getId() ?>)">Remover todos</a>
                <?php endif; ?>
            </h4>
        </div>
        <div class="panel-body">
            <?php for ($i = 0, $max = count($notConfirmed); $i < $max; $i = $i + 3) : ?>
                <div class="row">
                    <div class="col-xs-4">
                        <?php if ($_User->getAccountType()->getFlag() === 'ADMINISTRATOR'): ?>
                            <div class="col-xs-2"><a class="btn-xs" href="#" onclick="removerParticipante(<?= $data->getId() ?>, <?= $notConfirmed[$i]->getId() ?>)">Remover</a></div>
                        <?php endif; ?>
                        <div class="col-xs-10"><?= $notConfirmed[$i]->getName() ?></div>
                    </div>
                    <?php if (array_key_exists($i + 1, $notConfirmed)) : ?>
                        <div class="col-xs-4">
                            <?php if ($_User->getAccountType()->getFlag() === 'ADMINISTRATOR'): ?>
                                <div class="col-xs-2"><a class="btn-xs" href="#" onclick="removerParticipante(<?= $data->getId() ?>, <?= $notConfirmed[$i + 1]->getId() ?>)">Remover</a></div>
                            <?php endif; ?>
                            <div class="col-xs-10"><?= $notConfirmed[$i + 1]->getName() ?></div>
                        </div>
                    <?php endif; ?>
                    <?php if (array_key_exists($i + 2, $notConfirmed)) : ?>
                        <div class="col-xs-4">
                            <?php if ($_User->getAccountType()->getFlag() === 'ADMINISTRATOR'): ?>
                                <div class="col-xs-2"><a class="btn-xs" href="#" onclick="removerParticipante(<?= $data->getId() ?>, <?= $notConfirmed[$i + 2]->getId() ?>)">Remover</a></div>
                            <?php endif; ?>
                            <div class="col-xs-10"><?= $notConfirmed[$i + 2]->getName() ?></div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endfor; ?>
        </div>
    </div>
<?php endif; ?>
<div id="lstData" class="row">
    <div class="col-lg-12">  
        <?php $_MyCookie->loadView('event/frequency', 'frequency.table', $data); ?>
        <div class="clear"></div>
    </div>
</div>
<script>
    function presencaTodos(atividade) {
        MyCookieJS.confirm('Deseja realmente lançar presença para todos os particpantes?', function () {
            var msg = MyCookieJS.execute('event/frequency/presentAllParticipants', 'activity=' + atividade);
            if (msg !== '') {
                console.log(msg);
            }
            location.reload();
        });
    }
    function removerTodos(atividade) {
        MyCookieJS.confirm('Deseja realmente remover todos os participantes não confirmados dessa atividade?', function () {
            var msg = MyCookieJS.execute('event/frequency/removeAllParticipantsNotConfirmed', 'activity=' + atividade);
            if (msg !== '')
                console.log(msg);
            MyCookieJS.alert('Participantes desvinculados com sucesso!', function () {
                location.reload();
            });
        });
    }
    function removerParticipante(atividade, usuario) {
        MyCookieJS.confirm('Deseja realmente remover este participante desta atividade?', function () {
            var msg = MyCookieJS.execute('event/frequency/removeParticipant', 'activity=' + atividade + '&user=' + usuario);
            if (msg !== '')
                console.log(msg);
            MyCookieJS.alert('Participante desvinculado com sucesso!', function () {
                location.reload();
            });
        });
    }
</script>