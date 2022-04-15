<?php

namespace App\Controller\Admin;

use App\Entity\Suite;
use App\Repository\EstablishmentRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\NonUniqueResultException;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Filter\FilterInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SuiteCrudController extends AbstractCrudController
{
    private AuthenticationUtils $authenticationUtils;
    private UserRepository $userRepository;

    public function __construct(AuthenticationUtils $authenticationUtils, UserRepository $userRepository)
    {
        $this->authenticationUtils = $authenticationUtils;
        $this->userRepository = $userRepository;
    }

    public static function getEntityFqcn(): string
    {
        return Suite::class;
    }

    /**
     * @throws NonUniqueResultException
     */
    public function configureFields(string $pageName): iterable
    {
        $lastUsername = $this->authenticationUtils->getLastUsername();
        $manager = $this->userRepository->getUser($lastUsername);

        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('titre'),
            TextField::new('image')->onlyOnForms(),
            TextEditorField::new('description')->onlyOnForms(),
            NumberField::new('prix'),
            TextField::new('lien_booking')->onlyOnForms(),
            TextField::new('slug'),
            BooleanField::new('disponibilite'),
            AssociationField::new('establishment')
                ->setFormTypeOptions([
                    'query_builder' => function (EstablishmentRepository $establishmentRepository) use ($manager) {
                        return $establishmentRepository->getEstateManager($manager);
                    },
                ])->setLabel('Establishment'),
        ];
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('establishment'))
        ;
    }
}
