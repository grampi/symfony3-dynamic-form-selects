<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

class CarType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $producers = ['honda' => 'Honda', 'toyota' => 'Toyota', 'volvo' => 'Volvo'];

        $builder->add('producer', ChoiceType::class, [
                    'choices' => $producers,
                    'choice_label' => function($value, $key, $index) {
                        return $value;
                    },
                    'choice_value' => function($value) {
                        return strtolower($value);
                    }
                ])
                ->add('save', SubmitType::class, ['label' => 'Zapisz foremkę']);

        $formModifier = function (FormInterface $form, $producerId) {
            $models = ['honda' => ['Accord', 'Civic', 'Jazz'], 'toyota' => ['Yaris', 'Corolla'], 'volvo' => ['V90', 'S60']];

            $form->add('model', ChoiceType::class, [
                'choices' => $models[$producerId],
                'choice_label' => function($value, $key, $index) {
                    return $value;
                },
                'choice_value' => function($value) {
                    return strtolower($value);
                }
            ]);
        };

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($formModifier) {
            $data = $event->getData();

            if (empty($data)) {
                $producerId = 'honda';
            }

            $formModifier($event->getForm(), $producerId);
        });

        $builder->get('producer')->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) use ($formModifier) {
            $data = $event->getForm()->getData();
            $formModifier($event->getForm()->getParent(), strtolower($data));
        });
    }

}
