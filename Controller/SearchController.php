<?php

namespace Msi\StoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SearchController extends Controller
{
    public function indexAction()
    {
        $parameters['typeahead'] = $this->getTypeaheadStuff();

        return $this->render('MsiStoreBundle:Search:index.html.twig', $parameters);
    }

    private function getTypeaheadStuff()
    {
        $rows = $this->get('msi_store.product_manager')->getMasterQueryBuilder(
            [
                'translations.published' => true,
                'translations.locale' => $this->getRequest()->getLocale(),
            ],
            [
                'a.translations' => 'translations',
            ]
        )->getQuery()->getArrayResult();
        foreach ($rows as $row) {
            $temp[strtolower($row['translations'][0]['name'])] = null;
        }

        // Association array (json) is not good for typeahead so we make a normal js array.
        foreach ($temp as $k => $value) {
            $parameters['typeahead'][] = ucfirst($k);
        }
        sort($parameters['typeahead']);

        return json_encode($parameters['typeahead']);
    }
}
