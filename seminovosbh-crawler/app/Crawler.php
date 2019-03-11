<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Crawler extends Model
{
    public static function pesquisaTodos($request){

        //Monta a raiz da url
        $externa = "https://www.seminovosbh.com.br/resultadobusca/index/";

        //Filtros
        if($request->veiculo == "carro")
            $externa .= "veiculo/carro/";
        if($request->veiculo == "moto")
            $externa .= "veiculo/moto/";
        if($request->veiculo == "caminhao")
            $externa .= "veiculo/caminhao/";
        
        if($request->estado_conservacao == "0km")
            $externa .= "estado-conservacao/0km/";
        if($request->estado_conservacao == "seminovo")
            $externa .= "estado-conservacao/seminovo/";

        $externa .= "marca/".$request->marca."/";
        $externa .= "modelo/".$request->modelo."/";

        if(isset($request->cidade))
            $externa .= "cidade/".$request->cidade."/";
        
        if(isset($request->valor1) && isset($request->valor2))
            $externa .= "valor1/".$request->valor1."/valor2/".$request->valor2."/";
        
        if(isset($request->ano1) && isset($request->ano2))
            $externa .= "ano1/".$request->ano1."/ano2/".$request->ano2."/";
        
        if($request->usuario == "particular")
            $externa .= "usuario/particular/";
        else if($request->usuario == "revenda")
            $externa .= "usuario/revenda/";
        else 
            $externa .= "usuario/todos/";
        
        $externa .= "qtdpag/50/";

        if(isset($request->pagina))
            $externa .= "pagina/".$request->pagina."/";
        
        //Pega lista de carros
        $resultados = file_get_contents($externa);
        $resultados_filtro = explode('<dd class="titulo-busca">', $resultados);
        unset($resultados_filtro[0]);

        //Pega a quantidade total de páginas da consulta
        $aux1 = explode('<strong class="total">', $resultados);
        $aux2 = explode('</strong>', $aux1[1]);
        $totalPaginas = $aux2[0];

        //Coloca no array resultante a quantidade de paginas
        $result = array();
        $result[0] = array("totalpaginas" => $totalPaginas);

        //Pega as informações básicas de um veículo(ano, modelo, quilometragem e valor) e coloc ano array resultante para formar o json.

        foreach($resultados_filtro as $resultado){
            $resto = explode('</dd>', $resultado);
            $linha = $resto[0];
            $arraySlug = explode('/', $linha);
            $slug = $arraySlug[1]."/".$arraySlug[2]."/".$arraySlug[3]."/".$arraySlug[4]."/".$arraySlug[5]."/";
            
            $grid = $resto[2];
            $aux1 = explode('<p>', $grid);
            $aux2 = explode('</p>', $aux1[1]);
            $ano = $aux2[0];

            $grid = $resto[2];
            $aux1 = explode('<p>', $grid);
            $km = strip_tags($aux1[2]);

            $aux1 = explode('<h4>', $linha);
            $aux2 = explode('</h4>', $aux1[1]);
            $titulo = strip_tags($aux2[0]);
            var_dump($titulo);

            $result[] = array("slug"=> $slug, "modelo/preço" => $titulo, "ano" => $ano, "km" => $km);
        }

        return response()->json($result, 200);
    }


    public static function comprar($request){

        //Monta a url
        $externa = "https://www.seminovosbh.com.br/comprar/";
        $externa = $externa.$request->marca."/".$request->modelo."/".$request->anos."/".$request->codigo;
        
        $resultados = file_get_contents($externa);

        //Detalhes
        $arrayDetalhes = array();
        $aux1 = explode('<div id="infDetalhes" class="info-detalhes">', $resultados);
        $aux2 = explode('</div>', $aux1[1]);
        $detalhes = explode('<li>', $aux2[0]);
        unset($detalhes[0]);

        foreach($detalhes as $detalhe){
            $linha = explode('</li>', $detalhe);
            $arrayDetalhes[] = $linha[0];
        }

        $result['detalhes'] = $arrayDetalhes;

        //Acessórios
        $aux1 = explode('<div id="infDetalhes2" class="info-detalhes">', $resultados);
        $aux2 = explode('</div>', $aux1[1]);
        $acessorios = explode('<li>', $aux2[0]);
        unset($acessorios[0]);
        $arrayAcessorios = array();

        foreach($acessorios as $acessorio){
            $linha = explode('</li>', $acessorio);
            $arrayAcessorios[] = $linha[0];
        }
        $result['acessorios'] = $arrayAcessorios;

        //Observações
        $aux1 = explode('<div id="infDetalhes3" class="info-detalhes">', $resultados);
        $aux2 = explode('</div>', $aux1[1]);
        $observacoes = explode('<p>', $aux2[0]);
        $linha = explode('</p>', $observacoes[1]);
        $observacao = $linha[0];

        $result['observacoes'] = $observacao;

        return response()->json($result, 200);
    }
}

