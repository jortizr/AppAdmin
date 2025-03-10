<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Post::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Publicación')
            ->setEntityLabelInPlural('Publicaciones')
            ->setSearchFields(['title', 'content'])
            ->setDefaultSort(['id' => 'DESC']);
    }

    //los campos se configuran y asocian con la base de datos 
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            AssociationField::new('category', 'Categoria'),
            AssociationField::new('user', 'Usuario'),
            TextField::new('title', 'Título'),
            TextField::new('slug', 'Slug'),
            TextEditorField::new('content', 'Contenido de la publicacion')->hideOnIndex(),
        ];
    }
    
}
