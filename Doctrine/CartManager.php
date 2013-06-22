<?php

namespace Msi\StoreBundle\Doctrine;

use Msi\CmfBundle\Doctrine\Manager as BaseManager;

class CartManager extends BaseManager
{
    public function findCartByCookie($cookie)
    {
        $qb = $this->getFindByQueryBuilder(
            [
                'a.id' => $cookie,
            ]
        );

        $qb->andWhere($qb->expr()->isNull('a.user'));
        $qb->andWhere($qb->expr()->isNull('a.frozenAt'));

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function findCartByUser($user)
    {
        $qb = $this->getFindByQueryBuilder(
            [
                'a.user' => $user,
            ]
        );

        $qb->andWhere($qb->expr()->isNull('a.frozenAt'));

        return $qb->getQuery()->getOneOrNullResult();
    }
}
