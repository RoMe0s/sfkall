<?php
namespace AdminBundle\Traits\Repository;

trait TranslationTrait { //need Basic Trait

	public function joinTranslations($table, $locale) {

		$this->query = $this->query
		->leftJoin($table . '.translations', 'translation')
		->where('translation.locale = :locale')
		->setParameter('locale', $locale);

		return $this;
	}

}