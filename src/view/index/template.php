<?php

use lib\MyCookie;

global $_MyCookie;
global $_BaseURL;
global $_Config;
global $_User;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Mercúrio - Sistema Gerenciador de Eventos</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php if (empty($_User)) : ?>
            <script type="text/javascript">
                localStorage.clear();
            </script>
        <?php endif; ?>
        <?php $_MyCookie->CSSBundle() ?>        
        <?php $_MyCookie->RequireJS() ?>
    </head>
    <body>      
        <header>

        </header>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-offset-4 col-md-4">
                    <img src="<?= $_BaseURL ?>src/assets/images/ifro-horizontal.png" class="img-responsive">
                    <h2 class="text-center">Mercúrio</h2>
                    <h4 class="text-center">Sistema Gerenciador de Eventos</h4>
                </div>
            </div>
            <?php if (!empty($_User)) : ?>
                <div class="row">
                    <h4 class="text-center">
                        <a href="<?= $_BaseURL ?>event/userCertificates/" class="label label-success"><i class="glyphicon glyphicon-certificate"></i> Meus certificados</a>
                        <a href="<?= $_BaseURL ?>user/edit/<?= $_User->getId() ?>/" class="label label-info"><i class="glyphicon glyphicon-user"></i> <?= $_User->getName() ?></a> 
                        <a href="<?= $_BaseURL ?>user/logout/" class="label label-danger"><i class="glyphicon glyphicon-eject"></i> Sair</a>
                    </h4>
                </div>
            <?php endif; ?>
            <div class="row-fluid">
                <?= $view ?>
            </div>
        </div>
        <?php $_MyCookie->JSBundle() ?>
        <script type="text/javascript">
            require(['jquery', 'i18next'], function ($) {
                $('#email').focus();
            });
        </script>
    </body>
</html>