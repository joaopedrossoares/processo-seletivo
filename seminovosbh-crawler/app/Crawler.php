<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Crawler extends Model
{
    public static function pesquisaTodos($request){

        //Monta a raiz da url
        $url = "https://www.seminovosbh.com.br/resultadobusca/index/";

        //Filtros
        $url = Search::buildUrl($url, $request);  

        $html = file_get_contents($url);
        
        //Pega lista de carros
        $filtro = Search::getListCars($html);

        //Pega a quantidade total de páginas da consulta
        $totalPaginas = Search::getTotalPage($html);

        //Coloca no array resultante a quantidade de paginas
        $result = array();
        $result[0] = array("totalpaginas" => $totalPaginas);

        //Pega as informações básicas de um veículo(ano, modelo, quilometragem e valor) e coloca no array resultante para formar o json.
        $result [] = Search::buildJson($filtro, $result);

        return response()->json($result, 200);
    }


    public static function comprar($request){

        //Monta a url
        $url = "https://www.seminovosbh.com.br/comprar/";
        $url = $url.$request->marca."/".$request->modelo."/".$request->anos."/".$request->codigo;
        $html = file_get_contents($url);

        //Detalhes
        $arrayDetalhes = Scraper::capturaDetalhes($html);
        $result['detalhes'] = $arrayDetalhes;

        //Acessórios
        $arrayAcessorios = Scraper::capturaAccessories($html);
        $result['acessorios'] = $arrayAcessorios;

        //Observações
        $observacao = Scraper::capturaObservacoes($html);
        $result['observacoes'] = $observacao;

        return response()->json($result, 200);
    }
}

