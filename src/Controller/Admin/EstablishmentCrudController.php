<?php

namespace App\Controller\Admin;

use App\Entity\Establishment;
use App\Repository\UserRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EstablishmentCrudController extends AbstractCrudController
{
    private UserRepository $users;

    public function __construct(UserRepository $userRepository)
    {
        $this->users = $userRepository;
    }

    public static function getEntityFqcn(): string
    {
        return Establishment::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom'),
            TextField::new('ville'),
            TextField::new('adresse'),
            TextEditorField::new('description'),
            TextField::new('page_web')->hideOnIndex(),
            TextField::new('slug')->hideOnForm(),
            TextField::new('image')->hideOnIndex(),
            AssociationField::new('user')
                ->setFormTypeOptions([
                    'query_builder' => function (UserRepository $userRepository) {
                        return $userRepository->getUserManager();
                    },
                ])->setLabel('Manager'),
        ];
    }
}
