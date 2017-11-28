<?php

namespace Monitor;

require '../includes/config.php';

$id = $_GET['id'];

//Realizo la instanciación del proceso de negocio que tiene el id que paso en la URL
$p = Process::initiateProcess($id);

//Si se realiza correctamente la instanciación, la API de Bonita me va a devolver un respuesta (o payload)
//en formato JSON, con el ID de la instancia
// {
//    "caseId":"125713789879465465"
// }
$caseId=$p['data']->caseId;
var_dump($caseId);

//Una vez que tengo el ID de la instancia iniciada ya puedo guardarla en la base de datos
//Al guardarla en la base de datos, voy a disponer de un ID de esa inserción en la BBDD
//Ese ID lo voy a poder utilizar para realizar el seguimiento del caso
$idBBDD = 12345;
$varEnBonita = 'idAppMonitor';
$p = Process::setVariable($caseId, $varEnBonita, $idBBDD);
var_dump($p);