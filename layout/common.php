<?php

parse_str(implode('&', array_slice($argv, 1)), $_GET);

require_once "vendor/spyc/Spyc.php";
require_once "vendor/parsedown/Parsedown.php";

class FrontmatterParser
{
    private $markdown;
    private $metadata;

    public function __construct($markdown)
    {
        $this->markdown = $markdown;
        $this->metadata = array();
        $this->parseMetadata();
    }

    public function GetMetadata()
    {
        return $this->metadata;
    }

    public function GetMarkdown()
    {
        return $this->markdown;
    }

    private function parseMetadata()
    {
        $metadata = array();
        preg_match('/^---(.*?)---(.*)/s', $this->markdown, $matches);
        if (count($matches) >= 3) {
            $metadata = Spyc::YAMLLoadString($matches[1]);
            $this->markdown = trim($matches[2]);
        }
        $this->metadata = $metadata;
    }
}
