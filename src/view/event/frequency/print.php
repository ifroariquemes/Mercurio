<?php global $_MyCookie ?>
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
        <title data-i18n="admin:page.title">administrative panel</title>                    
        <?php $_MyCookie->CSSBundle() ?>
        <?php $_MyCookie->RequireJS() ?>      
    </head>
    <body>   
        <h1 class="text-center"><?= $data->getEvent()->getName() ?></h1>     
        <h3 class="text-center"><small><?= $data->getName() ?></small></h3>
        <table class="table table-bordered table-condensed">
            <thead>                
                <tr>
                    <th data-i18n="event:activity.label.name">Nome</th>
                    <th data-i18n="event:frequency.label.signature">Assinatura</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data->getParticipants() as $participant) : ?>
                    <?php if ($data->getEvent()->getConfirmed()->contains($participant)) : ?>
                        <tr>
                            <td class="col-xs-6"><?= $participant->getName() ?></td>
                            <td class="col-xs-6"></td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </body>
</html>