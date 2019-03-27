<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Medico;

class MedicosController{
    /**
     * @Route("/medicos", methods={"POST"})
     */
    public function novo(Request $request) : Response{
        $corpoRequisicao = $request->getContent();
        $dados = json_decode($corpoRequisicao);

        $medico = new Medico();
        $medico->crm = $dados->crm;
        $medico->nome = $dados->nome;

        return new JsonResponse($medico);
    }
}