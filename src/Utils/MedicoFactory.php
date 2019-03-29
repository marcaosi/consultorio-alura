<?php

namespace App\Utils;
use App\Entity\Medico;

class MedicoFactory{
    public function criarMedico(string $json): Medico{
        $dados = json_decode($json);

        $medico = new Medico();
        $medico->crm = $dados->crm;
        $medico->nome = $dados->nome;

        return $medico;
    }
}