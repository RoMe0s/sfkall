<?php

/**
 * Created by PhpStorm.
 * User: rome0s
 * Date: 6/11/17
 * Time: 9:01 PM
 */
namespace MyAdmin\AdminBundle\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{

    public function onKernelException(GetResponseForExceptionEvent $event) {

        $exception = $event->getException();

        $request = $event->getRequest();

        if($request->isXmlHttpRequest()) {

            $response = new JsonResponse(array('errors' => $exception->getMessage()));

            if ($exception instanceof HttpExceptionInterface) {

                $response->setStatusCode($exception->getStatusCode());

            } else {

                $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);

            }

            $event->setResponse($response);

        }

    }

}