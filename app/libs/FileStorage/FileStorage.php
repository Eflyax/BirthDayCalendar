<?php

namespace Libs;

use Nette\Http\FileUpload;


class FileStorage
{
    private $dir;

    public function save(FileUpload $file, $filename)
    {
        $file->move($this->dir . $filename);
    }

    public function setPath($url)
    {
        $this->dir .= $url;
    }
}