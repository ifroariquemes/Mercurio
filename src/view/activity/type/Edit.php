<form id="FrmTypeEdit" onsubmit="submittype(event)">
    <div class="modal-header">    
        <h4 class="modal-title">Type</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-lg-12">                

                <div class="form-group">
                    <label for="textNameType"><?php _e('Name', 'activity') ?></label>
                    <input type="text" name="Name" id="textNameType" class="form-control" value="<?php echo $data->getName() ?>" required="required">                
                </div>
                <input type="hidden" name="id" value="<?php echo $data->getId() ?>">

            </div>
        </div>
    </div>
    <div class="modal-footer">                
        <button type="button" class="btn btn-danger" onclick="MyCookieJS.gotoPopup('mdTypeManage')"><i class="fa fa-times"></i> <?php _e('Cancel', 'activity') ?></button>
        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> <?php _e('Save', 'activity') ?></button>
    </div> 
</form>
<script type="text/javascript">
    function submittype(e) {
        e.preventDefault();
        MyCookieJS.execute('activity/type/save', $('#FrmTypeEdit').serialize(), false, function() {
            MyCookieJS.showDynamicPopup('mdTypeManage', 'activity/type/manage');
        });
    }
</script>