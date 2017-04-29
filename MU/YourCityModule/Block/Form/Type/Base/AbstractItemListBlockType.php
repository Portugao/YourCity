<?php
/**
 * YourCity.
 *
 * @copyright Michael Ueberschaer (MU)
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @author Michael Ueberschaer <info@homepages-mit-zikula.de>.
 * @link http://homepages-mit-zikula.de
 * @link http://zikula.org
 * @version Generated by ModuleStudio (http://modulestudio.de).
 */

namespace MU\YourCityModule\Block\Form\Type\Base;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Zikula\Common\Translator\TranslatorInterface;
use Zikula\Common\Translator\TranslatorTrait;
use MU\YourCityModule\Helper\FeatureActivationHelper;

/**
 * List block form type base class.
 */
abstract class AbstractItemListBlockType extends AbstractType
{
    use TranslatorTrait;

    /**
     * ItemListBlockType constructor.
     *
     * @param TranslatorInterface $translator Translator service instance
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->setTranslator($translator);
    }

    /**
     * Sets the translator.
     *
     * @param TranslatorInterface $translator Translator service instance
     */
    public function setTranslator(/*TranslatorInterface */$translator)
    {
        $this->translator = $translator;
    }

    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->addObjectTypeField($builder, $options);
        if ($options['feature_activation_helper']->isEnabled(FeatureActivationHelper::CATEGORIES, $options['object_type'])) {
            $this->addCategoriesField($builder, $options);
        }
        $this->addSortingField($builder, $options);
        $this->addAmountField($builder, $options);
        $this->addTemplateFields($builder, $options);
        $this->addFilterField($builder, $options);
    }

    /**
     * @inheritDoc
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['isCategorisable'] = $options['is_categorisable'];
    }

    /**
     * Adds an object type field.
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array                $options The options
     */
    public function addObjectTypeField(FormBuilderInterface $builder, array $options)
    {
        $builder->add('objectType', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', [
            'label' => $this->__('Object type') . ':',
            'empty_data' => 'location',
            'attr' => [
                'title' => $this->__('If you change this please save the block once to reload the parameters below.')
            ],
            'help' => $this->__('If you change this please save the block once to reload the parameters below.'),
            'choices' => [
                $this->__('Branches') => 'branch',
                $this->__('Locations') => 'location',
                $this->__('Parts') => 'part',
                $this->__('Images of location') => 'imageOfLocation',
                $this->__('Files of location') => 'fileOfLocation',
                $this->__('Offers') => 'offer',
                $this->__('Menus of location') => 'menuOfLocation',
                $this->__('Parts of menu') => 'partOfMenu',
                $this->__('Dishes') => 'dish',
                $this->__('Events') => 'event',
                $this->__('Products') => 'product',
                $this->__('Specials of location') => 'specialOfLocation',
                $this->__('Services of location') => 'serviceOfLocation',
                $this->__('Abonnements') => 'abonnement'
            ],
            'choices_as_values' => true,
            'multiple' => false,
            'expanded' => false
        ]);
    }

    /**
     * Adds a categories field.
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array                $options The options
     */
    public function addCategoriesField(FormBuilderInterface $builder, array $options)
    {
        if (!$options['is_categorisable'] || null === $options['category_helper']) {
            return;
        }
    
        $hasMultiSelection = $options['category_helper']->hasMultipleSelection($options['object_type']);
        $builder->add('categories', 'Zikula\CategoriesModule\Form\Type\CategoriesType', [
            'label' => ($hasMultiSelection ? $this->__('Categories') : $this->__('Category')) . ':',
            'empty_data' => $hasMultiSelection ? [] : null,
            'attr' => [
                'class' => 'category-selector',
                'title' => $this->__('This is an optional filter.')
            ],
            'help' => $this->__('This is an optional filter.'),
            'required' => false,
            'multiple' => $hasMultiSelection,
            'module' => 'MUYourCityModule',
            'entity' => ucfirst($options['object_type']) . 'Entity',
            'entityCategoryClass' => 'MU\YourCityModule\Entity\\' . ucfirst($options['object_type']) . 'CategoryEntity'
        ]);
    }

    /**
     * Adds a sorting field.
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array                $options The options
     */
    public function addSortingField(FormBuilderInterface $builder, array $options)
    {
        $builder->add('sorting', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', [
            'label' => $this->__('Sorting') . ':',
            'empty_data' => 'default',
            'choices' => [
                $this->__('Random') => 'random',
                $this->__('Newest') => 'newest',
                $this->__('Default') => 'default'
            ],
            'choices_as_values' => true,
            'multiple' => false,
            'expanded' => false
        ]);
    }

    /**
     * Adds a page size field.
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array                $options The options
     */
    public function addAmountField(FormBuilderInterface $builder, array $options)
    {
        $builder->add('amount', 'Symfony\Component\Form\Extension\Core\Type\IntegerType', [
            'label' => $this->__('Amount') . ':',
            'attr' => [
                'maxlength' => 2,
                'title' => $this->__('The maximum amount of items to be shown.') . ' ' . $this->__('Only digits are allowed.')
            ],
            'help' => $this->__('The maximum amount of items to be shown.') . ' ' . $this->__('Only digits are allowed.'),
            'empty_data' => 5,
            'scale' => 0
        ]);
    }

    /**
     * Adds template fields.
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array                $options The options
     */
    public function addTemplateFields(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('template', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', [
                'label' => $this->__('Template') . ':',
                'empty_data' => 'itemlist_display.html.twig',
                'choices' => [
                    $this->__('Only item titles') => 'itemlist_display.html.twig',
                    $this->__('With description') => 'itemlist_display_description.html.twig',
                    $this->__('Custom template') => 'custom'
                ],
                'choices_as_values' => true,
                'multiple' => false,
                'expanded' => false
            ])
            ->add('customTemplate', 'Symfony\Component\Form\Extension\Core\Type\TextType', [
                'label' => $this->__('Custom template') . ':',
                'required' => false,
                'attr' => [
                    'maxlength' => 80,
                    'title' => $this->__('Example') . ': itemlist_[objectType]_display.html.twig'
                ],
                'help' => $this->__('Example') . ': <em>itemlist_[objectType]_display.html.twig</em>'
            ])
        ;
    }

    /**
     * Adds a filter field.
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array                $options The options
     */
    public function addFilterField(FormBuilderInterface $builder, array $options)
    {
        $builder->add('filter', 'Symfony\Component\Form\Extension\Core\Type\TextType', [
            'label' => $this->__('Filter (expert option)') . ':',
            'required' => false,
            'attr' => [
                'maxlength' => 255
            ]
        ]);
    }

    /**
     * @inheritDoc
     */
    public function getBlockPrefix()
    {
        return 'muyourcitymodule_listblock';
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'object_type' => 'location',
                'is_categorisable' => false,
                'category_helper' => null,
                'feature_activation_helper' => null
            ])
            ->setRequired(['object_type'])
            ->setOptional(['is_categorisable', 'category_helper', 'feature_activation_helper'])
            ->setAllowedTypes([
                'object_type' => 'string',
                'is_categorisable' => 'bool',
                'category_helper' => 'object',
                'feature_activation_helper' => 'object'
            ])
        ;
    }
}
