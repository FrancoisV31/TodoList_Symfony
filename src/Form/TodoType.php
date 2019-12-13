<?php

namespace App\Form;

use App\Entity\Todo;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class TodoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // test voir options!
        dump($options['data']->getId());

        $builder
            ->add('title', TextType::class, [
                'label' => 'Tâche à faire',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Entrez le ici !'
                ]
            ])
            ->add('category', EntityType::class,[
                'class' => Category::class,
                'choice_label' => 'name',
                'label' => 'Quelle catégorie?'
               
            ])
            ->add('content', TextareaType::class,[
                'label' => 'Description tâche',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Remplissez ici !'
                ]
            ]);

            if($options['data']->getId() == null){

                $builder->add('todoFor', DateType::class,[
                'years' => [ '2019','2020'],
                'format' => 'dd MM yyyy',
                'data' => new \DateTime('now', new \DateTimeZone('Europe/Paris'))
                ]);

            }else{ 
            
                $builder->add('todoFor', DateType::class,[
                    'years' => [ '2019','2020'],
                    'format' => 'dd MM yyyy',
            
                ]);
            }

 
            $builder->add('submit', SubmitType::class);
}

public function configureOptions(OptionsResolver $resolver)
{
    $resolver->setDefaults([
        'data_class' => Todo::class,
    ]);
}

}