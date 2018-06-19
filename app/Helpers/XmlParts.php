<?php

namespace App\Helpers;


class XmlParts
{
    /**
     * @var \XMLReader
     */
    private $reader;

    /**
     * @var int Number of chunks we need to split the xml file
     */
    private $chunks;

    /**
     * @var string Name of node we need to split
     */
    private $splitNode;

    /**
     * @var \DOMDocument
     */
    private $domXml;

    /**
     * @var int Size of xml file
     */
    private $size;

    /**
     * Tree till split node;
     *
     * @var array
     */
    private $tree;

    /**
     * @var array Successfully saved parts
     */
    private $parts = [];

    /**
     * XmlParts constructor.
     * @param string $path
     * @param string $splitNode
     * @param int $chunks
     */
    public function __construct(string $path, string $splitNode, $chunks = 10)
    {
        if (!file_exists($path) || !\is_file($path)) {
            throw new \RuntimeException("File doesn't exist: '$path'");
        }

        if (!$splitNode) {
            throw new \RuntimeException("The second parameter \$splitNode wasn't passed.");
        }

        $reader = new \XMLReader();
        $reader->open($path,'utf-8', LIBXML_BIGLINES | LIBXML_PARSEHUGE);

        $this->reader = $reader;
        $this->chunks = $chunks;
        $this->splitNode = $splitNode;

        $this->domXml = new \DOMDocument();

        $this->size = filesize($path);
    }

    /**
     * @param int $chunks
     * @param string $destinationFolder
     * @return array
     */
    public function split($chunks = 10, string $destinationFolder): array
    {
        $chunkSize = $this->size / 10;

        while ($this->reader->read()) {
            $nodeName = $this->reader->name;

            if ($nodeName === $this->splitNode) {
                $inner = trim(@$this->reader->readInnerXml());
            }
        }
    }

    /**
     * Save DOMDocument
     *
     * @param string $path
     * @return mixed
     */
    private function save(string $path)
    {
        return $this->domXml->save($path);
    }
}