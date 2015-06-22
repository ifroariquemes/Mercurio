<?php global $_MyCookie; ?>
<?php $_MyCookie->LoadView('event/accreditation', 'participants.header', $data['event']) ?>
<h2 data-i18n="event:accreditation.label.registred_participants"></h2>
<div class="row">    
    <div class="col-md-12 text-right">                
        <form id="FrmSearch" class="form-inline">                        
            <input type="search" name="q" required="required" id="textName" class="form-control" value="" data-i18n="[placeholder]mycookie:message.search_pla">                            
            <input type="hidden" id="eventId" value="<?= $data['event']->getId() ?>">
            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> <span data-i18n="mycookie:button.search"></span></button>
        </form>        
    </div>
    <?php if (isset($data['searchTerm'])) : ?>
        <div class="col-md-12">        
            <h4><span data-i18n="mycookie:message.search_result"></span> <b><?= $data['searchTerm'] ?></b></h4>
            <button onclick="MyCookieJS.goto('administrator/event/accreditation/participants/<?= $data['event']->getId() ?>')" class="btn btn-danger"><i class="fa fa-times-circle-o"></i> <span data-i18n="mycookie:button.stop_searching"></span></button>
        </div>
    <?php endif; ?>
</div>
<div id="lstDataParticipant" class="row">
    <div class="col-lg-12">  
        <?php $_MyCookie->LoadView('event/accreditation', 'participants.table', $data); ?>
        <div class="clear"></div>
    </div>
    <div class="col-md-12 text-center">
        <?php $_MyCookie->loadView('user', 'pagination', $data) ?>
    </div>
</div>