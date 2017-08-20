<?php

namespace Gephart\Quality\Entity;

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