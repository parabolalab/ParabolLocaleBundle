<?php

namespace Parabol\LocaleBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\MappedSuperclass
 */
abstract class Country
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=2)
     * @Assert\NotBlank()
     */
    protected $code;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;


    /**
     * @var string
     *
     * @ORM\Column(name="currency", type="string", length=3, nullable=true)
     */
    protected $currency;

    /**
     * @var string
     *
     * @ORM\Column(name="dialing_code", type="string", length=3, nullable=true)
     */
    protected $dialingCode;

    /**
     * @var string
     *
     * @ORM\Column(name="native_code", type="string", length=5)
     */
    protected $nativeCode;

    /**
     * @ORM\ManyToMany(targetEntity="Locale", mappedBy="countries", cascade={"persist"})
     * @Assert\Count(min=1);
     **/
    protected $locales;

     /**
     * Constructor
     */
    public function __construct()
    {
        $this->locales = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return (string)$this->name;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return Country
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Country
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set currency
     *
     * @param string $currency
     *
     * @return Country
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get currency
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

     /**
     * Set dialingCode
     *
     * @param string $dialingCode
     *
     * @return Country
     */
    public function setDialingCode($dialingCode)
    {
        $this->dialingCode = $dialingCode;

        return $this;
    }

    /**
     * Get dialingCode
     *
     * @return string
     */
    public function getDialingCode()
    {
        return $this->dialingCode;
    }

    /**
     * Set nativeCode
     *
     * @param string $nativeCode
     *
     * @return Country
     */
    public function setNativeCode($nativeCode)
    {
        $this->nativeCode = $nativeCode;

        return $this;
    }

    /**
     * Get nativeCode
     *
     * @return string
     */
    public function getNativeCode()
    {
        return $this->nativeCode;
    }

    /**
     * Add locale
     *
     * @param \Parabol\LocaleBundle\Entity\Locale $locale
     *
     * @return Country
     */
    public function addLocale(\Parabol\LocaleBundle\Entity\Locale $locale)
    {

        $locale->addCountry($this);

        $this->locales[] = $locale;

        return $this;
    }

    /**
     * Remove locale
     *
     * @param \Parabol\LocaleBundle\Entity\Locale $locale
     */
    public function removeLocale(\Parabol\LocaleBundle\Entity\Locale $locale)
    {
        $locale->removeCountry($this);
        $this->locales->removeElement($locale);
    }

    /**
     * Get locales
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLocales()
    {
        return $this->locales;
    }

}

