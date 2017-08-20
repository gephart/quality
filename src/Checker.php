<?php

namespace Gephart\Quality;

use PDepend\Application;
use PDepend\Engine;

final class Checker
{
    /**
     * @var string
     */
    private $dir = "";

    /**
     * @var string
     */
    private $cache_dir = "";

    /**
     * @var array
     */
    private $method_metrics = [];

    /**
     * @var array
     */
    private $class_metrics = [];

    public function __construct()
    {
        $this->dir = realpath(__DIR__ . "/../../src");
        $this->cache_dir = sys_get_temp_dir();
        $this->method_metrics = ["ccn" => 15, "loc" => 20];
        $this->class_metrics = ["ce" => 50, "dit" => 6, "nom" => 20];
    }

    public function setDir(string $dir)
    {
        $this->dir = $dir;
    }

    public function setCacheDir(string $cache_dir)
    {
        $this->cache_dir = $cache_dir;
    }

    public function analyse()
    {
        $xml = $this->generateXMLReport();
        $packages = $xml->package;
        
        $classesMetric = [];

        foreach ($packages as $package) {
            $classes = $package->class;
            
            foreach ($classes as $class) {
                $classesMetric[] = $this->analyseClass($class);
            }
        }
        
        return $classesMetric;
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
        $method_name = (string) $attributes["fqname"];

        $method_metric = new MethodMetric();
        $method_metric->setName($method_name);
        $method_metric->setCcn((int) $attributes["ccn"]);
        $method_metric->setLoc((int) $attributes["loc"]);

        return $method_metric;
    }

    /**
     * @return \SimpleXMLElement
     */
    public function generateXMLReport()
    {
        $dir = $this->dir;
        $file = $this->cache_dir . "/gephart-quality.xml";

        $app = new Application();
        $generator = $app->getReportGeneratorFactory()->createGenerator("summary-xml", $file);

        /** @var Engine $engine */
        $engine = $app->getEngine();
        $engine->addDirectory($dir);
        $engine->addReportGenerator($generator);
        $engine->analyze();

        return simplexml_load_file($file);
    }
}