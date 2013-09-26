<?php

namespace Msi\StoreBundle\Admin;

use Msi\AdminBundle\Admin\Admin;
use Msi\AdminBundle\Grid\GridBuilder;
use Symfony\Component\Form\FormBuilder;

class AddressAdmin extends Admin
{
    public function buildGrid(GridBuilder $builder)
    {
        $builder
            ->add('name')
            ->add('', 'action')
        ;
    }

    public function buildForm(FormBuilder $builder)
    {
        $builder
            ->add('name')
        ;
    }
}
