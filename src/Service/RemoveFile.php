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

    public function deleteFile(?string $file)
    {

        // $this->fileSystem = new Filesystem();

        // $projectDir = $this->getParameter('kernel.project_dir');

        // $this->fileSystem->remove($projectDir.'/public/uploads/avatars/'.$file);

        // Attention : j'ai déclaré le service RemoveFile dans services.yaml (où le path est défini : '%avatars_directory%')
        // $this->fileSystem->remove($this->path.'/'.$file);


        if (is_file($this->path.'/'.$file)) {

            $this->fileSystem->remove($this->path.'/'.$file);

        }

    }

}
