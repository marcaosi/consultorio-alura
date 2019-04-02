<?php

namespace App\Utils;

use Symfony\Component\HttpFoundation\Request;

class ExtratorDadosRequest{
    private function buscaDadosRequest(Request $request){
        $sort = $request->get('sort');
        $filter = $request->query->all();
        unset($filter['sort']);

        return [$sort, $filter];
    }

    public function buscaDadosOrdenacao(Request $request){
        [$sort, ] = $this->buscaDadosRequest($request);

        return $sort;
    }

    public function buscaDadosFiltro(Request $request){
        [, $filter] = $this->buscaDadosRequest($request);

        return $filter;
    }
}