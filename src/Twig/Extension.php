<?php


namespace Mastercity\Markdown\Twig;


use Mastercity\Markdown\Parser\Parser;

class Extension extends \Twig_Extension
{

    protected $parser;

    public function __construct(Parser $parser)
    {
        $this->parser = $parser;
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return "mastercity.markdown";
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('markdown', [$this, 'markdownFilter'], ['is_safe' => ['html']]),
            new \Twig_SimpleFilter('parsedown', [$this, 'markdownFilter'], ['is_safe' => ['html']])
        ];
    }

    public function markdownFilter($text)
    {
        return $this->parser->text($text);
    }
}