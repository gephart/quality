<?php

namespace Gephart\Quality\Entity;

final class ClassMetric extends MetricAbstract
{

    /** @var int */
    private $dit;

    /** @var int */
    private $ce;

    /** @var int */
    private $nom;

    /** @var MethodMetric[] */
    private $methods = [];

    /**
     * @return int
     */
    public function getDit(): int
    {
        return $this->dit;
    }

    /**
     * @param int $dit
     */
    public function setDit(int $dit)
    {
        $this->dit = $dit;
    }

    /**
     * @return int
     */
    public function getCe(): int
    {
        return $this->ce;
    }

    /**
     * @param int $ce
     */
    public function setCe(int $ce)
    {
        $this->ce = $ce;
    }

    /**
     * @return int
     */
    public function getNom(): int
    {
        return $this->nom;
    }

    /**
     * @param int $nom
     */
    public function setNom(int $nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return MethodMetric[]
     */
    public function getMethods(): array
    {
        return $this->methods;
    }

    /**
     * @param string $method_name
     * @return MethodMetric|null
     */
    public function getMethod(string $method_name): ?MethodMetric
    {
        foreach ($this->methods as $method_metric) {
            if ($method_metric->getName() == $method_name) {
                return $method_metric;
            }
        }
        return null;
    }

    /**
     * @param MethodMetric[] $methods
     */
    public function setMethods(array $methods)
    {
        $this->methods = $methods;
    }

    /**
     * @param MethodMetric $method
     * @return bool
     */
    public function addMethod(MethodMetric $method): bool
    {
        $this->methods[] = $method;
        return true;
    }

    /**
     * @param MethodMetric $method
     * @return bool
     */
    public function removeMethod(MethodMetric $method): bool
    {
        $key = array_search($method, $this->methods, true);

        if ($key !== false) {
            unset($this->methods[$key]);

            return true;
        }

        return false;
    }

}