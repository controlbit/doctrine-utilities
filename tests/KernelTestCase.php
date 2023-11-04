<?php
declare(strict_types=1);

namespace ControlBit\DoctrineUtils\Tests;

use ControlBit\DoctrineUtils\Tests\Resources\App\DoctrineUtilsTestKernel;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class KernelTestCase extends WebTestCase
{
    protected static function getKernelClass(): string
    {
        return DoctrineUtilsTestKernel::class;
    }

}