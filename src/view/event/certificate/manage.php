<?php global $_MyCookie; ?>
<div class="row">
    <div class="col-md-12">        
        <h1 data-i18n="event:certificate.label.certificate_templates"></h1>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 data-i18n="event:label.organization"></h4>
            </div>
            <div class="panel-body">                                                                    
                <label for="textName"><span data-i18n="event:label.name"></span>:</label>                            
                <?= $data->getName() ?>                
            </div>
        </div>        
    </div>    
</div>
<div class="row">
    <div class="col-md-12">
        <?php $_MyCookie->loadView('event/certificate', 'manage.table', $data->getCertificateTemplates()) ?>        
        <div class="clear"></div>        
    </div>    
</div>

<nav id="admin-navbar" class="navbar navbar-default navbar-fixed-bottom" role="navigation">    
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="align-center">
        <a href="<?= $_MyCookie->mountLink('administrator', 'event', 'certificate', 'add', $data->getId()) ?>" class="navbar-link">
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