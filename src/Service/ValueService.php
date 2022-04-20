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
                'description' => $this->translator->trans('The search for excellence makes it possible to ensure that everything is in place to offer the best: best materials, best human skills, best service delivery. It is a motivation that conditions us to give the best of ourselves.'),
            ],
            [
                'title' => $this->translator->trans('Life experience hoteliers'),
                'description' => $this->translator->trans('The best way to achieve exceptional service is to personalize the customer\'s stay, to do everything to know him to understand his needs. To surprise him, you have to anticipate his needs and design moments of life that will be memorable. Hoteliers are craftsmen of life experiences.'),
            ],
            [
                'title' => $this->translator->trans('Hotels selected with great care'),
                'description' => $this->translator->trans('The promise of excellence to its customers, from all points of view. Through luxury services, but above all by personalizing the customer experience as much as possible. Exceptional service and an ultra-depth understanding of every customer need will be required. It is the permanent anticipation and the design of absolutely memorable moments in life.'),
            ],
        ];
    }
}
