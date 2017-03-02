<?php

namespace AppBundle\Services\DQL;

class DqlForCategoryMenu
{
    private $dql;

    public function getDqlForMenu()
    {
        $this->dql = "SELECT category FROM AppBundle:Category category";
        return $this->dql;
    }
}
