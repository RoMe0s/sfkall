<?php
/**
 * Created by PhpStorm.
 * User: rome0s
 * Date: 13.03.17
 * Time: 16:09
 */

namespace MyAdmin\AdminBundle\Traits\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class RequestHandlerTrait
 * @package AdminBundle\Traits\Controller
 */
trait AdminControllerTrait
{

    /**
     * @param Form $form
     * @param Request $request
     * @param $model
     * @return mixed
     */
    public function handleSaveRequest(Form $form, Request $request, $model) {

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist($model);

            $em->flush();

            return $this->redirectToRoute($this->module . '.index');

        }

        $this->_fillSaveData();

        return $this->render( "{$this->_bundle}:".$this->module . ":edit.html.twig", array(
            'form' => $form->createView(),
            'module' => $this->module,
        ));

    }

    /**
     * @param $model
     * @param Request $request
     * @param array $data
     * @return mixed
     */
    public function _callSaver($model, Request $request, array $data = array()) {

        $formType = str_replace("Entity", "Form", get_class($model) . "Type");

        $form = $this->createForm($formType, $model, $data);

        return $this->handleSaveRequest($form,$request, $model);

    }


    public function _fillSaveData()
    {
        // TODO: Implement _fillSaveData() method.
    }

    public function _fillIndexData()
    {
        // TODO: Implement _fillIndexData() method.
    }

    /*
    ------------------------------------------
        START SYSTEM PART (DON'T REMOVE IT!) //SEE AdminControllerInterface
    ------------------------------------------
     */

    public function passData(string $key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * @param string $view
     * @param array $parameters
     * @param Response|null $response
     * @return Response
     */
    public function render($view, array $parameters = array(), Response $response = null)
    {

        $parameters += $this->data;

        return parent::render($view, $parameters, $response);

    }

    /*
    ------------------------------------------
        END SYSTEM PART (DON'T REMOVE IT!) //SEE AdminControllerInterface
    ------------------------------------------
     */

}