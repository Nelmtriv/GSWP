<?php

class Usuario {

    private int $codigo;
    private string $nome;
    private string $email;
    private string $senha;
    private string $criado_em;

    public function __construct(
        int $codigo,
        string $nome,
        string $email,
        string $senha,
        string $criado_em = ""
    ) {
        $this->codigo = $codigo;
        $this->nome = $nome;
        $this->email = $email;
        $this->senha = $senha;
        $this->criado_em = $criado_em;
    }

    public function getCodigo(): int {
        return $this->codigo;
    }

    public function getNome(): string {
        return $this->nome;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getSenha(): string {
        return $this->senha;
    }

    public function getCriadoEm(): string {
        return $this->criado_em;
    }
}
