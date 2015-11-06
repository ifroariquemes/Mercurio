<header class="row">     
    <div class="col-md-12"><h2 data-i18n="event:certificate.label.<?= $data['action'] ?>"></h2></div>
</header>    
<form id="FrmCertEdit" onsubmit="certificate.submit()">
    <div class="row panel panel-default">        
        <div class="col-md-9">
            <h3 data-i18n="event:certificate.label.participant_template"></h3>        
            <div class="form-group">   
                <label for="pFront"><span data-i18n="event:certificate.label.front"></span>:</label>
                <textarea id="pFront" name="pFront" class="form-control"></textarea>
            </div>                                     
            <div class="form-group">   
                <label for="pBack"><span data-i18n="event:certificate.label.back"></span>:</label>
                <textarea id="pBack" name="pBack" class="form-control"></textarea>
            </div>                                                                                                                
            <?php if ($data['certTemplate']->getId()) : ?>
                <div class="text-right">            
                    <a href="#" onclick="evt.delete(event)" data-i18n="event:button.delete"></a>                
                </div>
            <?php endif; ?>
        </div>
        <div class="col-md-3">
            <h3 data-i18n="event:certificate.label.participant_markups"></h3>
            <dl>
                <dt>{{participant}}</dt>
                <dd data-i18n="event:certificate.label.participant_name"></dd>
                <dt>{{event}}</dt>
                <dd data-i18n="event:certificate.label.event_name"></dd>
                <dt>{{start_date}}</dt>
                <dd data-i18n="event:certificate.label.event_sd"></dd>
                <dt>{{end_date}}</dt>
                <dd data-i18n="event:certificate.label.event_ed"></dd>
                <dt>{{organization}}</dt>
                <dd data-i18n="event:certificate.label.organization_name"></dd>
                <dt>{{activity}}</dt>
                <dd data-i18n="event:certificate.label.activity_name"></dd>
                <dt>{{activities}}</dt>
                <dd data-i18n="event:certificate.label.activity_list"></dd>
                <dt>{{hours}}</dt>
                <dd data-i18n="event:certificate.label.hours"></dd>            
            </dl>
            <h3 data-i18n="event:certificate.label.general_markups"></h3>
            <dl>
                <dt>{{book}}</dt>
                <dd data-i18n="event:certificate.label.book"></dd>
                <dt>{{page}}</dt>
                <dd data-i18n="event:certificate.label.page"></dd>
                <dt>{{registration}}</dt>
                <dd data-i18n="event:certificate.label.registration"></dd>
                <dt>{{date}}</dt>
                <dd data-i18n="event:certificate.label.date"></dd>
            </dl>
        </div>        
    </div>
    <div class="row panel panel-default">        
        <div class="col-md-9">
            <h2 data-i18n="event:certificate.label.speaker_template"></h2>        
            <div class="form-group">   
                <label for="sFront"><span data-i18n="event:certificate.label.front"></span>:</label>
                <textarea id="sFront" name="sFront" class="form-control"></textarea>
            </div>                                     
            <div class="form-group">   
                <label for="sBack"><span data-i18n="event:certificate.label.back"></span>:</label>
                <textarea id="sBack" name="sBack" class="form-control"></textarea>
            </div>                                                                                                          
            <?php if ($data['certTemplate']->getId()) : ?>
                <div class="text-right">            
                    <a href="#" onclick="evt.delete(event)" data-i18n="event:button.delete"></a>                
                </div>
            <?php endif; ?>
        </div>
        <div class="col-md-3">
            <h3 data-i18n="event:certificate.label.speaker_markups">Speaker markups</h3>
            <dl>
                <dt>{{speaker}}</dt>
                <dd data-i18n="event:certificate.label.speaker_name"></dd>
                <dt>{{event}}</dt>
                <dd data-i18n="event:certificate.label.event_name"></dd>
                <dt>{{start_date}}</dt>
                <dd data-i18n="event:certificate.label.event_sd"></dd>
                <dt>{{end_date}}</dt>
                <dd data-i18n="event:certificate.label.event_ed"></dd>
                <dt>{{organization}}</dt>
                <dd data-i18n="event:certificate.label.organization_name"></dd>
                <dt>{{activity}}</dt>
                <dd data-i18n="event:certificate.label.speaker_activity"></dd>
                <dt>{{hours}}</dt>
                <dd data-i18n="event:certificate.label.speaker_hours"></dd>            
            </dl>
            <h3 data-i18n="event:certificate.label.general_markups"></h3>
            <dl>
                <dt>{{book}}</dt>
                <dd data-i18n="event:certificate.label.book"></dd>
                <dt>{{page}}</dt>
                <dd data-i18n="event:certificate.label.page"></dd>
                <dt>{{registration}}</dt>
                <dd data-i18n="event:certificate.label.registration"></dd>
                <dt>{{date}}</dt>
                <dd data-i18n="event:certificate.label.date"></dd>
            </dl>
        </div>        
    </div>
    <div class="row">
        <input type="hidden" name="id" value="<?= $data['certTemplate']->getId() ?>">            
        <div class="text-right">            
            <button class="btn btn-success" type="submit"><i class="fa fa-save"></i> <span data-i18n="mycookie:button.save">Save</span></button>                        
        </div>
    </div>
</form>
<script>
    require(['jquery', 'summernote'], function ($) {
        $('#sFront, #sBack, #pFront, #pBack').summernote({height: 400});
    });
</script>