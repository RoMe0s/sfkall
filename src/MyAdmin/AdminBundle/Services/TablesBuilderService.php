<?php
/**
 * Created by PhpStorm.
 * User: rome0s
 * Date: 2/9/17
 * Time: 1:23 PM
 */

namespace MyAdmin\AdminBundle\Services;

use MyAdmin\AdminBundle\Annotation\Driver\DefaultValueDriver;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class TablesBuilderService
{

    /**
     * @var array
     */
    private $list = [];

    /**
     * @var array
     */
    private $fields = ["actions"];

    /**
     * @var EngineInterface
     */
    protected $engine;

    /**
     * @var DefaultValueDriver
     */
    protected $driver;

    /**
     * @var array
     */
    public $actions = array('link' => true, 'edit' => true, 'delete' => true);

    /**
     * @var array
     */
    public $templates = array('status' => 'toggle', 'position' => 'input');

    /**
     * @var string
     */
    public $module = "";

    /**
     * TablesBuilderService constructor.
     * @param EngineInterface $engine
     * @param DefaultValueDriver $driver
     */
    function __construct(EngineInterface $engine, DefaultValueDriver $driver)
    {

        $this->engine = $engine;

        $this->driver = $driver;

    }


    /**
     * @param array $list
     * @param array $fields
     * @param string $module
     * @return $this
     */
    public function of(array $list, array $fields, string $module) {
        
        $this->list = $list;

        $this->fields = array_merge($fields, $this->fields);

        $this->module = $module;

        return $this;

    }


    /**
     * @param array $actions
     * @return $this
     */
    public function setActions(array $actions = array()) {

        $this->actions = $actions;

        if(!sizeof($actions)) {

            $key = array_search('actions', $this->fields);

            if($key) {

                unset($this->fields[$key]);

            }

        }

        return $this;

    }

    /**
     * @param array $templates
     * @return $this
     */
    public function setTemplates(array $templates = array()) {

        $this->templates = $templates;

        return $this;

    }

    /**
     * @return mixed
     */
    public function make() {

        foreach ($this->list as $key => $item) {

            $this->list[$key] = $this->_refactor($item);

        }

        return $this->engine->render('@AdminBundle/Resources/views/datatables/list.html.twig', array('list' => $this->list, 'fields' => $this->fields));

    }

    /**
     * @param $item
     * @return mixed
     */
    private function _refactor($item) {

        $this->driver->process($item, $this->fields);

        foreach($this->fields as $field) {

            if(key_exists($field, $this->templates)) {

                if(method_exists($item, "get" . ucfirst($field))) {

                    $item->{"set" . ucfirst($field)}($this->_loadTemplate($field, $item));


                } else {

                    $item->{$field} = $this->_loadTemplate($field, $item);

                }

            }

        }

        $item = $this->_processActions($item);

        return $item;
    }

    /**
     * @param $field
     * @param $item
     * @return string
     */
    private function _loadTemplate($field, $item) {

        $type = $this->templates[$field];

        return $this->engine->render('@AdminBundle/Resources/views/datatables/' . $type . '.html.twig', array(
            'item' => $item,
            'module' => $this->module,
            'value' => $item->{"get" . ucfirst($field)}()
        ));

    }

    private function _processActions($item) {

        if(sizeof($this->actions)) {

            $data = array('module' => $this->module, 'item' => $item);

            $data = array_merge($data, $this->actions);

            $item->actions = $this->engine->render('AdminBundle:datatables:controls.html.twig', $data);

        }

        return $item;

    }

}