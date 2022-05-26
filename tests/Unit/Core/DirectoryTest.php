<?php

namespace BookAlps\Tests\Unit\Core;

use BookAlps\Core\Directory;
use BookAlps\Tests\TestKernel;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use PHPUnit\Util\Filesystem;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DirectoryTest extends TestKernel
{

    private $directory;

    protected function setUp() : void
    {
        parent::setUp();
        $this->directory = $this->container->get('BookAlps\Core\Directory');

        mkdir($this->container->getParameter('kernel.project_dir').'/storage/testing');
    }

    /** @test */
    public function create_a_dir()
    {
        $directory = $this->directory->create('test ààDdd folder');
        $this->assertSame('test ààddd folder', $directory->getRelativePath());
    }

    /** @test */
    public function rename_a_exists_dir()
    {
        $directory = $this->directory->create('oldFolder');

        $directory = $this->directory->rename('oldFolder', 'new testtest');
        $this->assertSame('new testtest', $directory->getRelativePath());
    }

    /** @test */
    public function delete_a_exists_dir()
    {
        $directory = $this->directory->create('oldFolder');

        $directory = $this->directory->delete('oldFolder');
        $this->assertSame(true, $directory);


        $this->expectExceptionMessage('Directory doesn`t exists');
        $this->directory->delete('oldFolder123');
    }



    protected function tearDown(): void
    {
        rmdir($this->container->getParameter('kernel.project_dir').'/storage/testing');
    }


}