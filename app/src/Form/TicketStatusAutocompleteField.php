<?php

namespace App\Form;

use App\Entity\TicketStatus;
use App\Repository\TicketStatusRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Autocomplete\Form\AsEntityAutocompleteField;
use Symfony\UX\Autocomplete\Form\ParentEntityAutocompleteType;

#[AsEntityAutocompleteField]
class TicketStatusAutocompleteField extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => TicketStatus::class,
            'placeholder' => 'Choose a status',
            'choice_label' => 'label',

            'query_builder' => function(TicketStatusRepository $ticketStatusRepository) {
                return $ticketStatusRepository->createQueryBuilder('status');
            },
            //'security' => 'ROLE_SOMETHING',

            'tom_select_options' => [
                'create' => true
            ]
        ]);
    }

    public function getParent(): string
    {
        return ParentEntityAutocompleteType::class;
    }
}
