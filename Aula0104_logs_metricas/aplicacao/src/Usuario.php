<?php

class Usuario
{
    private string $nome;
    private DateTimeInterface $dataNascimento;
    private float $peso;
    private float $altura;
    private SexoEnum $sexo;

    public function __construct(string $nome, 
                                DateTimeInterface $dataNascimento, 
                                float $peso, 
                                float $altura, 
                                SexoEnum $sexo)
    {
        $this->nome = $nome;
        $this->dataNascimento = $dataNascimento;
        $this->peso = $peso;
        $this->altura = $altura;
        $this->sexo = $sexo;
    }   


    public function getNome(): string
    {
        return $this->nome;
    }

    public function getDataNascimento(): DateTimeInterface
    {
        return $this->dataNascimento;
    }

    public function getPeso(): float
    {
        return $this->peso;
    }

    public function getAltura(): float
    {
        return $this->altura;
    }

    public function getSexo(): SexoEnum
    {
        return $this->sexo;
    }


    public function getIdadeAtual()
    {
        return $this->dataNascimento->diff(new DateTimeImmutable(date('Y-m-d')))->y;
    }

}
