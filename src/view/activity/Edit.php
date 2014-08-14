<?php
global $_MyCookie;
$activity = $data['activity'];
?>
<div class="modal-header">    
    <h4 class="modal-title">Activity</h4>
</div>
<div class="modal-body">
    <form id="FrmActivityEdit" role="form" onsubmit="activity.submit(event)">
        <fieldset>
            <div class="form-group">
                <label for="textName"><?php _e('Name', 'activity') ?>:</label>
                <input type="text" name="Name" id="textName" class="form-control" value="<?php echo $activity->getName() ?>" required="required">
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group" id="typeSelectView">
                        <?php controller\activity\type\TypeController::select($activity->getType()->getId()) ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="textDuration"><?php _e('Duration', 'activity') ?>:</label>
                        <input type="number" name="Duration" id="textDuration" class="form-control" value="<?php echo $activity->getDuration() ?>" required="required">
                    </div>                                
                </div>
            </div>
            <div class="form-group">
                <label for="textDescription"><?php _e('Description', 'activity') ?></label>
                <textarea class="form-control" name="Description" id="textDescription"><?php echo $activity->getDescription() ?></textarea>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="checkCertificate"><?php _e('Has Certificate?', 'activity') ?></label>
                        <input type="checkbox" name="Certificate" id="checkCertificate" value="true"
                               <?php if ($activity->getHasCertificate()) : ?>checked="checked"<?php endif; ?>>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="checkSubmissions"><?php _e('Has Submissions?', 'activity') ?></label>
                        <input type="checkbox" name="Submissions" id="checkSubmissions" value="true"
                               <?php if ($activity->getHasSubmissions()) : ?>checked="checked"<?php endif; ?>>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="textVacancies"><?php _e('Vacancies', 'activity') ?>:</label>
                        <input type="number" name="Vacancies" id="textVacancies" class="form-control" value="<?php echo $activity->getVacancies() ?>">
                    </div>                                
                </div>
            </div>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php _e('Speakers', 'activity') ?></h3>
                </div>
                <div class="panel-body">                                
                    <table class="table table-striped table-condensed">
                        <thead>
                            <tr>
                                <th><?php _e('Name', 'activity') ?></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="lstSpeakers">
                            <?php
                            if (!empty($activity->getSpeakers())) {
                                foreach ($activity->getSpeakers() as $speaker) {
                                    $_MyCookie->LoadView('activity', 'Speaker.line', $speaker);
                                }
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td><input type="text" name="spkName" id="spkName" value="" class="form-control"></td>
                                <td class="col-lg-1"><button type="button" class="btn btn-success" onclick="activity.addSpeaker()"><i class="fa fa-plus"></i></button></td>
                            </tr>
                        </tfoot>
                    </table>                                
                </div>
            </div>
        </fieldset>
        <input type="hidden" name="id" id="activityEditId" value="<?php echo $activity->getId() ?>">
        <input type="hidden" name="onSession" id="activityEditSession" value="<?php echo $data['onSession'] ?>">
        <input type="hidden" name="iAct" id="activityEditAct" value="<?php echo $data['iAct'] ?>">
        <input type="submit" style="position: absolute; display: none">
    </form>
</div>
<div class="modal-footer">                
    <button type="button" class="btn btn-danger" onclick="MyCookieJS.closeAllPopups()"><i class="fa fa-times"></i> <?php _e('Cancel', 'activity') ?></button>
    <button type="button" class="btn btn-primary" onclick="$('#FrmActivityEdit input[type=submit]').click()"><i class="fa fa-save"></i> <?php _e('Save', 'activity') ?></button>
</div>        