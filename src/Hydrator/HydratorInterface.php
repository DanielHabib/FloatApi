<?php

namespace FloatApi\Hydrator;

interface HydratorInterface
{
    /**
     * @param $data
     *
     * @return mixed
     */
    public function hydrate($data);
}
