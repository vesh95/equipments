<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Illuminate\Support\MessageBag;
use Throwable;

class EquipmentUpdateException extends Exception
{
    public function __construct(MessageBag $messages, int $code = 0, ?Throwable $previous = null)
    {
        $this->messages = $messages;
        parent::__construct('Equipment update error', $code, $previous);
    }

    public function getErrors(): MessageBag
    {
        return $this->messages;
    }
}
