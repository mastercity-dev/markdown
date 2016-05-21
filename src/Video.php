<?php

namespace Mastercity\Markdown;

class Video
{
    protected $url;

    protected $type = false;

    public function __construct($url)
    {
        $this->url = $url;
        $this->type = $this->type();
    }

    protected function type()
    {
        $types = array_keys($this->types());
        foreach ($types as $type) {
            $func = 'is' . ucfirst($type) . 'Url';
            if ($this->{$func}($this->url)) {
                return $type;
            }
        }

        return null;
    }

    protected function types()
    {
        return [
            'youtube' => 'https://www.youtube.com/embed/%s?autoplay=0',
            'vimeo' => '//player.vimeo.com/video/%s'
        ];
    }

    public function getEmbeddedUrl()
    {
        if (!$this->isValid()) {
            return '';
        }

        $types = $this->types();
        return sprintf($types[$this->type], $this->getID());
    }

    public function isValid()
    {
        return ($this->type !== null);
    }

    public function getID()
    {
        $func = 'get' . ucfirst($this->type) . 'ID';
        return $this->{$func}($this->url);
    }


    public function getYoutubeID($url)
    {
        $pattern = '/^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/';
        preg_match($pattern, $url, $matches);
        if (count($matches) && mb_strlen($matches[7]) == 11) {
            return $matches[7];
        }

        return null;
    }

    public function getVimeoID($url)
    {
        $pattern = '/(?:https?:\/\/)?(?:www\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|)(\d+)(?:$|\/|\?)/';
        preg_match($pattern, $url, $matches);
        if (count($matches)) {
            return $matches[3];
        }

        return null;
    }

    public function isYoutubeUrl()
    {
        return mb_strpos($this->url, 'youtu.be') !== FALSE || mb_strpos($this->url, 'youtube.com/watch') !== FALSE;
    }

    public function isVimeoUrl()
    {
        return mb_strpos($this->url, 'vimeo.com') !== FALSE;
    }


}