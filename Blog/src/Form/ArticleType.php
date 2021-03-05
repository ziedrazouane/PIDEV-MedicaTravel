<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Symfony\Component\Form\Extension\Core\Type\TextType;use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Titre',TextType::class, array('attr' => array('class' => 'form-control', 'required' => true)))
            ->add('Image', TextType::class,array('attr' => array('class' => 'form-control', 'required' => true)))
            ->add('Contenu',TextareaType::class,array('attr' => array('class' => 'form-control', 'required' => true)))
            ->add('Categorie',TextType::class, array('attr' => array('class' => 'form-control', 'required' => true)))
            ->add('Auteur',TextType::class, array('attr' => array('class' => 'form-control', 'required' => true)))
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
