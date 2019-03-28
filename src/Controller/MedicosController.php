<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Medico;

class MedicosController extends AbstractController{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/medicos", methods={"POST"})
     */
    public function novo(Request $request) : Response{
        $corpoRequisicao = $request->getContent();
        $dados = json_decode($corpoRequisicao);

        $medico = new Medico();
        $medico->crm = $dados->crm;
        $medico->nome = $dados->nome;

        $this->entityManager->persist($medico);
        $this->entityManager->flush();

        return new JsonResponse($medico);
    }

    /**
     * @Route("/medicos", methods={"GET"})
     */
    public function findAll() : Response{
        $repositorioDeMedicos = $this->getDoctrine()->getRepository(Medico::class);

        $medicoList = $repositorioDeMedicos->findAll();

        return new JsonResponse($medicoList);
    }

    /**
     * @Route("/medicos/{id}", methods={"GET"})
     */
    public function find(Request $request) : Response{
        $repositorioDeMedicos = $this->getDoctrine()->getRepository(Medico::class);

        $id = $request->get("id");
        $medico = $repositorioDeMedicos->find($id);
        $codigoResposta = is_null($medico) ? Response::HTTP_NO_CONTENT : 200;

        return new JsonResponse($medico, $codigoResposta);
    }
}