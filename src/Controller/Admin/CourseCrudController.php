<?php

namespace App\Controller\Admin;

use App\Entity\Video;
use App\Entity\Course;
use App\Form\VideoType;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CourseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Course::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            
            TextField::new('nom'),
            TextareaField::new('description')->onlyOnForms(),
            ChoiceField::new('language')->renderExpanded()->setChoices(
                ['french' => 'french',
                'English' => 'English',
                'Arabic ' => 'Arabic ',]),
            DateField::new('createdAt'),
            AssociationField::new('technology'),
            AssociationField::new('category'),
            ImageField::new('img')
            ->setBasePath('uploads/')
            ->setUploadDir('public/uploads')
            ->setUploadedFileNamePattern('[randomhash].[extension]')
            ->setRequired(false),
            TextField::new('houres'),
            ChoiceField::new('difficulte')->renderExpanded()->setChoices(
                ['Beginner' => 'Beginner',
                'Intermediate' => 'Intermediate',
                'Advanced ' => 'Advanced ',]),
            CollectionField::new('videos')->setEntryType(VideoType::class),
            IntegerField::new('views')->onlyOnIndex()

        ];
    }
    
}
