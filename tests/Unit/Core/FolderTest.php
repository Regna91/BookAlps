<?php

namespace BookAlps\Tests\Unit\Core;

use BookAlps\Core\Folder;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FolderTest extends KernelTestCase
{

    private $folder;

    protected function setUp() : void
    {
        static::bootKernel();
        $this->folder = self::$kernel->getContainer()->get('BookAlps\Core\Folder');
    }


    public function test_create_a_folder()
    {
        $folder = $this->folder->createFolder('test_folder');
        $this->assertSame('data/test_folder', $folder->getRelativePath());
    }



}