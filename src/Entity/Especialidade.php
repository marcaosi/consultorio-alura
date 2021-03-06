<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EspecialidadeRepository")
 */
class Especialidade implements \JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descricao;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescricao(): ?string
    {
        return $this->descricao;
    }

    public function setDescricao(string $descricao): self
    {
        $this->descricao = $descricao;

        return $this;
    }

    public function jsonserialize(){
        return [
            "id" => $this->id,
            "descricao" => $this->descricao,
            "_links" => [
                [
                    "rel" => "self",
                    "path" => "/especialidades/".$this->id
                ],
                [
                    "rel" => "medicos",
                    "path" => "/especialidades/".$this->id."/medicos"
                ]
            ]
        ];
    }
}
