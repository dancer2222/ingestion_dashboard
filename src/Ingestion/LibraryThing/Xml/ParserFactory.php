<?php

namespace Ingestion\LibraryThing\Xml;


use Psr\Log\LoggerInterface;

/**
 * Class ParserFactory
 * @package App\Helpers\Ingestion\LibraryThing\Xml
 */
class ParserFactory
{
    /**
     * Mapping of allowed xml files and their parsers
     */
    const PARSERS = [
        'works_to_isbn_current.xml' => ParseWorkToIsbn::class,
        'worktotags_current.xml' => ParseWorkToTags::class,
        'worktoratings_current.xml' => ParseWorkToRatings::class,
    ];

    /**
     * Creates instances of ParserInterface
     *
     * @param string $filepath
     * @param LoggerInterface $logger
     * @return ParserInterface
     * @throws \Exception
     */
    public static function make(string $filepath, LoggerInterface $logger): ParserInterface
    {
        foreach (self::PARSERS as $filename => $className) {
            if (str_contains($filepath, $filename)) {
                return new $className($filepath, $logger);
            }
        }

        throw new \RuntimeException("File: $filepath can't be parsed.");
    }
}