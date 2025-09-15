<?php

declare(strict_types=1);

namespace ControlBit\DoctrineUtils\Traits;

trait TimestampTrait
{
    use CreatableTimestampTrait;
    use UpdatableTimestampTrait;
}
