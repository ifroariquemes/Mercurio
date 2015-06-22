<?php global $_MyCookie; ?>
<?php global $_MyCookieUser; ?>
<div class="row">    
    <div class="col-lg-12 text-right">        
        <form id="FrmSearch" class="form-inline" onsubmit="accreditation.searchEvent(event)">            
            <div class="form-group">   
                <a href="#" class="btn btn-sm btn-warning" id="searchClean" style="display: none" onclick="evt.clear(event)"> <i class="fa fa-eraser"></i> <?php _e('Stop searching', 'event') ?></a>
                <input type="text" name="name" id="textName" class="form-control" value="" placeholder="<?php _e('Quick search', 'event') ?>...">                            
            </div>                        
            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i> <?php _e('Search', 'event') ?></button>
        </form>        
    </div>
</div>
<div id="lstSearch" class="row" style="display: none">
    <div class="col-lg-12">        
        <div class="row">
            <div class="col-lg-4">
                <h4><?php _e('Results searching for', 'event') ?>: <span id="searchTerm"></span></h4>
            </div>
            <div class="col-lg-2 text-right">

            </div>
        </div>
        <div id="lstSearchData"></div>
    </div>
</div>
<div id="lstData" class="row">
    <div class="col-lg-12">        
        <?php
        if (!empty($data)) :
            $_MyCookie->LoadView('accreditation', 'Manage.table', $data);
        else :
            ?>
            <?php _e('There is no Event happening at this moment', 'accreditation') ?>.</a>
        <?php endif; ?>

        <div class="clear"></div>
    </div>
</div>    

<script type="text/javascript">
    require(['jquery'], function($) {
        $(function() {
            $('#textName').focus();
            $('.pagination li').click(function() {
                location.href = '#page-title';
            });
        });
    });
</script>