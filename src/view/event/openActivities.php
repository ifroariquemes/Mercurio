<?php
global $_MyCookie;
$event = $data['event'];
?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="pt-BR"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="pt-BR"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="pt-BR"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="pt-BR"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />        
        <meta name="viewport" content="width=device-width">
        <title>Controle de vagas</title>                    
        <?php $_MyCookie->CSSBundle() ?>
        <?php $_MyCookie->RequireJS() ?>      
        <style>
            body{overflow: hidden}
        </style>
    </head>
    <body>   
        <h1 class="text-center text-success" style="font-size: 250%"><?= $event->getName() ?></h1>     
        <h2 class="text-center"><b>Quadro de vagas</b></h2>
        <div class="container-fluid">
            <?php foreach ($event->getActivities() as $activity) : ?>
                <div class="row atividade">
                    <div class="col-md-12" style="background: #eee; padding-bottom: 40px">
                        <h3 class="text-center" style="font-size: <?= -7 * strlen($activity->getName()) + 940 ?>%"><?= $activity->getName() ?></h3>
                    </div>
                    <div class="col-md-12">
                        <p class="text-center">
                            <span style="font-size: 250%">Data: <?= $activity->getSessions()[0]->getDateStr() ?></span><br>
                            <span style="font-size: 1000%; position: relative; top: -50px">
                                <?php if (!$activity->hasVacancy()) : ?>
                                    <span class="text-danger" style="font-size: 80%">Vagas encerradas</span>
                                <?php elseif ($activity->remainingVacancies() === 'Unlimited') : ?>
                                    <span class="text-info" style="font-size: 80%">Aberto a todos</span>
                                <?php else: ?>
                                    <?= $activity->remainingVacancies() ?> vagas
                                <?php endif; ?>
                            </span>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php $_MyCookie->JSBundle() ?>
        <script>
            var atividade = 0;
            require(['jquery'], function ($) {
                $(function () {
                    for (var i = 0; i < $('.atividade').length; i++) {
                        setTimeout(function () {
                            $('.atividade').hide();
                            $('.atividade').eq(atividade).show();
                            atividade++;
                            if (atividade >= $('.atividade').length) {
                                setTimeout(function () {
                                    location.reload();
                                }, 10000);
                            }
                        }, i * 10000);
                    }
                });
            });
        </script>
    </body>
</html>