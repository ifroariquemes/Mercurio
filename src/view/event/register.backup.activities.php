<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4 data-i18n="event:label.activities"></h4>
            </div>
            <div class="panel-body">   
                <div class="alert alert-warning alert-dismissible row" role="alert">
                    <div class="col-xs-1 hidden-xs"><i class="glyphicon glyphicon-info-sign btn-lg"></i></div>
                    <div class="col-xs-2 hidden-sm hidden-md hidden-lg"><i class="glyphicon glyphicon-info-sign btn-lg"></i></div>

                    <div class="col-xs-10">A <b>MARCAÇÃO</b> de algumas atividades ficará <b>DESABILITADA</b> quando uma ou mais sessões (data e hora) acontecerem ao mesmo tempo que em uma das atividades que você já selecionou.</div>
                </div>
                <form id="FrmRegister">
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <?php
                        foreach ($eventDetail as $detail) : $act++;
                            $general = array();
                            ?>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading<?= $act ?>">
                                    <h4 class="panel-title">
                                        <?= $detail['date'] ?>
                                    </h4>
                                </div>
                                <div class="panel-body">
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
                                                                        //$activity->getSessions()->removeElement($session);
                                                                        $dif = date_diff($session->getEndTime(), $session->getStartTime());
                                                                        $blocos = ($dif->format('%h') + ($dif->format('%i') / 60)) * 2 + 1;
                                                                        $sessionBlocks[$session->getId()] = $blocos - 1;
                                                                        ?>
                                                                        <td class="cell_act act_<?= $activity->getId() ?>" rowspan="<?= $blocos ?>">
                                                                            <div class="block_act">
                                                                                <label id="act_<?= $activity->getId() ?>_label" for="act_<?= $activity->getId() ?>">
                                                                                    <?php if (!in_array($activity, $general)) : ?>
                                                                                        <input type="checkbox" class="check_act btn-lg" data-blocks="<?= $blocos ?>" data-act="<?= $activity->getId() ?>" data-date="<?= $detail['dateUs'] ?>"
                                                                                               name="Activity[]" id="act_<?= $activity->getId() ?>" data-disable="<?= json_encode($activity->getDisable()) ?>"                                           
                                                                                               <?php if ($activity->getParticipants()->contains($_User)) : ?>checked="checked"<?php endif; ?>
                                                                                               value="<?= $activity->getId() ?>">
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
                                </div>
                            </div>
                        <?php endforeach; ?>  
                    </div>
                    <input type="hidden" name="id" value="<?= $event->getId() ?>">                                                    
                </form>                                
            </div>
        </div>        
    </div>    
</div>