<?php

namespace App\Http\Controllers;

class FaixaController extends Controller {

    public function RequisicaoApiMusicaGet($musica) {
        $type = "track%2Cartist";
        $musica = urlencode($musica);
        $url = "https://api.spotify.com/v1/search?type=" . $type . "&q=" . $musica;
        $chave = "BQCES3O0d-6USubKeTqF4TatNZfA-UeB0J6QW3BV5gJ0Ok7HqWe15htH_Jt22hvVp_Lm-IcvsD8IKN1AeQUeX8roRrbfJVKO3Uu7k4Nqiclyi5Fg1aJOkd-ET26r3R_jvx7JyKVtAzGk4nMX_PYzch80WvttBTsgPyfD3alEwqS8B0c603Qz8_bQ";

        // Inicia
        $curl = curl_init();
        // Configuracao
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Accept:application/json',
            'Content-Type:application/json',
            'Authorization:Bearer ' . $chave
        ));
        // Envio e armazenamento da resposta
        $response = curl_exec($curl);
        // Fecha e limpa recursos
        curl_close($curl);
        return $response;
    }

    public function buscar_faixa($faixa) {
        $lista = json_decode($this->RequisicaoApiMusicaGet($faixa));
        if (isset($lista->artists->items) == true) {
            $lista_faixa = array();
            for ($i = 0; $i < sizeof($lista->artists->items); $i++) {
                $imagem = array();
                if (sizeof($lista->artists->items[$i]->images) > 0) {
                    $imagem = array(
                        'Caminho' => $lista->artists->items[$i]->images[0]->url,
                    );
                }
                array_push($lista_faixa, array(
                    'Nome' => $lista->artists->items[$i]->name,
                    'Imagem' => $imagem,
                    'Genero' => $lista->artists->items[$i]->genres,
                    'Url_Musica' => $lista->artists->items[$i]->external_urls->spotify
                        )
                );
            }
            return json_encode(array('Status'=>'ok','Lista'=>$lista_faixa));
        } else {
            return json_encode(array('Status'=>'erro'));
        }
    }

    public function faixa_pop() {
        return $this->buscar_faixa('pop');
    }

    public function faixa_rock() {
        return $this->buscar_faixa('rock');
    }

    public function faixa_classica() {
        return $this->buscar_faixa('musica classica');
    }

    public function faixa_festa() {
        return $this->buscar_faixa('musica festa');
    }

}
