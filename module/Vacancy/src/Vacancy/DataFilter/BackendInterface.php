<?php

namespace Vacancy\DataFilter;

interface BackendInterface {

    /**
     * Data filtering magic
     *
     * @param Filter $filter
     *
     * @return mixed
     */
    public function filter(Filter $filter);

} 