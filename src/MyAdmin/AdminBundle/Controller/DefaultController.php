<?php

namespace MyAdmin\AdminBundle\Controller;

use MyAdmin\AdminBundle\Classes\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultController extends AbstractController
{

    public function deleteAction(int $id)
    {
        throw new NotFoundHttpException();
    }

    public function createAction(Request $request)
    {
        throw new NotFoundHttpException();
    }

    public function editAction(int $id, Request $request)
    {
        throw new NotFoundHttpException();
    }

}
