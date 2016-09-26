<?php global $_MyCookie; ?>
<div class="row" style="display: none" id="scr-2">
    <div class="col-md-12">
        <h3 id="lbEventName">{Event name}</h3>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Activities</h3>
            </div>
            <div class="panel-body">
                <form name="FrmActivities" id="FrmActivities">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th data-i18n="event:activity.label.name"></th>
                                <th data-i18n="event:activity.type.label.type"></th>
                                <th data-i18n="event:activity.label.duration"></th>
                                <th data-i18n="event:activity.label.speakers"></th>
                                <th data-i18n="event:activity.label.has_certificate"></th>
                                <th data-i18n="event:activity.label.has_submissions"></th>
                                <th data-i18n="event:activity.label.vacancies"></th>
                                <th data-i18n="event:activity.label.subscriptions"></th>                                                                
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="lstActivities">
                            <?php
                            if (!empty($data->getActivities())) {
                                foreach ($data->getActivities() as $activity) {
                                    $_MyCookie->LoadView('event/activity', 'manage.table', array('activity' => $activity, 'iAct' => $activity->getId()));
                                }
                            }
                            ?>
                        </tbody>            
                    </table>
                </form>
            </div>
        </div>                
        <p class="text-right"><button class="btn btn-primary" onclick="activity.add()"><i class="fa fa-plus-circle"></i> <span data-i18n="event:activity.button.add_activity">Add activity</span></button></p>        
    </div>
</div>