<?php global $_MyCookie; ?>
<div class="modal-header">    
    <h4 class="modal-title">Participants</h4>
</div>
<div class="modal-body">
    <div class="row">    
        <div class="col-lg-12 text-right">        
            <form id="FrmSearchAccreditation" class="form-inline" onsubmit="evt.searchParticipant(event)">            
                <div class="form-group">   
                    <a href="#" class="btn btn-sm btn-warning" id="searchCleanP" style="display: none" onclick="evt.clearParticipant(event)"> <i class="fa fa-eraser"></i> <?php _e('Stop searching', 'event') ?></a>
                    <input type="text" name="name" id="textNameParticipant" class="form-control" value="" placeholder="<?php _e('Quick search', 'event') ?>...">
                    <input type="hidden" name="id" value="<?php echo $data->getId() ?>">
                </div>                        
                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i> <?php _e('Search', 'event') ?></button>
            </form>        
        </div>
    </div>
    <div id="lstSearchParticipant" class="row" style="display: none">
        <div class="col-lg-12">        
            <div class="row">
                <div class="col-lg-4">
                    <h4><?php _e('Results searching for', 'event') ?>: <span id="searchTermParticipant"></span></h4>
                </div>
                <div class="col-lg-2 text-right">

                </div>
            </div>
            <div id="lstSearchDataParticipant"></div>
        </div>
    </div>
    <div id="lstDataParticipant" class="row">
        <div class="col-lg-12">  
            <?php $_MyCookie->LoadView('event', 'Participants.table', $data); ?>
            <div class="clear"></div>
        </div>
    </div>
</div>
<div class="modal-footer">                
    <button type="button" class="btn btn-default" onclick="MyCookieJS.closeAllPopups()"><i class="fa fa-times"></i> <?php _e('Close', 'activity') ?></button>    
</div>    