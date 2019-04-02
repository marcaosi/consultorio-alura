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
use App\Controller\BaseController;
use App\Utils\ExtratorDadosRequest;

class MedicosController extends BaseController{

    public function __construct(
        EntityManagerInterface $entityManager,
        MedicoFactory $medicoFactory,
        MedicosRepository $medicosRepository,
        ExtratorDadosRequest $extrator
    ){
        parent::__construct($medicosRepository, $entityManager, $medicoFactory, $extrator);
    }

    
    /**
     * @Route("/especialidades/{especialidadeId}/medicos", methods={"GET"})
     */
    public function findByEspecialidade(int $especialidadeId) : Response{
        $medicoList = $this->repository->findBy([
            'especialidade' => $especialidadeId
        ]);

        return new JsonResponse($medicoList);
    }

    public function atualizaEntidadeExistente($id, $entidadeEnviada){
        $entidadeExistente = $this->repository->find($id);
        if(is_null($entidadeExistente)){
            throw new \InvalidArgumentException();
        }

        $entidadeExistente
            ->setCrm($entidadeEnviada->getCrm())
            ->setNome($entidadeEnviada->getNome());

        return $entidadeExistente;
    }
}