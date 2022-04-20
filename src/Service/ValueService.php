<?php

namespace App\Service;

use Symfony\Contracts\Translation\TranslatorInterface;

class ValueService
{
    private TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function getValues(): array
    {
        return [
            [
                'title' => $this->translator->trans('Hypnos is plural and personal'),
                'description' => $this->translator->trans('value_hypnos'),
            ],
            [
                'title' => $this->translator->trans('Life experience hoteliers'),
                'description' => $this->translator->trans('value_team'),
            ],
            [
                'title' => $this->translator->trans('Hotels selected with great care'),
                'description' => $this->translator->trans('value_hotel'),
            ],
        ];
    }
}
