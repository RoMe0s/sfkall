<?php
namespace AdminBundle\Services;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
/**
 * Created by PhpStorm.
 * User: rome0s
 * Date: 2/9/17
 * Time: 1:23 PM
 */
class TablesBuilder
{
    /**
     * @var null
     */
    private $list = [];

    private $fields = [];

    private $edited = [];

    private $added = [];

    protected $templating;

    /**
     * TablesBuilder constructor.
     * @param ContainerInterface $container
     */
    function __construct(EngineInterface $templating)
    {
        $this->templating = $templating;

        return $this;
    }

    public function of($list) {
        
        $this->list = $list;

        $this->fields = array_keys(array_pop($list));

        return $this;

    }

    public function edit($field, $content) {

        $this->edited[$field] = $content;

        return $this;
    }

    public function add($field, $content) {

        $this->fields[] = $field;

        $this->added[$field] = $content;

        return $this;

    }

    public function make() {

        foreach ($this->list as $key => $item) {

            $this->list[$key] = $this->_refactor($item);

        }

        return $this->templating->render('@AdminBundle/Resources/views/datatables/list.html.twig', array('list' => $this->list, 'fields' => $this->fields));

    }

    private function _refactor($item) {

        foreach ($this->edited as $field => $content) {

            if(is_callable($content)) {

                $item[$field] = $content($item);

            } else {

                $item[$field] = $content;

            }

        }

        foreach ($this->added as $field => $content) {

            if(is_callable($content)) {

                $item[$field] = $content($item);

            } else {

                $item[$field] = $content;

            }

        }

        return $item;
    }

    private function _add($item) {

        return $item;
    }

}