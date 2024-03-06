<?php

namespace App\Controller\Admin;

use App\Entity\Speaker;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class SpeakerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Speaker::class;
    }

   
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField:: new ('firstname'),
            TextField:: new ('lastname'),
            TextField:: new ('job'),
            TextField::new('company'),
            IntegerField::new('experience'),
            ImageField::new('image')
            ->setUploadedFileNamePattern('[randomhash].[extension]')
            ->setUploadDir('public/uploads/speakers')->setBasePath('uploads/speakers'),
        ];
    }
    
}
