<?php

namespace Gephart\Quality;

use Gephart\Quality\Bridge\PDependBridge;
use Gephart\Quality\Entity\ClassMetric;
use Gephart\Quality\Entity\MethodMetric;

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

    public function analyse()
    {
        $xml = $this->pdepend_bridge->generateXMLReport($this->dir);
        $packages = $xml->package;
        
        $classes_metric = [];

        foreach ($packages as $package) {
            $classes = $package->class;
            
            foreach ($classes as $class) {
                $class_metric = $this->analyseClass($class);
                $classes_metric[$class_metric->getName()] = $class_metric;
            }
        }
        
        return $classes_metric;
    }

    private function analyseClass(\SimpleXMLElement $class)
    {
        $attributes = $class->attributes();
        $class_name = (string) $attributes["fqname"];

        $class_metric = new ClassMetric();
        $class_metric->setName($class_name);
        $class_metric->setCe((int) $attributes["ce"]);
        $class_metric->setDit((int) $attributes["dit"]);
        $class_metric->setNom((int) $attributes["nom"]);

        $methods = $class->method;

        /** @var \SimpleXMLElement $method */
        foreach ($methods as $method) {
            $method_metric = $this->analyseMethod($method);
            $class_metric->addMethod($method_metric);
        }

        return $class_metric;
    }

    private function analyseMethod(\SimpleXMLElement $method)
    {
        $attributes = $method->attributes();
        $method_name = (string) $attributes["name"];

        $method_metric = new MethodMetric();
        $method_metric->setName($method_name);
        $method_metric->setCcn((int) $attributes["ccn"]);
        $method_metric->setLoc((int) $attributes["loc"]);

        return $method_metric;
    }
}