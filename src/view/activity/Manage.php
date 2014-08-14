<?php global $_MyCookie; ?>
<div class="row" style="display: none" id="scr-2">
    <div class="col-lg-12">
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
                                <th><?php _e('Name', 'activity') ?></th>
                                <th><?php _e('Type', 'activity') ?></th>
                                <th><?php _e('Duration', 'activity') ?>(h)</th>                        
                                <th><?php _e('Speakers', 'activity') ?></th>
                                <th><?php _e('Has Certificate?', 'activity') ?></th>
                                <th><?php _e('Has Submissions?', 'activity') ?></th>
                                <th><?php _e('Vacancies', 'activity') ?></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="lstActivities">
                            <?php
                            if (!empty($data->getActivities())) {
                                foreach ($data->getActivities() as $activity) {
                                    $_MyCookie->LoadView('activity', 'Manage.table', array('activity' => $activity, 'iAct' => $activity->getId()));
                                }
                            }
                            ?>
                        </tbody>            
                    </table>
                </form>
            </div>
        </div>                
        <p class="text-right"><button class="btn btn-primary" onclick="activity.add()"><i class="fa fa-plus-circle"></i> Add activity</button></p>        
    </div>
</div>