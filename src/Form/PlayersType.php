<?php

namespace App\Form;

use App\Entity\Players;
use App\Entity\FbTeam;
use App\Repository\FbTeamRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlayersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            //->add('team')
            ->add('firstname')
            ->add('surname')
            ->add('team', EntityType::class, [
                'class' => FbTeam::class,
                'choice_value' => function (?FbTeam $entity) {
                    return $entity ? $entity->getId() : -1;
                }
            ])
            ->add('price', IntegerType::class)
            ->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Players::class,
        ]);
    }
}
