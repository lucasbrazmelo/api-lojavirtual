<?php

namespace App\Libraries;

class ViaCEP {

    const URL_VIACEP = 'http://viacep.com.br/ws/';
    const METHOD = 'json';

    private $cep;
    private $logradouro;
    private $complemento;
    private $bairro;
    private $localidade;
    private $uf;
    private $unidade;
    private $ibge;
    private $gia;
    private $ddd;
    private $siafi;

    public function find(string $cep = "") {

        $this->setCep($cep);

        $url = self::URL_VIACEP . $this->getCep() . '/' . self::METHOD;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);

        if ($data !== null && !array_key_exists('erro', $data)) {
            $this->fill($data);
        }
    }

    private function fill(array $attributes) {

        foreach ($attributes as $key => $value) {
            $this->{"set" . ucfirst($key)}($value);
        }

    }

    public function toJson() {

        $json = json_encode($this->toArray());
        return $json;
    }

    public function toArray(): array {
        $array = get_object_vars($this);
        return $array;
    }

    public function getCep() {
        return $this->cep;
    }

    public function getLogradouro() {
        return $this->logradouro;
    }

    public function getComplement0() {
        return $this->complement;
    }

    public function getBairro() {
        return $this->bairro;
    }

    public function getLocalidade() {
        return $this->localidade;
    }

    public function getUf() {
        return $this->uf;
    }

    public function getUnidade() {
        return $this->unidade;
    }

    public function getIbge() {
        return $this->ibge;
    }

    public function getGia() {
        return $this->gia;
    }

    private function setCep($cep) {

        // retira espacos em branco e mantem apenas numeros
        $cepClean = trim(preg_replace("/[^0-9]/", "", $cep));

        $this->cep = $cepClean;
    }

    private function setLogradouro(string $logradouro) {
        $this->logradouro = $logradouro;
    }

    private function setComplemento(string $complemento) {
        $this->complemento = $complemento;
    }

    private function setBairro(string $bairro) {
        $this->bairro = $bairro;
    }

    private function setLocalidade(string $localidade) {
        $this->localidade = $localidade;
    }

    private function setUf(string $uf) {
        $this->uf = $uf;
    }

    private function setUnidade(string $unidade) {
        $this->unidade = $unidade;
    }

    private function setIbge(string $ibge) {
        $this->ibge = $ibge;
    }

    private function setGia(string $gia) {
        $this->gia = $gia;
    }
    private function setDdd(string $ddd) {
        $this->ddd = $ddd;
    }
    private function setSiafi(string $siafi) {
        $this->ddd = $siafi;
    }
}