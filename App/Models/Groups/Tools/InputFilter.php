<?php

namespace App\Models\Groups\Tools;


class InputFilter
{

    /**
     * @param $string
     * @return string
     */
    public function clearStr($string)
    {
        return strip_tags(trim($string));
    }


    /**
     * @param $args
     * @return bool|int
     */
    public function idPrepare($args)
    {
        if (!empty($args)) {
            $rawId = $args[0];
            $id = $this->getCookedId($rawId);
            return $id;
        } else {
            return false;
        }
    }

    /**
     * @param $rawId
     * @return int Prepared id or false if cooking has failed.
     */
    private function getCookedId($rawId)
    {
        $rawId = trim($rawId);
        $startsWithId = strpos($rawId, 'id') === 0;
        if ($startsWithId) {
            $id = (int) substr($rawId, 2, strlen($rawId) - 1);
            return $id;
        } else {
            return false;
        }
    }
}
