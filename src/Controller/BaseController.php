<?php

namespace App\Controller;

use App\Utils\EntidadeFactory;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseController extends AbstractController{

    protected $repository;
    protected $entityManager;
    protected $factory;

    public function __construct(
        ObjectRepository $objectRepository,
        EntityManagerInterface $entityManager,
        EntidadeFactory $factory
    ){
        $this->repository = $objectRepository;
        $this->entityManager = $entityManager;
        $this->factory = $factory;
    }

    public function novo(Request $request): Response{
        $corpoRequisicao = $request->getContent();
        $entidade = $this->factory->criarEntidade($corpoRequisicao);

        $this->entityManager->persist($entidade);
        $this->entityManager->flush();

        return new JsonResponse($entidade);
    }

    public function buscarTodos(){
        $list = $this->repository->findAll();
        return new JsonResponse($list);
    }

    public function buscarUm($id){
        $entidade = $this->repository->find($id);
        return new JsonResponse($entidade);
    }

    public function remove($id){
        $entidade = $this->repository->find($id);
        try{
            if(is_null($entidade)){
                throw new \InvalidArgumentException();
            }
            $this->entityManager->remove($entidade);
            $this->entityManager->flush();
        }catch(\InvalidArgumentException $ex){
            return new Response('', Response::HTTP_NOT_FOUND);
        }

        return new Response('', Response::HTTP_NO_CONTENT);
    }

    public function atualiza($id, Request $request){
        $corpoRequisicao = $request->getContent();
        $entidadeEnviada = $this->factory->criarEntidade($corpoRequisicao);

        try{
            $entidadeExistente = $this->atualizaEntidadeExistente($id, $entidadeEnviada);
            $this->entityManager->flush();

            return new JsonResponse($entidadeExistente);
        }catch(\InvalidArgumentException $ex){
            return new Response('', Response::HTTP_NOT_FOUND);
        }
    }

    abstract public function atualizaEntidadeExistente(int $id, $entidadeEnviada);
}