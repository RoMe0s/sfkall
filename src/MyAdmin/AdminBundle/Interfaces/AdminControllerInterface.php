<?php
/**
 * Created by PhpStorm.
 * User: rome0s
 * Date: 25.03.17
 * Time: 21:45
 */

namespace MyAdmin\AdminBundle\Interfaces;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface AdminControllerInterface
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function indexAction(Request $request);

    /**
     * @param int $id
     * @param Request $request
     * @return mixed
     */
    public function editAction(int $id, Request $request);

    /**
     * @param Request $request
     * @return mixed
     */
    public function createAction(Request $request);

    /**
     * @param int $id
     * @return mixed
     */
    public function deleteAction(int $id);

    /**
     * @param Request $request
     * @param $model
     * @param array $data
     * @return mixed
     */
    public function _callSaver(Request $request, $model, array $data = array());

    /**
     * @param Form $form
     * @param Request $request
     * @param $model
     * @return mixed
     */
    public function handleSaveRequest(Form $form, Request $request, $model);

    /*
    ------------------------------------------
        START SYSTEM PART (DON'T REMOVE IT!) //SEE AdminControllerTrait
    ------------------------------------------
     */

    /**
     * @param string $key
     * @param $value
     * @return mixed
     */
    public function passData(string $key, $value);

    /**
     * @param string $view
     * @param array $parameters
     * @param Response|null $response
     * @return mixed
     */
    public function render($view, array $parameters = array(), Response $response = null);


    /*
    ------------------------------------------
        END SYSTEM PART (DON'T REMOVE IT!) //SEE AdminControllerTrait
    ------------------------------------------
     */

}