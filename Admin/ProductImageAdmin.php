<?php

namespace Msi\StoreBundle\Admin;

use Msi\AdminBundle\Admin\Admin;
use Msi\AdminBundle\Grid\GridBuilder;
use Symfony\Component\Form\FormBuilder;

class ProductImageAdmin extends Admin
{
    public function buildGrid(GridBuilder $builder)
    {
        $builder
            ->add('filename', 'image')
            ->add('', 'action')
        ;
    }

    public function buildForm(FormBuilder $builder)
    {
        $builder
            ->add('filenameFile', 'file')
        ;
    }
}
