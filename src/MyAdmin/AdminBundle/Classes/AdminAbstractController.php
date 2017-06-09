<?php
/**
 * Created by PhpStorm.
 * User: rome0s
 * Date: 25.03.17
 * Time: 21:24
 */

namespace MyAdmin\AdminBundle\Classes;

use MyAdmin\AdminBundle\Interfaces\AdminControllerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class AdminAbstractController extends Controller implements AdminControllerInterface
{

    /**
     * @var string|null
     * Current Bundle Name
     */
    protected $_bundle = null;

    /**
     * @var string
     *  Entity Name
     */
    protected $module = "admin";

    /**
     * @var null|string
     */
    protected $entityName = null;

    /**
     * @var array
     */
    public $data = array();

    /**
     * AbstractController constructor.
     */
    function __construct()
    {

        preg_match('/-|\\\\(.*Bundle)\\\\|-/',  get_class($this), $match);

        $this->_bundle = array_pop($match);

        $this->entityName =  "MyAdmin\\$this->_bundle\\Entity\\" . ucfirst($this->module);

    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {

        $this->_fillIndexData($request);

        return $this->render("{$this->_bundle}:{$this->module}:index.html.twig");

    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function createAction(Request $request)
    {

        return $this->_callSaver($request, new $this->entityName);

    }

    /**
     * @param int $id
     * @param Request $request
     * @return mixed
     */
    public function editAction(int $id, Request $request)
    {

        $repository = $this->getDoctrine()->getRepository($this->entityName); //get repository

        $entity = $repository->{$repository->findMethod}($id);

        return $this->_callSaver($request, $entity);

    }

    /**
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(int $id)
    {

        $repository = $this->getDoctrine()->getRepository($this->entityName); //get repository

        $repository->remove($id);

        return $this->redirectToRoute($this->module . '.index');

    }

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

        return $this->render( "{$this->_bundle}:".$this->module . ":edit.html.twig", array(
            'form' => $form->createView(),
            'module' => $this->module,
        ));

    }

    /**
     * @param Request $request
     * @param $model
     * @param array $data
     * @return mixed
     */
    public function _callSaver(Request $request, $model, array $data = array()) {

        $data = array_merge($data, $this->_fillFormType($request, $model));

        $formType = str_replace("Entity", "Form", get_class($model) . "Type");

        $form = $this->createForm($formType, $model, $data);

        return $this->handleSaveRequest($form, $request, $model);

    }

    /**
     * @param Request $request
     * @param $model
     *
     * @return array
     */
    public function _fillFormType(Request $request, $model) {

        return array();

    }

    /**
     * @param Request $request
     */
    public function _fillIndexData(Request $request) {}

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
