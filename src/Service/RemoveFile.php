<?php

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;

class RemoveFile
{
    private $fileSystem;
    private $path;

    public function __construct(Filesystem $fileSystem, $path)
    {
        $this->fileSystem = $fileSystem;
        $this->path = $path;
    }

    public function deleteFile(?string $file): void
    {

        if (is_file($this->path.'/'.$file)) {

            $this->fileSystem->remove($this->path.'/'.$file);

        }

    }

}
