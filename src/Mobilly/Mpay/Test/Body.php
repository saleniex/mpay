<?php

namespace Mobilly\Mpay\Test;


use Psr\Http\Message\StreamInterface;

class Body implements StreamInterface
{

    private $content;

    /**
     * @param mixed $content
     * @return Body
     */
    public function __construct($content)
    {
        $this->content = $content;
    }


    public function __toString()
    {
    }

    public function close()
    {
    }

    public function detach()
    {
    }

    public function getSize()
    {
    }

    public function tell()
    {
    }

    public function eof()
    {
    }

    public function isSeekable()
    {
    }

    public function seek($offset, $whence = SEEK_SET)
    {
    }

    public function rewind()
    {
    }

    public function isWritable()
    {
    }

    public function write($string)
    {
    }

    public function isReadable()
    {
    }

    public function read($length)
    {
    }

    /**
     * Returns the remaining contents in a string
     *
     * @return string
     * @throws \RuntimeException if unable to read or an error occurs while
     *     reading.
     */
    public function getContents()
    {
        return $this->content;
    }


    public function getMetadata($key = null)
    {
    }
}