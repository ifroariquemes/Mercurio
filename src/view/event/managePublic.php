<?php global $_MyCookie; ?>
<?php global $_User; ?>
<div id="lstData" class="row">    
    <div class="col-md-12">        
        <?php $_MyCookie->LoadView('event', 'managePublic.table', $data) ?>
        <div class="clear"></div>
    </div>
</div>