<?php
$event = $data[3];
$user = $data[0];
$reg = $data[1];
$pag = $data[2];
$date = $data[4];
$horas = 0;
foreach ($user->getActivities() as $activity) {
    if ($activity->getPresent()->contains($user) && $activity->getHasCertificate()) {
        $horas += $activity->getDuration();
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <style>
            table {
                border-spacing: 0;
                border-collapse: collapse;
            }
            td,
            th {
                padding: 0;
            }
            .table td,
            .table th {
                background-color: #fff !important;
            }  
            .table {
                border-collapse: collapse !important;
            }
            .table-bordered th,
            .table-bordered td {
                border: 1px solid #ddd !important;
            }
            .table {
                width: 100%;
                max-width: 100%;
                margin-bottom: 20px;
            }
            .table > thead > tr > th,
            .table > tbody > tr > th,
            .table > tfoot > tr > th,
            .table > thead > tr > td,
            .table > tbody > tr > td,
            .table > tfoot > tr > td {
                padding: 8px;
                line-height: 1.42857143;
                vertical-align: top;
                border-top: 1px solid #ddd;
            }
            .table > thead > tr > th {
                vertical-align: bottom;
                border-bottom: 2px solid #ddd;
            }
            .table > caption + thead > tr:first-child > th,
            .table > colgroup + thead > tr:first-child > th,
            .table > thead:first-child > tr:first-child > th,
            .table > caption + thead > tr:first-child > td,
            .table > colgroup + thead > tr:first-child > td,
            .table > thead:first-child > tr:first-child > td {
                border-top: 0;
            }
            .table > tbody + tbody {
                border-top: 2px solid #ddd;
            }
            .table .table {
                background-color: #fff;
            }
            .table-condensed > thead > tr > th,
            .table-condensed > tbody > tr > th,
            .table-condensed > tfoot > tr > th,
            .table-condensed > thead > tr > td,
            .table-condensed > tbody > tr > td,
            .table-condensed > tfoot > tr > td {
                padding: 5px;
            }
            .table-bordered {
                border: 1px solid #ddd;
            }
            .table-bordered > thead > tr > th,
            .table-bordered > tbody > tr > th,
            .table-bordered > tfoot > tr > th,
            .table-bordered > thead > tr > td,
            .table-bordered > tbody > tr > td,
            .table-bordered > tfoot > tr > td {
                border: 1px solid #ddd;
            }
            .table-bordered > thead > tr > th,
            .table-bordered > thead > tr > td {
                border-bottom-width: 2px;
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
            <table width="100%">            
                <tr>
                    <td width="33.33%"><p class="text-center" style="margin-top: 10px;"><?= $_MyCookie->image('src/assets/images/osvino.jpg', '', '', '', 'style="height: 166px"') ?></p></td>
                    <td width="33.33%"><p class="text-center" style="font-size: 12pt; border-top: 2px solid black">Titular do Certificado</p></td>
                    <td width="33.33%"><p class="text-center" style="margin-top: 10px; padding-top: 30px"><?= $_MyCookie->image('src/assets/images/juliana.jpg', '', '', '', 'style="height: 126px"') ?></p></td>
                </tr>
            </table>                        
        </div>
        <div class="cert">
            <table width="100%">
                <tr>
                    <td width="50%">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Atividades</th>
                                    <th>CH</th>
                                </tr>                     
                            </thead>
                            <tbody>
                                <?php foreach ($user->getActivities() as $activity) : ?>
                                    <?php if ($activity->getPresent()->contains($user) && $activity->getHasCertificate()) : ?>
                                        <tr>
                                            <td><?= $activity->getName() ?></td>
                                            <td><?= $activity->getDuration() ?>h</td>
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
                            registro sob nº <?= $reg ?>, do Livro 007, página <?= $pag ?>, em <?= $date ?>.</p>
                    </td>
                </tr>
            </table>        
        </div>
    </body>
</html>