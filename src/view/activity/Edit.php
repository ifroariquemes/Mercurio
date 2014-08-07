<div class="modal-header">    
    <h4 class="modal-title">Activity</h4>
</div>
<div class="modal-body">
    <form id="FrmActivityEdit" role="form" onsubmit="submitt(event)">
        <fieldset>
            <div class="form-group">
                <label for="textName"><?php _e('Name', 'activity') ?>:</label>
                <input type="text" name="Name" id="textName" class="form-control" value="" required="required">
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <?php controller\activity\type\TypeController::select() ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="textDuration"><?php _e('Duration', 'activity') ?>:</label>
                        <input type="number" name="Duration" id="textDuration" class="form-control" value="" required="required">
                    </div>                                
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="checkCertificate"><?php _e('Has Certificate?', 'activity') ?></label>
                        <input type="checkbox" name="Certificate" id="checkCertificate" value="true">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="checkSubmissons"><?php _e('Has Submissions?', 'activity') ?></label>
                        <input type="checkbox" name="Submissions" id="checkSubmissions" value="true">
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
                        <tbody id="lstSpeakers"></tbody>
                        <tfoot>
                            <tr>
                                <td><?php \controller\user\UserController::selectWithFlag('SPEAKER') ?></td>
                                <td class="col-lg-1"><button type="button" class="btn btn-success" onclick="addSpeaker()"><i class="fa fa-plus"></i></button></td>
                            </tr>
                        </tfoot>
                    </table>                                
                </div>
            </div>
        </fieldset>
        <input type="submit" style="position: absolute; display: none">
    </form>
</div>
<div class="modal-footer">                
    <button type="button" class="btn btn-danger" onclick="MyCookieJS.closeAllPopups()"><i class="fa fa-times"></i> <?php _e('Cancel', 'activity') ?></button>
    <button type="button" class="btn btn-primary" onclick="$('#FrmActivityEdit input[type=submit]').click()"><i class="fa fa-save"></i> <?php _e('Save', 'activity') ?></button>
</div>        
<script type="text/javascript">
    function submitt(e) {
        e.preventDefault();
        $('#lstActivities').prepend(MyCookieJS.execute('activity/createLine', $('#FrmActivityEdit').serialize()));
        MyCookieJS.closeAllPopups();
    }

    function addSpeaker() {
        if ($('#selectUser').val() !== '') {
            $('#lstSpeakers').prepend(MyCookieJS.execute('activity/createSpeakerLine', 'user=' + $('#selectUser').val()));
            $('#selectUser').select2("val", '');
        }
    }
</script>