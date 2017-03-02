<?php

namespace AppBundle\Services\DQL;

class DqlForKnpPaginator
{
    private $dql;

    public function getDqlForArticles()
    {
        $this->dql = "SELECT news FROM AppBundle:Article news";
        return $this->dql;
    }

    public function getDqlForUsers()
    {
        $this->dql = "SELECT users FROM AppBundle:User users";
        return $this->dql;
    }
}
