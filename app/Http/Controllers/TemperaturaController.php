<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TemperaturaController extends Controller {

    public function RequisicaoApiTemperaturaGet($cidade) {
        $lang = "pt_br";
        $unidade = "metric";
        $chave = "e246103add2cceb1359cb9b3dcbd8244";
        $cidade = urlencode($cidade);
        $url = "http://api.openweathermap.org/data/2.5/weather?q=$cidade&appid=$chave&lang=$lang&units=$unidade";
        // Inicia
        $curl = curl_init($url);
        // Configuracao
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
        ]);
        // Envio e armazenamento da resposta
        $response = curl_exec($curl);
        // Fecha e limpa recursos
        curl_close($curl);
        return $response;
    }

    // buscar a temperatura da cidade

    public function temperaturaCidade(Request $request) {
        $cidade = $request->input('Cidade');
        if (strlen($cidade) > 6) {
            $responta = $this->RequisicaoApiTemperaturaGet($cidade);
            $objeto = json_decode($responta);
            if ($objeto->cod == "200") {
                $weather = $objeto->main;
                
                $musica = $this->temperaturamusica($weather->temp);
                $faixa = new FaixaController();
                return $faixa->buscar_faixa($musica);
                
            } else {
                return json_encode(array('Status' => 'erro', 'Mensagem' => 'Cidade não encontrada'));
            }
        } else {
            return json_encode(array('Status' => 'erro', 'Mensagem' => 'Nome Cidade Curta'));
        }
    }

    public function temperaturamusica($temperatura) {
        if ($temperatura > 30) {
            return "festa";
        } else if ($temperatura > 15 && $temperatura < 30) {
            return "pop";
        } else if ($temperatura > 10 && $temperatura < 14) {
            return "rock";
        } else if ($temperatura < 10) {
            return "musica classica";
        } else {
            return "erro";
        }
    }

    public function getTeste() {
        return json_encode(array('Status' => 'ok', 'Mensagem' => 'Teste ok'));
    }

}

?>
