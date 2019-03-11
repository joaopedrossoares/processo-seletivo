<?php

use Illuminate\Http\Request;

Route::get("detalhes/{marca}/{modelo}/{anos}/{codigo}", "PesquisaController@comprar");

Route::get('pesquisa/{veiculo}/{marca}/{modelo}/{estado_conservacao?}/{cidade?}/{valor1?}/{valor2?}/{ano1?}/{ano2?}/{usuario?}/{pagina?}', 'PesquisaController@pesquisar');
