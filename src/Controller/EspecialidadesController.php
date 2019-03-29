<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Especialidade;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\EspecialidadeRepository;

class EspecialidadesController extends AbstractController
{
    private $entityManager;
    private $especialidadeRepository;

    public function  __construct(
        EntityManagerInterface $entityManager,
        EspecialidadeRepository $especialidadeRepository
        ){
        
        $this->entityManager = $entityManager;
        $this->especialidadeRepository = $especialidadeRepository;
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

    /**
     * @Route("/especialidades", methods={"GET"})
     */
    public function findAll() : Response{
        $especialidadeList = $this->especialidadeRepository->findAll();

        return new JsonResponse($especialidadeList);
    }

    /**
     * @Route("/especialidades/{id}", methods={"GET"})
     */
    public function find($id) : Response{
        $especialidade = $this->especialidadeRepository->find($id);

        return new JsonResponse($especialidade);
    }

    /**
     * @Route("/especialidades/{id}", methods={"PUT"})
     */
    public function update($id, Request $request) : Response{
        $dados = json_decode($request->getContent());
        $especialidade = $this->especialidadeRepository->find($id);

        $especialidade->setDescricao($dados->descricao);

        $this->entityManager->flush();

        return new JsonResponse($especialidade);
    }

    /**
     * @Route("/especialidades/{id}", methods={"DELETE"})
     */
    public function remove($id) : Response{
        $especialidade = $this->especialidadeRepository->find($id);

        $this->entityManager->remove($especialidade);
        $this->entityManager->flush();

        return new JsonResponse('', Response::HTTP_NO_CONTENT);
    }
}
