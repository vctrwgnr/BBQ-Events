<?php

// src/EventListener/ExceptionListener.php
namespace App\EventListener;

use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof ForeignKeyConstraintViolationException) {
            $response = new JsonResponse([
                'error' => 'Cannot delete this location because it is associated with events. Please remove the events first.',
            ], Response::HTTP_BAD_REQUEST);

            $event->setResponse($response);
        }
    }
}

