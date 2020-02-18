<?php

namespace MilesChou\Schemarkdown;

use Illuminate\Filesystem\Filesystem;
use Psr\Log\LoggerInterface;

class CodeWriter
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param Filesystem $filesystem
     * @param LoggerInterface $logger
     */
    public function __construct(Filesystem $filesystem, LoggerInterface $logger)
    {
        $this->filesystem = $filesystem;
        $this->logger = $logger;
    }

    /**
     * @param iterable $generator Array or callable which should return array like [filePath => code]
     * @param string $pathPrefix
     */
    public function generate(iterable $generator, $pathPrefix): void
    {
        foreach ($generator as $filePath => $code) {
            $this->logger->info("Write file '{$filePath}'");

            $this->writeCode($code, $filePath, $pathPrefix);
        }
    }

    /**
     * @param mixed $code
     * @param string $filePath
     * @param string $pathPrefix
     */
    private function writeCode($code, $filePath, $pathPrefix): void
    {
        $fullPath = $pathPrefix . '/' . $filePath;

        $dir = $this->filesystem->dirname($fullPath);

        if (!$this->filesystem->isDirectory($dir)) {
            $this->filesystem->makeDirectory($dir, 0755, true, true);
        }

        $this->filesystem->put($fullPath, $code);
    }
}
