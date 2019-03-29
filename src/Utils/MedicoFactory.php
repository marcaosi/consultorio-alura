<?php

namespace App\Utils;
use App\Entity\Medico;
use App\Repository\EspecialidadeRepository;

class MedicoFactory{
    private $especialidadeRepository;

    public function __construct(
        EspecialidadeRepository $especialidadeRepository
        ){
        $this->especialidadeRepository = $especialidadeRepository;
    }
    
    public function criarMedico(string $json): Medico{
        $dados = json_decode($json);
        $especialidade = $this->especialidadeRepository->find($dados->especialidadeId);

        $medico = new Medico();
        $medico->setCrm($dados->crm);
        $medico->setNome($dados->nome);
        $medico->setEspecialidade($especialidade);

        return $medico;
    }
}