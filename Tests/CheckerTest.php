<?php

require_once __DIR__ . '/../vendor/autoload.php';


class CheckerTest extends \PHPUnit\Framework\TestCase
{

    /** @var \Gephart\Quality\Checker */
    private $checker;

    /** @var array */
    private $classes;

    public function setUp()
    {
        $this->checker = new Gephart\Quality\Checker();
        $this->checker->setDir(__DIR__ . "/../src");

        $this->classes = $this->checker->analyse();
    }

    public function testAnalyse()
    {
        $this->assertNotEmpty($this->classes);

        $class_name = get_class(current($this->classes));
        $this->assertEquals($class_name, \Gephart\Quality\Entity\ClassMetric::class);
    }

    public function testClassMetric()
    {
        $class_metric = $this->classes[\Gephart\Quality\Entity\ClassMetric::class];

        $this->assertEquals($class_metric->getName(), \Gephart\Quality\Entity\ClassMetric::class);
        $this->assertEquals($class_metric->getDit(), 1);
        $this->assertEquals($class_metric->getCe(), 1);
        $this->assertEquals($class_metric->getNom(), 11);
        $this->assertEquals(count($class_metric->getMethods()), 11);
    }

    public function testMethodMetric()
    {
        $class_metric = $this->classes[\Gephart\Quality\Entity\ClassMetric::class];
        $method_metric = $class_metric->getMethod("getMethod");

        $this->assertEquals(get_class($method_metric), \Gephart\Quality\Entity\MethodMetric::class);

        $this->assertEquals($method_metric->getName(), "getMethod");
        $this->assertEquals($method_metric->getCcn(), 3);
        $this->assertEquals($method_metric->getLoc(), 9);
    }

}
