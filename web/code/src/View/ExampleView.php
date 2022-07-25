<?php

declare(strict_types = 1);

namespace Example\View;

use Example\Model\ExampleModel;
use Example\Model\Example;
use Mini\Controller\Exception\BadInputException;

/**
 * Example view builder.
 */
class ExampleView
{
    /**
     * Example data.
     * 
     * @var Example\Model\ExampleModel|null
     */
    protected $model = null;

    /**
     * Setup.
     * 
     * @param ExampleModel $model example data
     */
    public function __construct(ExampleModel $model)
    {
        $this->model = $model;
    }

    /**
     * Get the example view to display its data.
     * 
     * @param int $id example id
     * 
     * @return string view template
     *
     * @throws BadInputException if no example data is returned
     */
    public function get(Example $example): string
    {

        if($example) {
            //Example object initalized with data
            $data = $this->model->get($example->id);

            if (!$data) {
                throw new BadInputException('Unknown example ID');
            }

            return view('app/example/detail',  (array) $data);
        } else {
            //Example object null
            throw new BadInputException('Example Object is Null');
        }
        
    }

    public function getTest(int $id): string
    {
        $data = $this->model->get($id);

        if (!$data) {
            throw new BadInputException('Unknown example ID');
        }

        return view('app/example/detail', (array) $data);
    }

    public function set(int $id, string $code, string $description, Example $example): string 
    {
        $old_example_model = $example;
        print_r($old_example_model);

        $example = $this->model->set($id, $old_example_model->created, $code, $description, $example);

        $updated_example_model = $example;
        print_r($updated_example_model);

        $data = $this->model->get($id); //Retrieves Updated Example Model to display

        return view('app/example/detail', (array) $data);
        
    }
}
