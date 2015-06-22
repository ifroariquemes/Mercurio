<?php global $_MyCookie; ?>
<div class="modal-header">    
    <h4 class="modal-title" data-i18n="event:activity.type.label.type"></h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">                
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th data-i18n="event:activity.type.label.name"></th>                    
                        <th></th>
                    </tr>
                </thead>
                <tbody id="lstTypes">
                    <?php
                    if (!empty($data)) {
                        foreach ($data as $type) {
                            $_MyCookie->LoadView('event/activity/type', 'manage.table', $type);
                        }
                    }
                    ?>
                </tbody>            
            </table>      
        </div>
    </div>
</div>
<div class="modal-footer">                
    <button type="button" class="btn btn-default" onclick="activity_type.close()"><i class="fa fa-times"></i> <span data-i18n="mycookie:button.close"></span></button>
    <button type="button" class="btn btn-primary" onclick="activity_type.add()"><i class="fa fa-plus-circle"></i> <span data-i18n="event:activity.type.button.add_type"></span></button>
</div> 