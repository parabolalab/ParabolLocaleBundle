<?php

namespace Parabol\LocaleBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\MappedSuperclass
 * @UniqueEntity(fields={"isDefault", "code"}, ignoreNull=true, repositoryMethod="validateRequired")
 * @UniqueEntity(fields={"isEnabled", "isDefault", "code"}, ignoreNull=true, repositoryMethod="validateEnabled", message="Default locale can't be disabled")
 */
abstract class Locale
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
     * @ORM\Column(name="code", type="string", length=5)
     * @Assert\NotBlank()
     */
    protected $code;

    /**
     * @ORM\Column(type="boolean", name="is_default")
     */
    protected $isDefault = false;

    /**
     * @ORM\Column(type="boolean", name="is_required")
     */
    protected $isRequired = false;

    /**
     * @ORM\Column(type="boolean", name="is_enabled")
     */
    protected $isEnabled = true;


    /**
     * @ORM\ManyToMany(targetEntity="Country", inversedBy="locales", cascade={"persist"})
     * @ORM\JoinTable(name="parabol_countries_locales", 
     *      joinColumns={@ORM\JoinColumn(name="locale_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="country_id", referencedColumnName="id")}
     * )
     **/
    protected $countries;

     /**
     * Constructor
     */
    public function __construct()
    {
        $this->countries = new \Doctrine\Common\Collections\ArrayCollection();
    }


    public function __toString()
    {
        return $this->code;
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
     * Set isDefault
     *
     * @param boolean $isDefault
     * @return Page
     */
    public function setIsDefault($isDefault)
    {
        $this->isDefault = $isDefault;

        return $this;
    }

    /**
     * Get isDefault
     *
     * @return boolean 
     */
    public function getIsDefault()
    {
        return $this->isDefault;
    }

    public function isDefault()
    {
        return $this->isDefault;
    }


     /**
     * Set isRequired
     *
     * @param boolean $isRequired
     * @return Page
     */
    public function setIsRequired($isRequired)
    {
        $this->isRequired = $isRequired;

        return $this;
    }

    /**
     * Get isRequired
     *
     * @return boolean 
     */
    public function getIsRequired()
    {
        return $this->isRequired;
    }

    public function isRequired()
    {
        return $this->isRequired;
    }

    /**
     * Get isEnabled
     *
     * @return boolean 
     */
    public function getIsEnabled()
    {
        return $this->isEnabled;
    }

     /**
     * Set isEnabled
     *
     * @param boolean $isEnabled
     *
     * @return Locale
     */
    public function setIsEnabled($isEnabled)
    {
        $this->isEnabled = $isEnabled;

        return $this;
    }

    public function isEnabled()
    {
        return $this->isEnabled;
    }

    

    /**
     * Add country
     *
     * @param \Parabol\LocaleBundle\Entity\Country $country
     *
     * @return Locale
     */
    public function addCountry(\Parabol\LocaleBundle\Entity\Country $country)
    {
        $this->countries[] = $country;

        return $this;
    }

    /**
     * Remove country
     *
     * @param \Parabol\LocaleBundle\Entity\Country $country
     */
    public function removeCountry(\Parabol\LocaleBundle\Entity\Country $country)
    {
        $this->countries->removeElement($country);
    }

    /**
     * Get countries
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCountries()
    {
        return $this->countries;
    }

}

