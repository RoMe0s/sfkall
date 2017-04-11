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
use Symfony\Component\HttpFoundation\Request;
use MyAdmin\AdminBundle\Traits\Controller\AdminControllerTrait;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractController extends Controller implements AdminControllerInterface
{

    use AdminControllerTrait;

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

        $this->_fillIndexData();

        return $this->render("{$this->_bundle}:{$this->module}:index.html.twig");

    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function createAction(Request $request)
    {

        return $this->_callSaver(new $this->entityName, $request);

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
     * @param int $id
     * @param Request $request
     * @return mixed
     */
    public function editAction(int $id, Request $request)
    {

        $repository = $this->getDoctrine()->getRepository($this->entityName); //get repository

        $entity = $repository->find($id);

        return $this->_callSaver($entity, $request);

    }

}