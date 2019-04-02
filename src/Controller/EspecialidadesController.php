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
use App\Utils\EspecialidadeFactory;

class EspecialidadesController extends BaseController
{

    public function  __construct(
        EspecialidadeRepository $repository, 
        EntityManagerInterface $entityManager,
        EspecialidadeFactory $especialidadeFactory
    ){
        
        parent::__construct($repository, $entityManager, $especialidadeFactory);
    }

   public function atualizaEntidadeExistente($id, $entidadeEnviada){
       $entidadeExistente = $this->repository->find($id);
       if(is_null($entidadeExistente)){
           throw new \InvalidArgumentException();
       }

       $entidadeExistente->setDescricao($entidadeEnviada->getDescricao());

       return $entidadeExistente;
   }
}
