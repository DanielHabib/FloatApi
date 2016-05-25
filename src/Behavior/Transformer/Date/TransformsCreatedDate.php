<?php

namespace FloatApi\Behavior\Transformer\Date;

trait TransformsCreatedDate
{

    /**
     * @param $data
     * @param $date
     *
     * @return array
     */
    public function transformCreatedDate($data, $date)
    {
        return $data['created'] = $date;
    }
}
