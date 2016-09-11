<?php global $_MyCookie; ?>
<?php global $_User; ?>
<div id="lstData" class="row">    
    <div class="col-md-12">        
        <?php $_MyCookie->LoadView('event', 'managePublic.table', $data) ?>
        <div class="clear"></div>
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