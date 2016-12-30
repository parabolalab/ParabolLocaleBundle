<?php

namespace Parabol\LocaleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Intl\Intl;

class CountryController extends Controller
{

	public function translationsEnablerAction()
	{
		$countriesJsonMap = json_encode(array_reduce($this->getDoctrine()->getRepository('ParabolLocaleBundle:Country')->createQueryBuilder('c')->select('c.code, l.code as locale')->join('c.locales', 'l')->getQuery()->getArrayResult(), 
			function($arr, $v){ $arr[$v['code']] = $v['locale']; return $arr;}
			, array()));
		
		return $this->render('ParabolLocaleBundle:Country:_translationsEnabler.html.twig', array('countriesJsonMap' => $countriesJsonMap));
	}

    // public function indexAction()
    // {

    // 	var_dump(Intl::getLocaleBundle()->getLocaleNames());

    //     return $this->render('ParabolLocaleBundle:Default:index.html.twig');
    // }
}
