<?php

namespace Gephart\Quality;

use Gephart\Quality\Bridge\PDependBridge;
use Gephart\Quality\Entity\ClassMetric;
use Gephart\Quality\Entity\ClassQuality;
use Gephart\Quality\Entity\Issue;
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
        $this->method_metrics = ["ccn" => 15, "loc" => 25];
        $this->class_metrics = ["ce" => 50, "dit" => 6, "nom" => 20];
    }

    /**
     * @param string $dir
     */
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

    /**
     * @return ClassQuality[]
     */
    public function getQuality(): array
    {
        $quality = [];
        $class_metrics = $this->analyse();

        foreach ($class_metrics as $class_metric) {
            $quality[] = $this->getQualityOfClass($class_metric);
        }

        return $quality;
    }

    private function getQualityOfClass(ClassMetric $class_metric)
    {
        $class_quality = new ClassQuality();
        $class_quality->setClassName($class_metric->getName());

        $issues = $this->getIsseuesOfClass($class_metric);
        $class_quality->addIssues($issues);

        $methods_metric = $class_metric->getMethods();

        foreach ($methods_metric as $method_metric) {
            $issues = $this->getIssuesOfMethod($method_metric);
            $class_quality->addIssues($issues);
        }

        $quality = $this->calculateQuality($class_quality);
        $class_quality->setPercent($quality);

        return $class_quality;
    }

    private function getIsseuesOfClass(ClassMetric $class_metric)
    {
        $issues = [];

        foreach ($this->class_metrics as $metric => $limit) {
            $getter = "get".ucfirst($metric);
            $given_metric = $class_metric->$getter();
            $percent = ceil($given_metric/$limit * 100);

            if ($percent > 100) {
                $issue = new Issue();
                $issue->setName($class_metric->getName());
                $issue->setExpected($limit);
                $issue->setGiven($given_metric);
                $issue->setMetric($metric);
                $issue->setType("class");

                $issues[] = $issue;
            }
        }

        return $issues;
    }

    private function getIssuesOfMethod(MethodMetric $method_metric)
    {
        $issues = [];

        foreach ($this->method_metrics as $metric => $limit) {
            $getter = "get".ucfirst($metric);
            $given_metric = $method_metric->$getter();
            $percent = ceil($given_metric/$limit * 100);

            if ($percent > 100) {
                $issue = new Issue();
                $issue->setName($method_metric->getName());
                $issue->setExpected($limit);
                $issue->setGiven($given_metric);
                $issue->setMetric($metric);
                $issue->setPercent($percent);
                $issue->setType("method");

                $issues[] = $issue;
            }
        }

        return $issues;
    }

    private function calculateQuality(ClassQuality $class_quality)
    {
        $quality = 100;

        $issues = $class_quality->getIssues();

        foreach ($issues as $issue) {
            $percent = $issue->getPercent();
            $class_quality = 200 - $percent;
            if ($class_quality < $quality) {
                $quality = $class_quality;
            }
        }

        return $quality;
    }
}