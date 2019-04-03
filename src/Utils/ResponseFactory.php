<?php

namespace App\Utils;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class ResponseFactory{
    private $sucesso;
    private $conteudoResposta;
    private $statusResposta;
    private $paginaAtual;
    private $itensPorPagina;

    public function __construct(bool $sucesso, $conteudoResposta, int $statusResposta = Response::HTTP_OK, int $paginaAtual = null, int $itensPorPagina = null){
        $this->sucesso = $sucesso;
        $this->conteudoResposta = $conteudoResposta;
        $this->statusResposta = $statusResposta;
        $this->paginaAtual = $paginaAtual;
        $this->itensPorPagina = $itensPorPagina;
    }

    public function getResponse(){
        $response = [
            'sucesso' => $this->sucesso,
            'paginaAtual' => $this->paginaAtual,
            'itensPorPagina' => $this->itensPorPagina,
            'conteudoDaResposta' => $this->conteudoResposta
        ];

        if(is_null($this->paginaAtual)){
            unset($response['paginaAtual']);
            unset($response['itensPorPagina']);
        }

        return new JsonResponse($response, $this->statusResposta);
    }
}