<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Medico implements \JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    public function getId(): ?int{
        return $this->id;
    }

    /**
     * @ORM\Column(type="integer")
     */
    private $crm;

    public function getCrm():?int{
        return $this->crm;
    }

    public function setCrm(int $crm): self{
        $this->crm = $crm;
        return $this;
    }

    /**
     * @ORM\Column(type="string")
     */
    private $nome;

    public function getNome():?string{
        return $this->nome;
    }

    public function setNome(string $nome):self{
        $this->nome = $nome;
        return $this;
    }

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Especialidade")
     * @ORM\JoinColumn(nullable=false)
     */
    private $especialidade;

    public function getEspecialidade(): ?Especialidade
    {
        return $this->especialidade;
    }

    public function setEspecialidade(?Especialidade $especialidade): self
    {
        $this->especialidade = $especialidade;

        return $this;
    }

    public function jsonserialize(){
        return [
            "id" => $this->id,
            "nome" => $this->nome,
            "crm" => $this->crm,
            "especialidadeId" => $this->especialidade->getId()
        ];
    }
}