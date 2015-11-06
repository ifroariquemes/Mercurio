<?php global $_MyCookie; ?>
<?php global $_User; ?>
<div class="row">    
    <div class="col-md-12 text-right">                
        <form id="FrmSearch" class="form-inline">            
            <?php if (controller\user\UserController::isAdministratorLoggedIn()) : ?>
                <a class="btn btn-default" href="<?= $_MyCookie->mountLink('administrator', 'event', 'organization', 'manage') ?>">
                    <i class="fa fa-gear"></i> <span data-i18n="event:label.organizations"></span>
                </a>
            <?php endif; ?>
            <input type="search" name="q" required="required" class="form-control" value="" data-i18n="[placeholder]mycookie:message.search_pla">                            
            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> <span data-i18n="mycookie:button.search"></span></button>
        </form>        
    </div>
    <?php if (isset($data['searchTerm'])) : ?>
        <div class="col-md-12">        
            <h4><span data-i18n="mycookie:message.search_result"></span> <b><?= $data['searchTerm'] ?></b></h4>
            <button onclick="MyCookieJS.goto('administrator/event')" class="btn btn-danger"><i class="fa fa-times-circle-o"></i> <span data-i18n="mycookie:button.stop_searching"></span></button>
        </div>
    <?php endif; ?>
</div>
<div id="lstData" class="row">    
    <div class="col-md-12">        
        <?php $_MyCookie->LoadView('event', 'manage.table', $data) ?>
        <div class="clear"></div>
    </div>
    <div class="col-md-12 text-center">
        <?php $_MyCookie->loadView('user', 'pagination', $data) ?>
    </div>
</div>

<?php if ($_User->getAccountType()->getFlag() == 'ADMINISTRATOR') : ?>
    <nav id="admin-navbar" class="navbar navbar-default navbar-fixed-bottom" role="navigation">    
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="align-center">
            <a href="<?= $_MyCookie->mountLink('administrator', 'event', 'add') ?>" class="navbar-link">
                <i class="fa fa-plus-circle fa-4x"></i>
            </a>
        </div><!-- /.navbar-collapse -->
    </nav>
<?php endif; ?>

<script>
    require(['jquery'], function ($) {
        $(function () {
            $('#textName').focus();
        });
    });
</script>