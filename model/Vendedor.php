<?php

class Vendedor {

    private int $codigo;
    private string $nome;
    private string $contacto;
    private string $genero;
    private string $estadoCivil;
    private int $codigo_produto;
    private int $quantidade;
    private int $diasTrabalhados;
    private float $salarioDiario;
    private float $bonusDiario = 0;

    public function __construct(
        int $codigo,
        string $nome,
        string $contacto,
        string $genero,
        string $estadoCivil,
        int $codigo_produto,
        int $quantidade,
        int $diasTrabalhados,
        float $salarioDiario
    ) {
        $this->codigo = $codigo;
        $this->nome = $nome;
        $this->contacto = $contacto;
        $this->genero = $genero;
        $this->estadoCivil = $estadoCivil;
        $this->codigo_produto = $codigo_produto;
        $this->quantidade = $quantidade;
        $this->diasTrabalhados = $diasTrabalhados;
        $this->salarioDiario = $salarioDiario;

        $this->calcularBonus();
    }


    private function calcularBonus(): void {
        if ($this->quantidade >= 50) {
            $this->bonusDiario = $this->salarioDiario * 0.5;
        } elseif ($this->quantidade >= 25) {
            $this->bonusDiario = $this->salarioDiario * 0.25;
        } elseif ($this->quantidade >= 10) {
            $this->bonusDiario = $this->salarioDiario * 0.1;
        } else {
            $this->bonusDiario = 0;
        }
    }

    public function calcularValor(float $precoUnitario): float {
        return $this->quantidade * $precoUnitario;
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

    public function getContacto(): string {
        return $this->contacto;
    }

    public function setContacto(string $contacto): void {
        $this->contacto = $contacto;
    }

    public function getGenero(): string {
        return $this->genero;
    }

    public function setGenero(string $genero): void {
        $this->genero = $genero;
    }

    public function getEstadoCivil(): string {
        return $this->estadoCivil;
    }

    public function setEstadoCivil(string $estadoCivil): void {
        $this->estadoCivil = $estadoCivil;
    }

    public function getCodigoProduto(): int {
        return $this->codigo_produto;
    }

    public function setCodigoProduto(int $codigo_produto): void {
        $this->codigo_produto = $codigo_produto;
    }

    public function getQuantidade(): int {
        return $this->quantidade;
    }

    public function setQuantidade(int $quantidade): void {
        $this->quantidade = $quantidade;
        $this->calcularBonus();
    }

    public function getDiasTrabalhados(): int {
        return $this->diasTrabalhados;
    }

    public function setDiasTrabalhados(int $diasTrabalhados): void {
        $this->diasTrabalhados = $diasTrabalhados;
    }

    public function getSalarioDiario(): float {
        return $this->salarioDiario;
    }

    public function setSalarioDiario(float $salarioDiario): void {
        $this->salarioDiario = $salarioDiario;
        $this->calcularBonus();
    }

    public function getBonusDiario(): float {
        return $this->bonusDiario;
    }
}
