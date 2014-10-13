<?php

namespace Blog\CoreBundle\TwigExtension;

use Symfony\Bundle\FrameworkBundle\Translation\Translator;

/**
 * class TransPlural
 */
class TransPlural extends \Twig_Extension
{
    private $translator;
    public function __construct( Translator $translator)
    {
        $this->translator = $translator;
    }
    /**
     *
     * @param type $msg
     * @param type $number
     */
    public function trans_plural($msg, $number)
    {
        //$translated = $this->translator->trans($msg, array('%d' => $number));

        if( $this->translator->getLocale() !== 'ru' || $number === 0 )
            return $this->translator->transChoice ($msg, $number, array('%count%' => $number));

        $type = ( $number % 10 == 1 && $number % 100 != 11
                        ? 1
                        : ( $number % 10 >= 2 && $number % 10 <= 4 && ( $number % 100 < 10 || $number % 100 >= 20 )
                            ? 2
                            : 3 ) );

        return $this->translator->transChoice($msg, $type, array('%count%'=> $number));
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('trans_plural', array($this, 'trans_plural') )
        );
    }

        /**
     *
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'russian_plural_extension';
    }

}

