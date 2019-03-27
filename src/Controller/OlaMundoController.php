<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class OlaMundoController
{
    /**
     * @Route("/ola")
     */
    public function olaMundoAction(Request $request) : Response
    {
        $params = $request->query->all();
        return new JsonResponse(["mensagem" => "Olá mundo", "query" => $params]);
    }
}