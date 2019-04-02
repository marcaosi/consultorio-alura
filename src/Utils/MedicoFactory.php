<?php

namespace App\Utils;
use App\Entity\Medico;
use App\Utils\EntidadeFactory;
use App\Repository\EspecialidadeRepository;

class MedicoFactory implements EntidadeFactory{
    private $especialidadeRepository;

    public function __construct(
        EspecialidadeRepository $especialidadeRepository
        ){
        $this->especialidadeRepository = $especialidadeRepository;
    }
    
    public function criarEntidade(string $json){
        $dados = json_decode($json);
        $especialidade = $this->especialidadeRepository->find($dados->especialidadeId);

        $medico = new Medico();
        $medico->setCrm($dados->crm);
        $medico->setNome($dados->nome);
        $medico->setEspecialidade($especialidade);

        return $medico;
    }
}