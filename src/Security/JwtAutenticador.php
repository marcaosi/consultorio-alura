<?php

namespace App\Security;

use App\Repository\UserRepository;
use App\Entity\User;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Firebase\JWT\JWT;

class JwtAutenticador extends AbstractGuardAuthenticator{
    private $repository;

    public function __construct(UserRepository $repository){
        $this->repository = $repository;    
    }

    public function supportsRememberMe(){
        return false;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey){
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception){
        return new JsonResponse(['erro' => 'Falha na autenticação'], Response::HTTP_UNAUTHORIZED);
    }

    public function supports(Request $request){
        return $request->getPathInfo() !== '/login';
    }

    public function getCredentials(Request $request){
        try{
            $token = str_replace('Bearer ', '', $request->headers->get('Authorization'));

            return JWT::decode($token, 'chave', ['HS256']);
        }catch(\UnexpectedValueException $e){
            return false;
        }
    }

    public function getUser($credentials, UserProviderInterface $userProvider){
        if(!is_object($credentials) || !array_key_exists('username', $credentials)){
            return null;
        }

        $user = $this->repository->findOneBy(['username' => $credentials->username]);

        return $user;
    }

    public function checkCredentials($credentials, UserInterface $user){
        return is_object($credentials) && array_key_exists('username', $credentials);
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        // TODO: Implement start() method.
    }
}