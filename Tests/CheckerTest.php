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
        $class_metric = $this->classes[\Gephart\Quality\Bridge\PDependBridge::class];

        $this->assertEquals($class_metric->getName(), \Gephart\Quality\Bridge\PDependBridge::class);
        $this->assertEquals($class_metric->getDit(), 0);
        $this->assertEquals($class_metric->getCe(), 4);
        $this->assertEquals($class_metric->getNom(), 6);
        $this->assertEquals(count($class_metric->getMethods()), 6);
    }

    public function testMethodMetric()
    {
        $class_metric = $this->classes[\Gephart\Quality\Bridge\PDependBridge::class];
        $method_metric = $class_metric->getMethod("analyse");

        $this->assertEquals(get_class($method_metric), \Gephart\Quality\Entity\MethodMetric::class);

        $this->assertEquals($method_metric->getName(), "analyse");
        $this->assertEquals($method_metric->getCcn(), 4);
        $this->assertEquals($method_metric->getLoc(), 20);
    }

    public function testQuality()
    {
        $quality = $this->checker->getQuality();

        $this->assertNotEmpty($quality);

        $class_name = get_class(current($quality));
        $this->assertEquals($class_name, \Gephart\Quality\Entity\ClassQuality::class);

        foreach($quality as $class_quality) {
            $class_name = $class_quality->getClassName();
            $percent = $class_quality->getPercent();

            $expected = $class_name . " : 100";
            $given = $class_name . " : " . $percent;

            $this->assertEquals($expected, $given);
        }
    }

}
