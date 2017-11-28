<?php

namespace Monitor;

class Process{

    public static function getAllProcess(){
        $response = Request::doTheRequest('GET', 'API/bpm/process?p=0&c=1000');
        return $response['data'];
    }

    public static function getProcessName($id){
        $response = Request::doTheRequest('GET', 'API/bpm/process/'.$id);
        $process = $response['data'];
        return $process->name;
    }

    public static function getCountProcess(){
        $response = Request::doTheRequest('GET', 'API/bpm/process?p=0&c=1000');
        return count($response['data']);
    }

    public static function initiateProcess($id){
        $response = Request::doTheRequest('POST', 'API/bpm/process/'.$id.'/instantiation');
        return $response;
    }
	
	public static function setVariable($caseId, $variable, $idBBDD){
		$response = Request::doTheRequest('PUT', 'API/bpm/caseVariable/'.$caseId.'/'.$variable, $variable, $idBBDD);
        return $response;
    }
}