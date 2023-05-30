<?php

namespace App\Controller\Admin;

use App\Entity\Vehicule;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class VehiculeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Vehicule::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Véhicules')
            ->setEntityLabelInSingular('Véhicule')

            ->setPageTitle("index", "Blog - Administration des véhicules")
            ->setPaginatorPageSize(10);
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('modele'),
            TextField::new('marque'),
            TextField::new('plaque')
                ->hideOnIndex(),
            AssociationField::new('Ajoute_Par'),
            AssociationField::new('Ajoute_Par')
                ->onlyWhenUpdating()
                ->setFormTypeOption('disabled', 'disabled'),
        ];
    }
}
