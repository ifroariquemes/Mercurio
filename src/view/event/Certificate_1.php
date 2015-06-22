<?php
$reg = 999; //O ultimo registro
$pag = 51; //a ultima pagina
$cert = 0;
?>
<meta charset="utf-8">
<style>
    .row { clear: both; width: 100% }
    .col-xs-2 {
        float: left;
        width: 16.66%;
    }
    .col-xs-4 {
        float: left;
        width: 33.33%;
    }
    .col-xs-5 {
        float: left;
        width: 41.66%;
    }
    .col-xs-6 {
        float: left;
        width: 50%;
    }
    .col-xs-8 { 
        float: left;
        width: 66.66%;
    }
    .col-xs-12 {
        width: 100%;
    }
    .col-xs-offset-1 {
        margin-left: 8.33%;
    }
    .text-center { text-align: center }
    .text-right { text-align: right }
    .text-justify { text-align: justify }

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
</style>
<style>
    * { font-family: Arial, Verdana, Tahoma, "Heveltica" }
    .cert {                
        page-break-after: always; 
        page-break-inside: avoid;
    }
    @media print{@page {size: landscape}}
</style>
<?php
foreach ($data as $user) : $reg++;
    $cert++;
    $pag = $pag + (($cert - 1) % 3 == 0)
    ?>    
    <div class="cert">
        <div class="row">
            <div class="col-xs-2">
                <img src="http://mercurio.natanaelsimoes.com/src/assets/images/brasao.jpg" style="height: 150px">
            </div>
            <div class="col-xs-8">
                <h1 class="text-center" style="font-size: 18pt">Ministério da Educação</h1>
                <h4 class="text-center" style="font-size: 12pt">
                    Secretaria de Educação Profissional e Tecnológica<br>
                    Instituto Federal de Educação, Ciência e Tecnologia de Rondônia/Campus Ariquemes<br>
                    Departamento de Extensão</h4>
            </div>
            <div class="col-xs-2">
                <p class="text-right"><img src="http://mercurio.natanaelsimoes.com/src/assets/images/ifro.jpg" style="height: 150px"></p>
            </div>            
        </div>    
        <div class="row">
            <div class="col-xs-12">                 
                <h1 class="text-center" style="font-size: 65pt">Certificado</h1>
                <p class="text-justify" style="font-size: 14pt">Certificamos que <span style="font-size:22pt"><b><?= ucwords($user->getCompleteName()) ?></b></span> participou do  
                    <b><i>I Encontro de Informática do Instituto Federal de Rondônia</i></b>, 
                    realizado de 03 a 05 de novembro de 2014, 
                    no Instituto Federal de Educação, Ciência e Tecnologia de Rondônia – Campus Ariquemes.</p>
                <h3 class="text-center" style="font-size:16pt"><i>Ariquemes, 28 de novembro de 2014.</i></h3>
            </div>
        </div>        
        <div class="row">
            <div class="col-xs-4">
                <p class="text-center" style="margin-top: 30px;"><img src="http://mercurio.natanaelsimoes.com/src/assets/images/osvino.jpg" style="height: 166px"></p>
            </div>
            <div class="col-xs-4">
                <p class="text-center" style="font-size: 12pt; border-top: 2px solid black; margin-top: 60px">Titular do Certificado</p>
            </div>
            <div class="col-xs-4">
                <p class="text-center" style="margin-top: 30px; padding-top: 30px"><img src="http://mercurio.natanaelsimoes.com/src/assets/images/juliana.jpg" style="height: 126px"></p>
            </div>
        </div>
    </div>
    <div class="cert">
        <div class="row">
            <div class="col-xs-6">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Atividades</th>
                            <th>CH</th>
                        </tr>                     
                    </thead>
                    <tbody>
                        <?php foreach ($user->getActivities() as $activity) : ?>
                            <tr>
                                <td><?= $activity->getName() ?></td>
                                <td><?= $activity->getDuration() ?>h</td>
                            </tr>
                        <?php endforeach; ?>                        
                    </tbody>
                </table>
            </div>
            <div class="col-xs-offset-1 col-xs-5">
                <p class="text-center"><b>REGISTRO DO CERTIFICADO</b></p>
                <p class="text-justify">Certificado expedido pelo Departamento de Extensão do Instituto Federal de Educação, 
                    Ciência e Tecnologia de Rondônia - Campus Ariquemes, 
                    registro sob nº <?= $reg ?>, do Livro 003, página <?= $pag ?>, em 28/11/2014.</p>
            </div>
        </div>
    </div>
<?php endforeach; ?>
