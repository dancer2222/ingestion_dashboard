<?php

namespace Ingestion\LibraryThing\Xml;


interface ParserInterface
{
    public function parse(): void;

    public function getErrors(): array;
}