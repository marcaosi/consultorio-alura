<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Firebase\JWT\JWT;

class LoginController extends AbstractController
{
    private $repository;
    private $encoder;

    public function __construct(UserRepository $repository, UserPasswordEncoderInterface $encoder){
        $this->repository = $repository;    
        $this->encoder = $encoder;
    }

    /**
     * @Route("/login", methods={"post"})
     */
    public function index(Request $request)
    {
        $dadosEmJson = json_decode($request->getContent());

        if(is_null($dadosEmJson->usuario) || is_null($dadosEmJson->senha)){
            return new JsonResponse([
                "erro" => "Informe usuário e senha."
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = $this->repository->findOneBy([
            'username' => $dadosEmJson->usuario
        ]);

        if(!$this->encoder->isPasswordValid($user, $dadosEmJson->senha)){
            return new JsonResponse([
                'erro' => 'Usuário ou senha inválidos'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $token = JWT::encode(['username' => $user->getUsername()], 'chave');

        return new JsonResponse([
            'access_token' => $token
        ]);
    }
}
