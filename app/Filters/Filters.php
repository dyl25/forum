<?php

namespace App\Filters;

use Illuminate\Http\Request;

/**
 * Description of Filters
 *
 * @author admin
 */
abstract class Filters {

    protected $request, $builder;
    protected $filters = [];

    /**
     * Constructeur de ThreadFilters
     * 
     * @param Request $request
     */
    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function apply($builder) {

        $this->builder = $builder;

        foreach ($this->getFilters() as $filter) {
            if (method_exists($this, $filter)) {
                $this->$filter($this->request->$filter);
            }
        }

        return $this->builder;
    }

    public function getFilters() {
        return $this->request->only($this->filters);
    }

}
