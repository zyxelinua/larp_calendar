<?php
namespace App\Form;

use App\Entity\Event;
use App\Repository\EventTypeRepository;
use App\Repository\RegionRepository;
use App\Repository\SettlementRepository;
use App\Repository\SubgenreRepository;
use App\Repository\GenreRepository;
use App\Repository\WeaponRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\EventType;
use App\Entity\Genre;
use App\Entity\Subgenre;
use App\Entity\Region;
use App\Entity\Settlement;
use App\Entity\Weapon;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventSearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add(
                'periodStart',
                DateType::class,
                [
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd',
                    'label' => 'с',
                    'data' => new \DateTime(date('Y-m-d')),
                    'required' => false,
                ]
            )
            ->add(
                'periodEnd',
                DateType::class,
                [
                    'widget' => 'single_text',
                    'label' => 'по',
                    'data' => new \DateTime(date('Y-m-d', strtotime('+1 year'))),
                    'required' => false
                ]
            )
            ->add(
                'type',
                EntityType::class,
                [
                    'class' => EventType::class,
                    'choice_label' => 'name',
                    "multiple" => true,
                    "expanded" =>true,
                    'label' => 'Формат',
                    'required' => false,
                    'query_builder' => function (EventTypeRepository $repository) {
                        return $repository->createFormQueryBuilder();
                    },
                ]
            )
            ->add(
                'region',
                EntityType::class,
                [
                    'class' => Region::class,
                    'choice_label' => 'name',
                    'label' => 'Область',
                    'required' => false,
                    "multiple" => true,
                    'query_builder' => function (RegionRepository $repository) {
                        return $repository->createFormQueryBuilder();
                    },
                ]
            )
            ->add(
                'genre',
                EntityType::class,
                [
                    'class' => Genre::class,
                    'choice_label' => 'name',
                    'label' => 'Жанр',
                    'required' => false,
                    "multiple" => true,
                    "expanded" =>true,
                    'query_builder' => function (GenreRepository $repository) {
                        return $repository->createFormQueryBuilder();
                    },
                ]
            )
            ->add(
                'subgenre',
                EntityType::class,
                [
                    'class' => Subgenre::class,
                    'choice_label' => 'name',
                    'required' => false,
                    'label' => 'Поджанр',
                    'placeholder' => false,
                    "multiple" => true,
                    'query_builder' => function (SubgenreRepository $repository) {
                        return $repository->createFormQueryBuilder();
                    },
                ]
            )
            ->add(
                'settlement',
                EntityType::class,
                [
                    'class' => Settlement::class,
                    'choice_label' => 'name',
                    'label' => 'Тип поселения',
                    'required' => false,
                    "multiple" => true,
                    'expanded' => true,
                    'query_builder' => function (SettlementRepository $repository) {
                        return $repository->createFormQueryBuilder();
                    },
                ]
            )
            ->add(
                'weapons',
                EntityType::class,
                [
                    'class' => Weapon::class,
                    'choice_label' => 'name',
                    'multiple' => true,
                    'expanded' => true,
                    'label' => 'Тип оружия',
                    'required' => false,
                    'query_builder' => function (WeaponRepository $repository) {
                        return $repository->createFormQueryBuilder();
                    },

                ]
            )
            ->add(
                'priceMax',
                IntegerType::class,
                [
                    'label' => 'Размер денежного взноса до (грн.)',
                    'required' => false
                ]
            )
            ->add(
                'keywords',
                TextType::class,
                [
                    'label' => 'Ключевые слова',
                    'required' => false
                ]
            )
            ->add(
                'search',
                SubmitType::class,
                [
                    'label' => 'Поиск',
                    'attr' => array('class' => 'brand-bg text-light')
                ]
            );
        ;
    }
}
