<?php

require_once __DIR__ . '/../vendor/autoload.php';


class CheckerTest extends \PHPUnit\Framework\TestCase
{

    /** @var \Gephart\Quality\Checker */
    private $checker;

    public function setUp()
    {
        $this->checker = new Gephart\Quality\Checker();
        $this->checker->setDir(__DIR__ . "/../src");
    }

    public function testAnalyse()
    {
        $classes = $this->checker->analyse();

        $this->assertNotEmpty($classes);
        $this->assertTrue(get_class($classes[0]) == \Gephart\Quality\Entity\ClassMetric::class);
    }

}
