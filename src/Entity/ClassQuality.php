<?php

namespace Gephart\Quality\Entity;

final class ClassQuality
{

    /** @var int */
    private $percent;

    /** @var string */
    private $class_name;

    /** @var Issue[] */
    private $issues = [];

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

    /**
     * @return string
     */
    public function getClassName(): string
    {
        return $this->class_name;
    }

    /**
     * @param string $class_name
     */
    public function setClassName(string $class_name)
    {
        $this->class_name = $class_name;
    }

    /**
     * @return Issue[]
     */
    public function getIssues(): array
    {
        return $this->issues;
    }

    /**
     * @param Issue[] $issues
     */
    public function setIssues(array $issues)
    {
        $this->issues = $issues;
    }

    /**
     * @param Issue $issue
     */
    public function addIssue(Issue $issue)
    {
        $this->issues[] = $issue;
    }

    /**
     * @param Issue[] $issues
     */
    public function addIssues(array $issues)
    {
        $this->issues = array_merge($this->issues, $issues);
    }

}