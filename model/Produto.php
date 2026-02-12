<?php

class Produto {

    private int $codigo;
    private string $nome;
    private string $unidadeMedida;
    private float $quantidade;
    private float $precoUnitario;
    private string $dataValidade;

    public function __construct(
        int $codigo,
        string $nome,
        string $unidadeMedida,
        float $quantidade,
        float $precoUnitario,
        string $dataValidade
    ) {
        $this->codigo = $codigo;
        $this->nome = $nome;
        $this->unidadeMedida = $unidadeMedida;
        $this->quantidade = $quantidade;
        $this->precoUnitario = $precoUnitario;
        $this->dataValidade = $dataValidade;
    }

    public function getCodigo(): int {
        return $this->codigo;
    }

    public function setCodigo(int $codigo): void {
        $this->codigo = $codigo;
    }

    public function getNome(): string {
        return $this->nome;
    }

    public function setNome(string $nome): void {
        $this->nome = $nome;
    }

    public function getUnidadeMedida(): string {
        return $this->unidadeMedida;
    }

    public function setUnidadeMedida(string $unidadeMedida): void {
        $this->unidadeMedida = $unidadeMedida;
    }

    public function getQuantidade(): float {
        return $this->quantidade;
    }

    public function setQuantidade(float $quantidade): void {
        $this->quantidade = $quantidade;
    }

    public function getPrecoUnitario(): float {
        return $this->precoUnitario;
    }

    public function setPrecoUnitario(float $precoUnitario): void {
        $this->precoUnitario = $precoUnitario;
    }

    public function getDataValidade(): string {
        return $this->dataValidade;
    }

    public function setDataValidade(string $dataValidade): void {
        $this->dataValidade = $dataValidade;
    }

    public function __toString(): string {
        return $this->nome;
    }
}
