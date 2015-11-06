<?php global $_MyCookie; ?>
<div class="row">    
    <div class="col-md-12 text-right">        
        <form id="FrmSearch" class="form-inline" onsubmit="user.search(event)">            
            <input type="search" name="name" id="textName" class="form-control" value="" data-i18n="[placeholder]mycookie:message.search_pla">                            
            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i> <span data-i18n="mycookie:button.search"></span></button>
        </form>        
    </div>
    <?php if (isset($data['searchTerm'])) : ?>
        <div class="col-md-12">        
            <h4><span data-i18n="mycookie:message.search_result"></span> <b><?= $data['searchTerm'] ?></b></h4>
        </div>
    <?php endif; ?>
</div>
<div id="lstData" class="row">
    <div class="col-md-12">        
        <?php $_MyCookie->loadView('user', 'manage.table', $data['users']) ?>        
        <div class="clear"></div>
    </div>
    <div class="col-md-12 text-center">
        <?php $_MyCookie->loadView('user', 'pagination', $data) ?>
    </div>
</div>
<nav id="admin-navbar" class="navbar navbar-default navbar-fixed-bottom" role="navigation">    
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="align-center">
        <a href="<?= $_MyCookie->mountLink('administrator', 'user', 'add') ?>" class="navbar-link">
            <i class="fa fa-plus-circle fa-4x"></i>
        </a>
    </div><!-- /.navbar-collapse -->
</nav>
<script>
    require(['jquery'], function ($) {
        $(function () {
            $('#textName').focus();
        });
    });
</script>