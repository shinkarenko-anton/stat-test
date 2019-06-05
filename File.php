<?php

class File
{
    /**
     * @var string
     */
    private $file;
    /**
     * @var int
     */
    private $size;
    /**
     * @var string
     */
    private $mimeType;

    /**
     * File constructor.
     *
     * @param string $file
     */
    public function __construct($file)
    {
        if (file_exists($file))
        {
            $this->file = $file;
            $this->size = filesize($this->file);
            $this->mimeType = getimagesize($this->file)['mime'];

            return $this;
        }

        return null;
    }

    /**
     * Render file from path
     *
     * @param bool $exit
     */
    public function printFile($exit = true)
    {
        $fp = fopen($this->file, 'rb');

        if ($this->size and $fp)
        {
            header('Content-Type: ' . $this->mimeType);
            header('Content-Length: ' . $this->size);
            fpassthru($fp);

            if ($exit) {
                exit;
            }
        }
    }
}
