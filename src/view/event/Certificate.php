<?php
$event = $data[3];
$user = $data[0];
$reg = $data[1];
$pag = $data[2];
$date = $data[4];
$livro = $data[5];
$horas = 0;
foreach ($user->getActivities() as $activity) {
    if ($event->getActivities()->contains($activity) && $activity->getPresent()->contains($user) && $activity->getHasCertificate()) {
        $horas += $activity->getDuration();
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <style>
            .table {
                width: 100%;
                max-width: 100%;
            }
            .table th,
            .table td {
                display: table-cell;
            }
            .text-center{text-align: center}
            .text-justify{text-align: justify}
        </style>
        <style>
            * { font-family: Arial, Verdana, Tahoma, "Heveltica" }
            .cert {                
                page-break-before: always; 
                page-break-inside: avoid;
            }
            @media print{@page {size: landscape}}
        </style>
    </head>
    <body>
        <div class="cert2">
            <table width="100%">
                <tr>
                    <td width="10%"><?= $_MyCookie->image('src/assets/images/brasao.jpg', '', '', '', 'style="height: 150px"') ?></td>
                    <td><h1 class="text-center" style="font-size: 18pt">Ministério da Educação</h1>
                        <h4 class="text-center" style="font-size: 12pt">
                            Secretaria de Educação Profissional e Tecnológica<br>
                            Instituto Federal de Educação, Ciência e Tecnologia de Rondônia/Campus Ariquemes<br>
                            Departamento de Extensão</h4></td>
                    <td width="10%"><p class="text-right"><?= $_MyCookie->image('src/assets/images/ifro.jpg', '', '', '', 'style="height: 150px"') ?></p></td>
                </tr>
                <tr>
                    <td colspan="3">
                        <h1 class="text-center" style="font-size: 65pt">Certificado</h1>                    
                        <p class="text-center" style="font-size: 14pt">Certificamos que<br><span style="font-size:22pt"><b><?= ucwords($user->getName()) ?></b></span><br>participou do  
                            <i><?= $event->getName() ?></i>, com um total de <b><?= $horas ?> horas</b>, 
                            realizado de <?= $event->getFullDate() ?>, 
                            no <?= $event->getOrganization()->getName() ?>.</p>
                        <h3 class="text-center" style="font-size:16pt"><i>Ariquemes, <?= \lib\util\Date::DataLonga($event->getEndDate(), false) ?>.</i></h3>
                    </td>
                </tr>
            </table>
            <table width="100%" style="margin-top: 55px">            
                <tr>
                    <td width="33.33%" style="position: relative">
                        <?= $_MyCookie->image('src/assets/images/osvino.png', '', '', '', 'style="position: absolute; left: 30px; top: -85px; height: 230px"') ?>
                        <p class="text-center" style="font-size: 12pt; border-top: 2px solid black">
                            <b>Osvino Schmidt</b><br>
                            Diretor Geral<br>
                            IFRO - Campus Ariquemes
                        </p>
                    </td>
                    <td width="33.33%"><p class="text-center" style="font-size: 12pt; border-top: 2px solid black">Titular do Certificado</p></td>
                    <td width="33.33%" style="position: relative">
                        <?= $_MyCookie->image('src/assets/images/leonardo.png', '', '', '', 'style="position: absolute; left: 80px; top: -75px; height: 100px"') ?>
                        <p class="text-center" style="font-size: 12pt; border-top: 2px solid black">
                            <b>Leonardo Pacheco Pires</b><br>
                            Departamento de Extensão<br>
                            IFRO - Campus Ariquemes
                        </p>
                    </td>
                </tr>
            </table>                        
        </div>
        <div class="cert">
            <table width="100%">
                <tr>
                    <td width="50%">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Atividades (CH)</th>
                                </tr>                     
                            </thead>
                            <tbody>
                                <?php foreach ($user->getActivities() as $activity) : ?>
                                    <?php if ($event->getActivities()->contains($activity) && $activity->getPresent()->contains($user) && $activity->getHasCertificate()) : ?>
                                        <tr>
                                            <td><?= $activity->getName() ?> (<?= $activity->getDuration() ?>h)</td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>                        
                            </tbody>
                        </table>
                    </td>
                    <td width="10%"></td>
                    <td>
                        <p class="text-center"><b>REGISTRO DO CERTIFICADO</b></p>
                        <p class="text-justify">Certificado expedido pelo Departamento de Extensão do Instituto Federal de Educação, 
                            Ciência e Tecnologia de Rondônia - Campus Ariquemes, 
                            registro sob nº <?= $reg ?>, do Livro <?= str_pad($livro, 3, '0', STR_PAD_LEFT) ?>, página <?= $pag ?>, em <?= $date ?>.</p>
                    </td>
                </tr>
            </table>        
        </div>
    </body>
</html>