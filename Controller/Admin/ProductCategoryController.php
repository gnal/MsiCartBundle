<?php

namespace Msi\StoreBundle\Controller\Admin;

use Msi\AdminBundle\Controller\CoreController;
use Symfony\Component\HttpFoundation\Request;

class ProductCategoryController extends CoreController
{
    public function sortAction(Request $request)
    {
        $this->isGranted('update');
        $this->isGranted('ACL_UPDATE', $this->admin->getObject());

        $id = $request->query->get('id');
        $node = $this->admin->getObjectManager()->getFindByQueryBuilder(
            ['a.id' => $request->query->get('id')]
        )->getQuery()->getOneOrNullResult();

        foreach ($request->query->get('array1') as $k => $v) {
            if ($v == $id) {
                $start = $k;
            }
        }

        foreach ($request->query->get('array2') as $k => $v) {
            if ($v == $id) {
                $end = $k;
            }
        }

        $number = $start - $end;

        if ($number > 0) {
            $this->admin->getObjectManager()->moveUp($node, abs($number));
        } elseif ($number < 0) {
            $this->admin->getObjectManager()->moveDown($node, abs($number));
        }

        return $this->redirect($this->admin->genUrl('list'));
    }
}
