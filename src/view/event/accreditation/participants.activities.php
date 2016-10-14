<?php
global $_User;
global $_MyCookie;
$event = $data['event'];
$eventDetail = $data['eventDetail'];
$dataAtual = null;
$act = 0;
$sessionBlocks = array();
?>
<?php $_MyCookie->loadView('event/accreditation', 'participants.header', $data['event']); ?>
<div class="panel panel-info">
    <div class="panel-heading">
        <h4 data-i18n="event:accreditation.label.credentials_confirmation"></h4>
    </div>
    <div class="panel-body">
        <h4><?= $data['participant']->getName() ?></h4>
    </div>
</div>
<div class="row-fluid">
    <h2>Atividades</h2>
    <form id="FrmRegister">
        <?php
        foreach ($eventDetail as $detail) : $act++;
            $general = array();
            ?>
            <h4><?= $detail['date'] ?></h4>
            <?php foreach ($detail['turnos'] as $turno) : $inserted = array(); ?>
                <?php if (count($turno['activities'])) : ?>
                    <table class="table table-condensed table-bordered small">
                        <thead>
                            <tr>
                                <th colspan="<?= count($turno['activities']) + 1 ?>">Turno: <?= $turno['turno'] ?></th>
                            </tr>
                        </thead>
                        <?php
                        for ($time = clone($turno['minTime']); $time <= $turno['maxTime']; $time->add(date_interval_create_from_date_string('30 minutes'))) :
                            ?>
                            <tr>
                                <td class="col-xs-1"><?= $time->format('H:i') ?></td>
                                <?php foreach ($turno['activities'] as $activity) : ?>
                                    <?php foreach ($activity->getSessions() as $session) : ?>
                                        <?php if ($session->getDate() === $detail['dateUs'] && $session->getStartTime() >= $turno['minTime'] && $session->getStartTime() <= $turno['maxTime']) : ?>
                                            <?php
                                            if (!in_array($session, $inserted) && $time >= $session->getStartTime() && $time <= $session->getEndTime()) :
                                                array_push($inserted, $session);
                                                $dif = date_diff($session->getEndTime(), $session->getStartTime());
                                                $blocos = ($dif->format('%h') + ($dif->format('%i') / 60)) * 2 + 1;
                                                $sessionBlocks[$session->getId()] = $blocos - 1;
                                                ?>
                                                <td class="cell_act act_<?= $activity->getId() ?>" rowspan="<?= $blocos ?>">
                                                    <div class="block_act">
                                                        <label id="act_<?= $activity->getId() ?>_label" for="act_<?= $activity->getId() ?>">
                                                            <?php if (!in_array($activity, $general)) : ?>
                                                                <?php if ($activity->hasVacancy() || $activity->getParticipants()->contains($data['participant'])) : ?>
                                                                    <input type="checkbox" class="check_act btn-lg" data-blocks="<?= $blocos ?>" data-act="<?= $activity->getId() ?>" data-date="<?= $detail['dateUs'] ?>"
                                                                           name="Activity[]" id="act_<?= $activity->getId() ?>" data-disable="<?= json_encode($activity->getDisable()) ?>"                                           
                                                                           <?php if ($activity->getParticipants()->contains($_User)) : ?>checked="checked"<?php endif; ?>
                                                                           value="<?= $activity->getId() ?>">
                                                                       <?php endif; ?>
                                                                   <?php endif; ?>
                                                            <?= $activity->getType()->getName() ?> - <?= $activity->getName() ?><br>
                                                            <?php if ($activity->remainingVacancies() !== 'Unlimited') : ?>
                                                                <span style="font-weight: normal">
                                                                    <?php if ($activity->hasVacancy()) : ?>
                                                                        <span data-i18n="event:message.remaining_vacancies"></span>: <?= $activity->remainingVacancies() ?>                                                   
                                                                    <?php else : ?>
                                                                        <span data-i18n="event:message.no_vacancy" class="text-danger"></span>                                                   
                                                                    <?php endif; ?>
                                                                </span>
                                                            <?php endif; ?>
                                                        </label>
                                                        <a href="#" class="hidden-lg" data-toggle="modal" data-target="#modalInfo" onclick="$('#atividade').html('<?= $activity->getName() ?>'); $('#descricaoAtividade').html($('#act_<?= $activity->getId() ?>_label').attr('data-original-title'))">+info</a>
                                                        <br>
                                                    </div>
                                                </td>
                                                <?php
                                                array_push($general, $activity);
                                            elseif (!isset($sessionBlocks[$session->getId()]) || $sessionBlocks[$session->getId()] -- <= 0) :
                                                ?>   
                                                <td class="text-center" style="background: #ddd">-</td>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                            </tr>
                        <?php endfor; ?>
                    </table>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endforeach; ?>                  
        <input type="hidden" id="eventId" name="id" value="<?= $data['event']->getId() ?>">                                                    
        <input type="hidden" name="participant" value="<?= $data['participant']->getId() ?>">
    </form>  
</div>

<nav id="admin-navbar" class="navbar navbar-default navbar-fixed-bottom" role="navigation">    
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="align-center">
        <a href="#" onclick="accreditation.confirm(event)" class="navbar-link" title="Confirm">
            <i class="fa fa-check-circle fa-4x"></i>
        </a>
    </div><!-- /.navbar-collapse -->
</nav>

<script type="text/javascript">
    require(['jquery'], function ($) {
        $(function () {
            evt.updateDisable();
            $('input[type="checkbox"]').change(function () {
                if ($(this).is(':checked')) {
                    evt.updateDisable();
                } else {
                    evt.actEnable($.parseJSON($(this).attr('data-disable')));
                    $('.' + $(this).attr('id')).css('background', 'inherit').css('color', 'inherit');
                }
            });
            $('.block_act').each(function () {
                var altura = $(this).parent().height();
                $(this).height(altura).css('line-height', altura + 'px');

            });

        });

    });
</script>
<style type="text/css">
    .tooltip-inner {
        text-align: justify;
        width: 300px !important;
        max-width: 800px !important;
    }
    .cell_act {
        position: relative;
    }
    .block_act label {
        vertical-align: middle;
        line-height: normal;
        display: inline-block;
        padding: 0 5px;
        cursor: pointer;
    }
</style>