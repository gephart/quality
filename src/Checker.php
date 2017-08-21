<?php

namespace Gephart\Quality;

use Gephart\Quality\Bridge\PDependBridge;
use Gephart\Quality\Entity\ClassMetric;

final class Checker
{
    /**
     * @var string
     */
    private $dir = "";

    /**
     * @var array
     */
    private $method_metrics = [];

    /**
     * @var array
     */
    private $class_metrics = [];

    /**
     * @var PDependBridge
     */
    private $pdepend_bridge;

    public function __construct()
    {
        $this->pdepend_bridge = new PDependBridge();
        $this->dir = realpath(__DIR__ . "/../../src");
        $this->method_metrics = ["ccn" => 15, "loc" => 20];
        $this->class_metrics = ["ce" => 50, "dit" => 6, "nom" => 20];
    }

    public function setDir(string $dir)
    {
        $this->dir = $dir;
    }

    /**
     * @return ClassMetric[]
     */
    public function analyse(): array
    {
        $dir = $this->dir;
        $class_metrics = $this->pdepend_bridge->analyse($dir);
        return $class_metrics;
    }
}