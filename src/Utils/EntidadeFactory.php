<?php
namespace App\Utils;

interface EntidadeFactory{
    public function criarEntidade(string $json);
}