<?php

namespace App\Utils;
use App\Entity\Especialidade;
use App\Utils\EntidadeFactory;
use App\Repository\EspecialidadeRepository;

class EspecialidadeFactory implements EntidadeFactory{
    
    public function criarEntidade(string $json){
        $dados = json_decode($json);

        $especialidade = new Especialidade();
        $especialidade->setDescricao($dados->descricao);

        return $especialidade;
    }
}