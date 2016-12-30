<?php

namespace Parabol\LocaleBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Intl\Intl;

class LocaleSubscriber implements EventSubscriber {

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function getSubscribedEvents()
    {
        return array(
            'prePersist',
            'preUpdate',
            'postPersist',
            'postUpdate',
            'postRemove'
        );
    }

    public function prePersist(LifecycleEventArgs $arg)
    {
        // $this->setNativeCode($arg);    
        $this->setCountryData($arg);
        $this->setLocaleParams($arg);
    }

    public function preUpdate(LifecycleEventArgs $arg)
    {
        // $this->setNativeCode($arg);    
        $this->setCountryData($arg);   
        $this->setLocaleParams($arg);
    }

    public function postPersist(LifecycleEventArgs $arg)
    {
        $this->rebuildLocales($arg);    
    }

    public function postUpdate(LifecycleEventArgs $arg)
    {
        $this->rebuildLocales($arg);            
    }

    public function postRemove(LifecycleEventArgs $arg)
    {
        $this->rebuildLocales($arg);            
    }

    public function setLocaleParams($arg)
    {
        $entity = $arg->getEntity();
        if($entity instanceof \Parabol\LocaleBundle\Entity\Locale)
        {
            if($entity->isDefault())
            {
                $entity->setIsRequired(true);
            }
        }
    }

    // public function setNativeCode($arg)
    // {   
    //     $entity = $arg->getEntity();
        
    //     if($entity instanceof \AppBundle\Entity\Country && !$entity->getNativeCode())
    //     {
    //         $allLocales = $this->container->getParameter('localesByCountries');
    //         if(isset($allLocales[$entity->getName()])) $entity->setNativeCode($allLocales[$entity->getName()]);
    //         else $entity->setNativeCode('en');
    //     }
    // }


    public function setCountryData($arg)
    {   
        $entity = $arg->getEntity();
        
        if($entity instanceof \Parabol\LocaleBundle\Entity\Country)
        {

            // $countryInfo = json_decode(file_get_contents('https://restcountries.eu/rest/v1/alpha/' . $entity->getCode()));
            // var_dump($countryInfo);
            // die();

            // if(!$entity->getName()) $entity->setName(Intl::getRegionBundle()->getCountryName($entity->getCode(), 'en'));
            
            

            // $formatter = new \NumberFormatter('en_'.$entity->getCode(), \NumberFormatter::CURRENCY);
            // if(!$entity->getCurrency()) $entity->setCurrency($formatter->getTextAttribute(\NumberFormatter::CURRENCY_CODE));


        }
    }

    public function rebuildLocales($arg)
    {
        if($arg->getEntity() instanceof \Parabol\LocaleBundle\Entity\Locale)
        {
            

           
            $all = $arg->getObjectManager()
                ->getRepository('ParabolLocaleBundle:Locale')
                ->createQueryBuilder('l')
                ->select('l.code, l.isRequired, l.isDefault')
                ->orderBy("l.code")
                ->where('l.isEnabled = 1')
                ->orderBy('l.isRequired', 'DESC')
                ->addOrderBy('l.code', 'ASC')
                ->getQuery()
                ->getScalarResult()
            ;

            $defaultLocale = $this->container->getParameter('parabol_locale.default_locale');  

            $parameters = array(
                'locales' => array(),
                'required_locales' => array(),
                'locale' => $defaultLocale
            );

            if(isset($all[0]))
            {
                foreach ($all as $locale) {
                    $parameters['locales'][] =  $locale['code'];
                    if($locale['isRequired']) $parameters['required_locales'][] =  $locale['code'];
                    if($locale['isDefault']) $parameters['locale'] =  $locale['code'];
                }
            }
            else $parameters['locales'][] = $defaultLocale;
           
            if(!isset( $parameters['required_locales'][0] )) $parameters['required_locales'][] = $parameters['locales'][0];
            if(!isset( $parameters['locales'][1] )) $parameters['locale'] = $parameters['locales'][0];
                
            // if($nativeCodes)
            // {
            //     $nativeCodes = explode(',',$nativeCodes);
            //     array_unshift($nativeCodes, 'en');
            // }
            // else {
            //     $nativeCodes = array('en');
            // }

            //'nativeLocales' => $nativeCodes

            file_put_contents('../app/config/locales.yml', Yaml::dump(array('parameters' => $parameters)));

            $containerCache = $this->container->getParameter('kernel.root_dir').'/cache/prod/appProdProjectContainer.php';
            if(file_exists($containerCache)) unlink($containerCache);
            
            
        }

    }

}