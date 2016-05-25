<?php

namespace FloatApi\Behavior\Transformer\Date;


trait TransformsUpdatedDate
{

    /**
     * @param $data
     * @param $date
     *
     * @return array
     */
    public function transformUpdatedDate($data, $date)
    {
        return $data['updated'] = $date;
    }
}
