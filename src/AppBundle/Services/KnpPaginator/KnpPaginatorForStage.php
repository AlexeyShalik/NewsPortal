<?php

namespace AppBundle\Services\KnpPaginator;

use Symfony\Component\DependencyInjection\Container;

class KnpPaginatorForStage
{
    private $container;
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function knpPaginatorForHomePage($listArticles, $request)
    {
        $paginator  = $this->container->get('knp_paginator');
        $content = $paginator->paginate(
            $listArticles,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 5)
        );

        return $content;
    }

    public function knpPaginatorForAdminPage($listArticles, $request)
    {
        $paginator  = $this->container->get('knp_paginator');
        $content = $paginator->paginate(
            $listArticles,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 15)
        );

        return $content;
    }

//Made to demonstrate pagination on the category page
    public function knpPaginatorForCategory($listArticles, $request)
    {
        $paginator  = $this->container->get('knp_paginator');
        $content = $paginator->paginate(
            $listArticles,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 5)
        );

        return $content;
    }
}
