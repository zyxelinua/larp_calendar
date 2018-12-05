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
use Symfony\Component\Form\Extension\Core\Type\FileType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

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
            ->add('description', CKEditorType::class, array('label' => 'Текст'))
            ->add(
                'picture',
                FileType::class,
                [
                    'label' => 'Загрузить картинку',
                    'help' => 'Размер файла до 2М',
                    'required' => false
                ]
            )
            ->add(
                'save',
                SubmitType::class,
                [
                    'label' => 'Сохранить',
                    'attr' => array('class' => 'brand-bg text-light')
                ]
            );
    }
}
