<?php

declare(strict_types = 1);

namespace Example\Controller;

use Example\Model\ExampleModel;
use Example\View\ExampleView;
use Example\Model\Example;
use Mini\Controller\Controller;
use Mini\Controller\Exception\BadInputException;
use Mini\Http\Request;

/**
 * Example entrypoint logic.
 */
class ExampleController extends Controller
{
    /**
     * Example view model.
     * 
     * @var Example\Model\ExampleModel|null
     */
    protected $model = null;

    /**
     * Example view builder.
     * 
     * @var Example\View\ExampleView|null
     */
    protected $view = null;

    /**
     * Setup.
     * 
     * @param ExampleModel $model example data
     * @param ExampleView  $view  example view builder
     */
    public function __construct(ExampleModel $model, ExampleView $view)
    {
        $this->model = $model;
        $this->view  = $view;
    }

    /**
     * Create an example and display its data.
     * 
     * @param Request $request http request
     * 
     * @return string view template
     */
    public function createExample(Request $request): string
    {
        if (! $code = $request->request->get('code')){
            throw new BadInputException('Example code missing');
        }

        if (! $description = $request->request->get('description')) {
            throw new BadInputException('Example description missing');
        }

        $id = $this->model->create(now(), $code, $description); //Creates entry into DB and returns id

        $example = new Example($id, now(), $code, $description);

        return $this->view->get(
            $example
        );
    }

    public function get(Request $request): string {
        $id = (int) $request->get('id');
        return $this->view->getTest($id);
    }

    public function set(Request $request): string {
        $id = (int) $request->request->get('id');
        $code = (string) $request->request->get('code');
        $description = (string) $request->request->get('description');
        $old_example_model = $this->model->get($id);

        return $this->view->set($id, $code, $description, $old_example_model);
    }

    public function add(Request $request): string
    {            
        //Checks if input is integer/string integer
        if(!is_numeric($first_number = $request->request->get('first-number'))) { 
            throw new BadInputException('Value is not a integer');
        }

        if(!is_numeric($second_number = $request->request->get('second-number'))) {
            throw new BadInputException('Value is not a integer');
        }

        $sum = $first_number + $second_number;
        return (string) $sum;
    }

    
}
