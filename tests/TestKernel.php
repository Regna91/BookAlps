<?php

namespace BookAlps\Tests;

use org\bovigo\vfs\vfsStream;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Config\Loader\LoaderInterface;

class TestKernel extends KernelTestCase
{

    protected $container;

    protected $dataStorage;

    protected function setUp() : void
    {
        static::bootKernel();

        $this->container = static::getContainer();

        //$this->dataStorage = vfsStream::setup('exampleDir');
        $this->dataStorage = vfsStream::setup('exampleDir');
    }

}