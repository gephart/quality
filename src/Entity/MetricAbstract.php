<?php

namespace Gephart\Quality\Entity;

/**
 * Abstract entity of metrics
 *
 * @package Gephart\Quality\Entity
 * @author Michal Katuščák <michal@katuscak.cz>
 * @since 0.4
 */
abstract class MetricAbstract
{

    /** @var string */
    private $name;

    /** @var int */
    private $loc;

    /** @var int */
    private $cloc;

    /** @var int */
    private $eloc;

    /** @var int */
    private $lloc;

    /** @var int */
    private $ncloc;

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
     * @return int
     */
    public function getLoc(): int
    {
        return $this->loc;
    }

    /**
     * @param int $loc
     */
    public function setLoc(int $loc)
    {
        $this->loc = $loc;
    }

    /**
     * @return int
     */
    public function getCloc(): int
    {
        return $this->cloc;
    }

    /**
     * @param int $cloc
     */
    public function setCloc(int $cloc)
    {
        $this->cloc = $cloc;
    }

    /**
     * @return int
     */
    public function getEloc(): int
    {
        return $this->eloc;
    }

    /**
     * @param int $eloc
     */
    public function setEloc(int $eloc)
    {
        $this->eloc = $eloc;
    }

    /**
     * @return int
     */
    public function getLloc(): int
    {
        return $this->lloc;
    }

    /**
     * @param int $lloc
     */
    public function setLloc(int $lloc)
    {
        $this->lloc = $lloc;
    }

    /**
     * @return int
     */
    public function getNcloc(): int
    {
        return $this->ncloc;
    }

    /**
     * @param int $ncloc
     */
    public function setNcloc(int $ncloc)
    {
        $this->ncloc = $ncloc;
    }
}
