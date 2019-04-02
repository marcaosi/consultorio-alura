<?php

namespace App\Utils;

use Symfony\Component\HttpFoundation\Request;

class ExtratorDadosRequest{
    private function buscaDadosRequest(Request $request){
        $queryString = $request->query->all();
        
        $sort = array_key_exists('sort', $queryString)
                ? $queryString['sort']
                : null;
        unset($queryString['sort']);

        $page = array_key_exists('page', $queryString)
                ? $queryString['page']
                : 1;
        unset($queryString['page']);

        $itensPorPagina = array_key_exists('itensPorPagina', $queryString)
                ? $queryString['itensPorPagina']
                : 5;
        unset($queryString['itensPorPagina']);

        return [$sort, $queryString, $page, $itensPorPagina];
    }

    public function buscaDadosOrdenacao(Request $request){
        [$sort, ] = $this->buscaDadosRequest($request);

        return $sort;
    }

    public function buscaDadosFiltro(Request $request){
        [, $filter] = $this->buscaDadosRequest($request);

        return $filter;
    }

    public function buscaDadosPaginacao(Request $request){
        [, , $page, $itensPorPagina] = $this->buscaDadosRequest($request);
        return [$page, $itensPorPagina];
    }
}