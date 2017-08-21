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
        $this->assertTrue($class_name == \Gephart\Quality\Entity\ClassMetric::class);
    }

    public function testClassMetric()
    {
        $class_metric = $this->classes[\Gephart\Quality\Entity\ClassMetric::class];

        $this->assertEquals($class_metric->getDit(), 1);
        $this->assertEquals($class_metric->getCe(), 1);
        $this->assertEquals($class_metric->getNom(), 10);
        $this->assertEquals(count($class_metric->getMethods()), 10);
        $this->assertEquals($class_metric->getName(), \Gephart\Quality\Entity\ClassMetric::class);
    }

}
