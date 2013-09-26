<?php

namespace Msi\StoreBundle\Doctrine;

use Msi\AdminBundle\Doctrine\Manager as BaseManager;

class CartManager extends BaseManager
{
    public function findCartByCookie($cookie)
    {
        $qb = $this->getFindByQueryBuilder(
            [
                'a.id' => $cookie,
            ],
            [
                'a.items' => 'i',
                'i.product' => 'p',
                'p.translations' => 'pt',
            ],
            ['pt.name' => 'ASC']
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
            ],
            [
                'a.items' => 'i',
                'i.product' => 'p',
                'p.translations' => 'pt',
            ],
            ['pt.name' => 'ASC']
        );

        $qb->andWhere($qb->expr()->isNull('a.frozenAt'));

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function collectGarbage()
    {
        $qb = $this->getFindByQueryBuilder();
        $qb->andWhere($qb->expr()->isNull('a.frozenAt'));
        $carts = $qb->getQuery()->execute();

        foreach ($carts as $cart) {
            if ($cart->getUpdatedAt()->getTimestamp() > time() - 86400) {
                continue;
            }
            $this->delete($cart);
        }
    }
}
