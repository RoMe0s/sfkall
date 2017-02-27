<?php
/**
 * Created by PhpStorm.
 * User: rome0s
 * Date: 27.02.17
 * Time: 17:27
 */

namespace AdminBundle\Traits\Repository;


trait TranslationTrait
{

    public function joinTranslations($locale, $use_default_locale = false) {

        $this->query->setHint(
            \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        )
            // locale
        ->setHint(
             \Gedmo\Translatable\TranslatableListener::HINT_TRANSLATABLE_LOCALE,
             $locale
        )
            // fallback
        ->setHint(
             \Gedmo\Translatable\TranslatableListener::HINT_FALLBACK,
             $use_default_locale
        );

        return $this;

    }

}