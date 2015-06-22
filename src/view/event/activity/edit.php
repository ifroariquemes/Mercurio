<?php
global $_MyCookie;
$activity = $data['activity'];
?>
<div class="modal-header">    
    <h4 class="modal-title">Activity</h4>
</div>
<div class="modal-body">    
    <div class="row">            
        <div class="col-md-12">
            <form id="FrmActivityEdit" role="form" onsubmit="activity.submit(event)">
                <div class="form-group">
                    <label for="textName"><span data-i18n="event:activity.label.name"></span>:</label>
                    <input type="text" name="Name" id="textName" class="form-control" value="<?= $activity->getName() ?>" required="required">
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group" id="typeSelectView">
                            <?php \controller\event\activity\TypeController::select($activity->getType()->getId()) ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="textDuration"><span data-i18n="event:activity.label.duration"></span>:</label>
                            <input type="number" name="Duration" id="textDuration" class="form-control" value="<?= $activity->getDuration() ?>" required="required">
                        </div>                                
                    </div>
                </div>
                <div class="form-group">
                    <label for="textDescription"><span data-i18n="event:activity.label.description"></span>:</label>
                    <textarea class="form-control" name="Description" id="textDescription"><?= $activity->getDescription() ?></textarea>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="checkCertificate"><span data-i18n="event:activity.label.has_certificate"></span></label>
                            <input type="checkbox" name="Certificate" id="checkCertificate" value="true"
                                   <?php if ($activity->getHasCertificate()) : ?>checked="checked"<?php endif; ?>>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="checkSubmissions"><span data-i18n="event:activity.label.has_submissions"></span></label>
                            <input type="checkbox" name="Submissions" id="checkSubmissions" value="true"
                                   <?php if ($activity->getHasSubmissions()) : ?>checked="checked"<?php endif; ?>>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="textVacancies"><span data-i18n="event:activity.label.vacancies"></span>:</label>
                            <input type="number" name="Vacancies" id="textVacancies" class="form-control" value="<?= $activity->getVacancies() ?>">
                        </div>                                
                    </div>
                </div>
                </fieldset>
                <input type="hidden" name="id" id="activityEditId" value="<?= $activity->getId() ?>">
                <input type="hidden" name="onSession" id="activityEditSession" value="<?= $data['onSession'] ?>">
                <input type="hidden" name="iAct" id="activityEditAct" value="<?= $data['iAct'] ?>">
                <input type="submit" style="position: absolute; display: none">
            </form>
        </div>
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title" data-i18n="event:activity.label.speakers"></h3>
                </div>
                <div class="panel-body">     
                    <form id="FrmSpk" onsubmit="activity.addSpeaker(event)">
                        <table class="table table-striped table-condensed">
                            <thead>
                                <tr>
                                    <th data-i18n="event:activity.label.speakers_name"></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="lstSpeakers">
                                <?php
                                if (!empty($activity->getSpeakers())) {
                                    foreach ($activity->getSpeakers() as $speaker) {
                                        $_MyCookie->LoadView('event/activity', 'speaker.line', $speaker);
                                    }
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td><input required="required" type="text" name="spkName" id="spkName" value="" class="form-control"></td>
                                    <td class="col-md-1"><button type="submit" class="btn btn-success"><i class="fa fa-plus"></i></button></td>
                                </tr>
                            </tfoot>
                        </table>     
                    </form>
                </div>
            </div>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title" data-i18n="event:activity.label.sessions"></h3>
                </div>
                <div class="panel-body">        
                    <form id="FrmSes" onsubmit="activity.addSession(event)">
                        <table class="table table-striped table-condensed">
                            <thead>
                                <tr>
                                    <th data-i18n="event:activity.label.session_date"></th>
                                    <th data-i18n="event:activity.label.session_start"></th>
                                    <th data-i18n="event:activity.label.session_end"></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="lstSessions">
                                <?php
                                if (!empty($activity->getSessions())) {
                                    foreach ($activity->getSessions() as $session) {
                                        $_MyCookie->LoadView('event/activity', 'session.line', $session);
                                    }
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td><input type="date" name="sesDate" required="required" id="sesDate" value="" class="form-control"></td>
                                    <td><input type="time" name="sesStart" required="required" id="sesStart" value="" class="form-control"></td>
                                    <td><input type="time" name="sesEnd" required="required" id="sesEnd" value="" class="form-control"></td>                                    
                                    <td class="col-md-1"><button type="submit" class="btn btn-success"><i class="fa fa-plus"></i></button></td>
                                </tr>
                            </tfoot>
                        </table>                                
                    </form>
                </div>
            </div>
        </div> 
    </div>
</div>
<div class="modal-footer">                
    <button type="button" class="btn btn-danger" onclick="MyCookieJS.closeAllPopups()"><i class="fa fa-times"></i> <span data-i18n="mycookie:button.cancel"></span></button>
    <button type="button" class="btn btn-primary" onclick="$('#FrmActivityEdit input[type=submit]').click()"><i class="fa fa-save"></i> <span data-i18n="mycookie:button.save"></span></button>
</div>        
<script>
    MyCookieJS.maskUpper('#spkName');
</script>