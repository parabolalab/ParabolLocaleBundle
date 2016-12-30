<?php

namespace Parabol\LocaleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Page
 *
 * @ORM\Table(name="parabol_locale")
 * @ORM\Entity(repositoryClass="Parabol\LocaleBundle\Repository\LocaleRepository")
 */
class Locale extends \Parabol\LocaleBundle\Model\Locale
{
	
}
