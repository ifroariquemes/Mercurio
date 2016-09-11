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
        <?php $_MyCookie->CSSBundle() ?>        
        <?php $_MyCookie->RequireJS() ?>
    </head>
    <body>      
        <header>

        </header>
        <div class="container">
            <div class="row">
                <div class="col-md-offset-3 col-md-6">
                    <img src="<?= $_BaseURL ?>src/assets/images/ifro.png" class="img-responsive">
                    <h2 class="text-center">Mercúrio</h2>
                    <h4 class="text-center">Sistema Gerenciador de Eventos</h4>
                </div>
            </div>
            <?php if (!empty($_User)) : ?>
                <div class="row">
                    <h4 class="text-center">
                        <a href="#" class="label label-info"><?= $_User->getName() ?></a> <a href="<?= $_BaseURL ?>user/logout/" class="label label-danger"><i class="glyphicon glyphicon-eject"></i> Sair</a>
                    </h4>
                </div>
            <?php endif; ?>
            <div class="row">
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