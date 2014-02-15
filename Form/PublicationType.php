<?php

namespace FabriceKabongo\Common\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Description of VilleType
 *
 * @author Fabrice Kabongo <fabrice.k.kabongo at gmail.com>
 */
class PublicationType extends AbstractType{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("content", "text", array("required"=>true))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FabriceKabongo\Entities\Ville'
        ));
    }
    public function getName() {
        return "fabricekabongo_entities_ville";
    }
}
?>
