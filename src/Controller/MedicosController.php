<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Medico;
use App\Utils\MedicoFactory;
use App\Repository\MedicosRepository;

class MedicosController extends AbstractController{

    private $entityManager;
    private $medicoFactory;
    private $especialidadesRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        MedicoFactory $medicoFactory,
        MedicosRepository $medicosRepository
    ){
        $this->entityManager = $entityManager;
        $this->medicoFactory = $medicoFactory;
        $this->medicosRepository = $medicosRepository;
    }

    /**
     * @Route("/medicos", methods={"POST"})
     */
    public function novo(Request $request) : Response{
        $corpoRequisicao = $request->getContent();
        $medico = $this->medicoFactory->criarMedico($corpoRequisicao);

        $this->entityManager->persist($medico);
        $this->entityManager->flush();

        return new JsonResponse($medico);
    }

    /**
     * @Route("/medicos", methods={"GET"})
     */
    public function findAll() : Response{
        $medicoList = $this->medicosRepository->findAll();

        return new JsonResponse($medicoList);
    }

    /**
     * @Route("/medicos/{id}", methods={"GET"})
     */
    public function find(int $id) : Response{
        $medico = $this->buscaMedico($id);
        $codigoResposta = is_null($medico) ? Response::HTTP_NO_CONTENT : 200;

        return new JsonResponse($medico, $codigoResposta);
    }

    /**
     * @Route("/medicos/{id}", methods={"PUT"})
     */
    public function atualiza(int $id, Request $request): Response{
        $corpoRequisicao = $request->getContent();
        $medicoRecebido = $this->medicoFactory->criarMedico($corpoRequisicao);
        $medicoBuscado = $this->buscaMedico($id);

        if(is_null($medicoBuscado)){
            return new Response('', Response::HTTP_NOT_FOUND);
        }

        $medicoBuscado->setCrm($medicoRecebido->getCrm());
        $medicoBuscado->setNome($medicoRecebido->getNome());
        $medicoBuscado->setEspecialidade($medicoRecebido->getEspecialidade());

        $this->entityManager->flush();

        return new JsonResponse($medicoBuscado);
    }

    /**
     * @Route("/medicos/{id}", methods={"DELETE"})
     */
    public function remove(int $id): Response{
        $medico = $this->buscaMedico($id);

        $this->entityManager->remove($medico);
        $this->entityManager->flush();

        return new Response('', Response::HTTP_NO_CONTENT);
    }

    public function buscaMedico($id){
        $medico = $this->medicosRepository->find($id);

        return $medico;
    }

    
    /**
     * @Route("/especialidades/{especialidadeId}/medicos", methods={"GET"})
     */
    public function findByEspecialidade(int $especialidadeId) : Response{
        $medicoList = $this->medicosRepository->findBy([
            'especialidade' => $especialidadeId
        ]);

        return new JsonResponse($medicoList);
    }
}