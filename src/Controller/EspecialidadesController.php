<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Especialidade;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;

class EspecialidadesController extends AbstractController
{
    private $entityManager;

    public function  __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/especialidades", methods={"POST"})
     */
    public function new(Request $request): Response
    {
        $corpoRequisicao = $request->getContent();
        $dados = json_decode($corpoRequisicao);

        $especialidade = new Especialidade();
        $especialidade->setDescricao($dados->descricao);

        $this->entityManager->persist($especialidade);
        $this->entityManager->flush();

        return new JsonResponse($especialidade);
    }
}
