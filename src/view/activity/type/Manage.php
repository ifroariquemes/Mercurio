<?php global $_MyCookie; ?>
<div class="modal-header">    
    <h4 class="modal-title">Type</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-lg-12">                
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th><?php _e('Name', 'activity') ?></th>                    
                        <th></th>
                    </tr>
                </thead>
                <tbody id="lstTypes">
                    <?php
                    if (!empty($data)) {
                        foreach ($data as $type) {
                            $_MyCookie->LoadView('activity/type', 'Manage.table', $type);
                        }
                    }
                    ?>
                </tbody>            
            </table>      
        </div>
    </div>
</div>
<div class="modal-footer">                
    <button type="button" class="btn btn-default" onclick="MyCookieJS.gotoPopup('mdActivityEdit')"><i class="fa fa-times"></i> <?php _e('Close', 'activity') ?></button>
    <button type="button" class="btn btn-primary" onclick="MyCookieJS.showDynamicPopup('mdTypeEdit', 'activity/type/add')"><i class="fa fa-plus-circle"></i> <?php _e('Add type', 'activity') ?></button>
</div> 