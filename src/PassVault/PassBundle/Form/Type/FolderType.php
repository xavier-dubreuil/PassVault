<?php

namespace PassVault\PassBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\DependencyInjection\Container;

/**
 * Class FolderType
 * @package PassVault\PassBundle\Form\Type
 */
class FolderType extends AbstractType
{

    protected $container;


    /**
     * __construct function.
     *
     * @access public
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $securityChecker = $this->container->get('security.authorization_checker');

        $builder->add('parent', 'entity_modal', array(
            'label' => 'node.form.parent.label',
            'entity_label' => array('name'),
            'entity_repository' => 'PassVaultPassBundle:Node',
            'entity_classes' => array(
                'PassVault\PassBundle\Entity\Vault',
                'PassVault\PassBundle\Entity\Folder',
            ),
            'entity_parent' => 'parent',
            'entity_sort' => array('name')
        ));

        $builder->add('inherit', 'choice', array(
            'label' => 'nodeuser.form.inherit.label',
            'choices' => array(
                '1' => 'node.form.inherit.list.yes',
                '0' => 'node.form.inherit.list.no'
            )
        ));

        if ($securityChecker->isGranted('ROLE_ADMINISTRATOR', $options['data'])) {

            // Adding the submit button
            $builder->add('submit', 'submit', array(
                'attr' => array(
                    'class' => 'btn-sm btn-success'
                )
            ));

        }

    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PassVault\PassBundle\Entity\Folder',
            'cascade_validation' => true
        ));
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return 'node';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'folder';
    }
}