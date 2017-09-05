<?php

namespace Gephart\Quality\Entity;

/**
 * Entity of method metrics
 *
 * @package Gephart\Quality\Entity
 * @author Michal Katuščák <michal@katuscak.cz>
 * @since 0.4
 */
final class MethodMetric extends MetricAbstract
{

    /** @var int */
    private $ccn;

    /**
     * @return int
     */
    public function getCcn(): int
    {
        return $this->ccn;
    }

    /**
     * @param int $ccn
     */
    public function setCcn(int $ccn)
    {
        $this->ccn = $ccn;
    }

}