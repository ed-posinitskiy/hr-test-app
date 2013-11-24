<?php

namespace Vacancy\DataFilter;

interface HydratorInterface {

    /**
     * Hydration magic
     *
     * @param Filter $filter
     *
     * @return mixed
     */
    public function hydrate(Filter $filter);

} 