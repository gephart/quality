<?php

namespace Gephart\Quality\Bridge;

use PDepend\Application;
use PDepend\Engine;

final class PDependBridge
{

    /**
     * @var string
     */
    private $cache_dir = "";

    public function __construct()
    {
        $this->cache_dir = sys_get_temp_dir();
    }

    /**
     * @param string $dir
     * @return \SimpleXMLElement
     */
    public function generateXMLReport(string $dir): \SimpleXMLElement
    {
        $file = $this->cache_dir . "/gephart-quality.xml";

        $app = new Application();
        $generator = $app
            ->getReportGeneratorFactory()
            ->createGenerator("summary-xml", $file);

        /** @var Engine $engine */
        $engine = $app->getEngine();
        $engine->addDirectory($dir);
        $engine->addReportGenerator($generator);
        $engine->analyze();

        return simplexml_load_file($file);
    }
}