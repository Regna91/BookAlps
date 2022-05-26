<?php

namespace BookAlps\Core;

use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;

class Folder implements FolderInterface
{

    public const DATA_DIR = 'data';

    protected $projectDir;

    public function __construct(string $projectDir)
    {
        $this->projectDir = $projectDir;
    }

    public function createFolder($name) : Folder
    {
        /** @var Filesystem $fileystem */
        $fileystem = new Filesystem();

        $fileystem->mkdir(Path::normalize($this->projectDir.'/'.self::DATA_DIR.'/'.$name));

        try {
            $fileystem->mkdir(Path::normalize($this->projectDir.'/'.self::DATA_DIR.'/'.$name));
        }catch (IOExceptionInterface $exception) {
            echo "An error occurred while creating your directory at ".$exception->getPath();
        }

        return $this;
    }

    public function getRelativePath(): string
    {
        return 'data/test_folder';
    }

}