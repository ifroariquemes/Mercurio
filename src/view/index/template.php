<?php
/* @var $_MyCookie \lib\MyCookie */
global $_MyCookie;
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
        <title>Mercúrio</title>                        
        <?php $_MyCookie->CSSBundle() ?>
        <?php $_MyCookie->RequireJS() ?>      
    </head>
    <body>                     
        <?php echo $view ?>                 
        <?php $_MyCookie->JSBundle() ?>                          
    </body>
</html>