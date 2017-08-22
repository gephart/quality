<?php

namespace Gephart\Quality\Bridge;

use Gephart\Quality\Entity\ClassMetric;
use Gephart\Quality\Entity\MethodMetric;
use PDepend\Application;
use PDepend\Engine;

final class PDependBridge
{

    /**
     * @var string
     */
    private $cache_dir = "";

    public function __construct()
    {
        $this->cache_dir = sys_get_temp_dir();
    }

    /**
     * @param string $dir
     * @return ClassMetric[]
     */
    public function analyse(string $dir): array
    {
        $xml = $this->generateXMLReport($dir);
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

    /**
     * @param string $dir
     * @return \SimpleXMLElement
     */
    private function generateXMLReport(string $dir): \SimpleXMLElement
    {
        $this->turnOffErrorDisplaying();

        $file = $this->cache_dir . "/gephart-quality-".microtime(true).".xml";

        $app = new Application();
        $generator = $app
            ->getReportGeneratorFactory()
            ->createGenerator("summary-xml", $file);

        /** @var Engine $engine */
        $engine = $app->getEngine();
        $engine->addDirectory($dir);
        $engine->addReportGenerator($generator);
        $engine->analyze();

        return simplexml_load_file($file);
    }

    /**
     * @param \SimpleXMLElement $class
     * @return ClassMetric
     */
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

        foreach ($methods as $method) {
            $method_metric = $this->analyseMethod($method);
            $class_metric->addMethod($method_metric);
        }

        return $class_metric;
    }

    /**
     * @param \SimpleXMLElement $method
     * @return MethodMetric
     */
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

    private function turnOffErrorDisplaying()
    {
        error_reporting(0);
        ini_set("display_errors",0);
        set_error_handler(function(){});
        set_exception_handler(function(){});
    }
}