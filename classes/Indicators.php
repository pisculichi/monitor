<?php


namespace Monitor;
use \DateTime;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Cookie\SessionCookieJar;
use GuzzleHttp\Cookie\CookieJar;

function getIssue($caseId) {
    $client = new Client([
        'base_uri' => "http://localhost:8000/",
    ]);    
    $request = $client->request("GET", "issues/?state=Aprobado&token=bonita&case_id=" . $caseId );
    $issues = $request->getBody();
    return json_decode($issues)[0];
}

class Indicators {

    public static function getMontoPromedioCasosUltimoMesPorRubro($rubro){
        # Casos que pertenecen al rubro $rubro, iniciados en el último mes, con el promedio de montos abonados
        # obtener casos finalizados
        $response = Request::doTheRequest('GET', 'API/bpm/archivedCase?p=0&c=1000');
        $cases = $response['data'];
        $unMesAtras = new DateTime("");
        $unMesAtras->modify('-1 month');
        
        $totalCasosRubro = 0;
        $totalCasosRubroUltimoMes = 0;
        $montoAbonadoTotal = 0;

        foreach ($cases as $case) {
            $issue = getIssue($case->rootCaseId);

            if ($issue->type == $rubro) {
                # casos de tipo $rubro
                $totalCasosRubro++;
                if (new DateTime($case->start) > $unMesAtras) {
                    # del ultimo mes
                    $totalCasosRubroUltimoMes++;
                    $montoAbonadoTotal += (float)$issue->monto;
                }
            }
        }

        return array(
            "totalCasosRubro" => $totalCasosRubro,
            "totalCasosRubroUltimoMes" => $totalCasosRubroUltimoMes,
            "montoAbonadoTotal" => $montoAbonadoTotal,
            "montoAbonadoTotalPromedio" => $montoAbonadoTotal > 0 ? ($montoAbonadoTotal / $totalCasosRubroUltimoMes): 0,
        );
    }

    public static function getPercentageOfCasesResolvedInAMonth(){
        $response = Cases::getArchivedCases();
        $cases = $response['data'];
        $count = count($cases);
        $countInMonth = 0;
        foreach ($cases as $case){
            $startDate = new DateTime($case->start);
            $endDate = new DateTime($case->end_date);
            $days = (int) $startDate->diff($endDate)->format('%a');
            if ($days < 30)
                $countInMonth++;
        }
        if ($count > 0)
            return ($countInMonth/$count) * 100;
        return 0;
    }

}
