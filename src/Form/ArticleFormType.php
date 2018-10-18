<?php
namespace App\Form;

use App\Entity\Author;
use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ArticleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('category', ChoiceType::class, array(
                'choices'  => array(
                    'Обзор' => Article::CATEGORY_OVERVIEW,
                    'Объявление' => Article::CATEGORY_ANNOUNCEMENT,
                    'Статья' => Article::CATEGORY_ARTICLE
                ),
                'label' => 'Категория'
            ))
            ->add(
                'author',
                EntityType::class,
                [
                    'class' => Author::class,
                    'choice_label' => 'name',
                    'label' => 'Автор'
                ]
            )
            ->add('name', TextType::class, array('label' => 'Название'))
            ->add('description', TextareaType::class, array('label' => 'Текст'))
            ->add('save', SubmitType::class, array('label' => 'Сохранить'))
        ;
    }
}
