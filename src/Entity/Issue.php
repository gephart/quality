<?php

namespace Gephart\Quality\Entity;

/**
 * Entity of issue
 *
 * @package Gephart\Quality\Entity
 * @author Michal Katuščák <michal@katuscak.cz>
 * @since 0.4
 */
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

    /** @var int */
    private $percent;

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

    /**
     * @return int
     */
    public function getPercent(): int
    {
        return $this->percent;
    }

    /**
     * @param int $percent
     */
    public function setPercent(int $percent)
    {
        $this->percent = $percent;
    }

}