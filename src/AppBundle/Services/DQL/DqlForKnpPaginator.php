<?php

namespace AppBundle\Services\DQL;

class DqlForKnpPaginator
{
    private $dql;

    public function getDql()
    {
        $this->dql = "SELECT news FROM AppBundle:Article news";
        return $this->dql;
    }
}
