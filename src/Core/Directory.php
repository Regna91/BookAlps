<?php

namespace BookAlps\Core;

use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\String\Slugger\AsciiSlugger;
use function Symfony\Component\String\u;

class Directory implements DirectoryInterface
{

    protected $dataStorage;
    protected $filesystem;

    protected $path;

    public function __construct(Filesystem $filesystem, string $dataStorage)
    {
        $this->dataStorage = $dataStorage;
        $this->filesystem = $filesystem;
    }


    public function create($name): Directory
    {
        $name = $this->getFullPath($name);


        try {
            $this->filesystem->mkdir($name);
        }catch (IOExceptionInterface $exception) {
            // TODO: logging
            throw new IOException("An error occurred while creating your directory at ".$exception->getMessage());
        }


        $this->path = $name;

        return $this;
    }


    public function rename($oldName, $newName): Directory
    {
        $oldName = $this->getFullPath($oldName);
        $newName = $this->getFullPath($newName);

        if(!$this->filesystem->exists($oldName)) throw new \Exception('Directory doesn`t exists');

        try {
            $this->filesystem->rename($oldName, $newName, true);
        }catch (IOExceptionInterface $exception) {
            // TODO: logging
            throw new IOException("An error occurred while renaming your directory - ".$exception->getMessage());
        }

        $this->path = $newName;

        return $this;
    }


    public function delete($name): bool
    {
        $name = $this->getFullPath($name);

        if(!$this->filesystem->exists($name)) throw new \Exception('Directory doesn`t exists');

        try {
            $this->filesystem->remove($name);
        }catch (IOExceptionInterface $exception) {
            // TODO: logging
            throw new IOException("directory couldn't be deleted - ".$exception->getMessage());
        }

        return true;

    }


    public function getRelativePath(): string
    {
        return Path::makeRelative($this->path, $this->dataStorage);
    }


    protected function lowerString(string $str): string
    {
        return u($str)->folded()->toString();
    }


    protected function createSlug(): string
    {
        $slugger = new AsciiSlugger();
        //return $slugger->slug($str,'_')->folded()->toString();
    }

    protected function getFullPath($dirName): string
    {
        $dirName = $this->lowerString($dirName);
        return Path::makeAbsolute($dirName, $this->dataStorage);
    }

}