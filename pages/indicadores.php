<?php

namespace Monitor;

require '../includes/config.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'layout/defaultHead.php'; ?>

    <!-- DataTables CSS -->
    <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

</head>

<body>

    <div id="wrapper">
        <!-- Navigation -->
        <?php include 'layout/navbar.php'; ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Indicadores</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>


            <?php
                $rubros =  ["Auto", "Casa", "Objeto"];                
                foreach ($rubros as $rubro) {
            ?>                    
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Casos que pertenecen al rubro <?= $rubro ?>, iniciados en el último mes, con el promedio de montos abonados
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <?php $data = Indicators::getMontoPromedioCasosUltimoMesPorRubro($rubro); ?>
                                <table class="table table-bordered tablaCases" width="100%"
                                       cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th>Total Casos <?= $rubro ?> </th>
                                        <th>Total Casos Último Mes</th>
                                        <th>Monto Abonado Total</th>
                                        <th>Monto Abonado Promedio</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        echo '<tr>';
                                        echo '<td>' . $data["totalCasosRubro"] . '</td>';
                                        echo '<td>' . $data["totalCasosRubroUltimoMes"] . '</td>';
                                        echo '<td>' . $data["montoAbonadoTotal"] . '</td>';
                                        echo '<td>' . $data["montoAbonadoTotalPromedio"] . '</td>';
                                        echo '</tr>';
                                    ?>
                                    </tbody>
                                </table>
                 
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <?php
                }
            ?>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    <?php include 'layout/defaultFooter.php'; ?>

    <!-- DataTables JavaScript -->
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>

</body>

</html>
