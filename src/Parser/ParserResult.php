<?php
namespace Mastercity\Markdown\Parser;

class ParserResult
{
    public $issetImage = false;
    public $issetVideo = false;
    public $parseText;

    public function __toString()
    {
        return $this->parseText;
    }

}