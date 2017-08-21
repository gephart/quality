<?php

namespace Gephart\Quality\Entity;

final class Issue
{

    /** @var string */
    private $name;

    /** @var string */
    private $type;

    /** @var string */
    private $metric;

    /** @var int */
    private $expected;

    /** @var int */
    private $given;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getMetric(): string
    {
        return $this->metric;
    }

    /**
     * @param string $metric
     */
    public function setMetric(string $metric)
    {
        $this->metric = $metric;
    }

    /**
     * @return int
     */
    public function getExpected(): int
    {
        return $this->expected;
    }

    /**
     * @param int $expected
     */
    public function setExpected(int $expected)
    {
        $this->expected = $expected;
    }

    /**
     * @return int
     */
    public function getGiven(): int
    {
        return $this->given;
    }

    /**
     * @param int $given
     */
    public function setGiven(int $given)
    {
        $this->given = $given;
    }

}