<?php
/**
 * YourCity.
 *
 * @copyright Michael Ueberschaer (MU)
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @author Michael Ueberschaer <info@homepages-mit-zikula.de>.
 * @link https://homepages-mit-zikula.de
 * @link http://zikula.org
 * @version Generated by ModuleStudio (https://modulestudio.de).
 */

namespace MU\YourCityModule\Form\Type\Base;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Zikula\Common\Translator\TranslatorInterface;
use Zikula\Common\Translator\TranslatorTrait;
use Zikula\ExtensionsModule\Api\ApiInterface\VariableApiInterface;
use MU\YourCityModule\Entity\Factory\EntityFactory;
use MU\YourCityModule\Form\Type\Field\TranslationType;
use Zikula\UsersModule\Form\Type\UserLiveSearchType;
use MU\YourCityModule\Helper\CollectionFilterHelper;
use MU\YourCityModule\Helper\EntityDisplayHelper;
use MU\YourCityModule\Helper\FeatureActivationHelper;
use MU\YourCityModule\Helper\ListEntriesHelper;
use MU\YourCityModule\Helper\TranslatableHelper;

/**
 * Part of menu editing form type base class.
 */
abstract class AbstractPartOfMenuType extends AbstractType
{
    use TranslatorTrait;

    /**
     * @var EntityFactory
     */
    protected $entityFactory;

    /**
     * @var CollectionFilterHelper
     */
    protected $collectionFilterHelper;

    /**
     * @var EntityDisplayHelper
     */
    protected $entityDisplayHelper;

    /**
     * @var VariableApiInterface
     */
    protected $variableApi;

    /**
     * @var TranslatableHelper
     */
    protected $translatableHelper;

    /**
     * @var ListEntriesHelper
     */
    protected $listHelper;

    /**
     * @var FeatureActivationHelper
     */
    protected $featureActivationHelper;

    /**
     * PartOfMenuType constructor.
     *
     * @param TranslatorInterface $translator     Translator service instance
     * @param EntityFactory $entityFactory EntityFactory service instance
     * @param CollectionFilterHelper $collectionFilterHelper CollectionFilterHelper service instance
     * @param EntityDisplayHelper $entityDisplayHelper EntityDisplayHelper service instance
     * @param VariableApiInterface $variableApi VariableApi service instance
     * @param TranslatableHelper $translatableHelper TranslatableHelper service instance
     * @param ListEntriesHelper $listHelper ListEntriesHelper service instance
     * @param FeatureActivationHelper $featureActivationHelper FeatureActivationHelper service instance
     */
    public function __construct(
        TranslatorInterface $translator,
        EntityFactory $entityFactory,
        CollectionFilterHelper $collectionFilterHelper,
        EntityDisplayHelper $entityDisplayHelper,
        VariableApiInterface $variableApi,
        TranslatableHelper $translatableHelper,
        ListEntriesHelper $listHelper,
        FeatureActivationHelper $featureActivationHelper
    ) {
        $this->setTranslator($translator);
        $this->entityFactory = $entityFactory;
        $this->collectionFilterHelper = $collectionFilterHelper;
        $this->entityDisplayHelper = $entityDisplayHelper;
        $this->variableApi = $variableApi;
        $this->translatableHelper = $translatableHelper;
        $this->listHelper = $listHelper;
        $this->featureActivationHelper = $featureActivationHelper;
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
        $this->addEntityFields($builder, $options);
        $this->addOutgoingRelationshipFields($builder, $options);
        $this->addModerationFields($builder, $options);
        $this->addSubmitButtons($builder, $options);
    }

    /**
     * Adds basic entity fields.
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array                $options The options
     */
    public function addEntityFields(FormBuilderInterface $builder, array $options)
    {
        
        $builder->add('name', TextType::class, [
            'label' => $this->__('Name') . ':',
            'label_attr' => [
                'class' => 'tooltips',
                'title' => $this->__('For example drinks.')
            ],
            'help' => $this->__('For example drinks.'),
            'empty_data' => '',
            'attr' => [
                'maxlength' => 255,
                'class' => '',
                'title' => $this->__('Enter the name of the part of menu')
            ],
            'required' => true,
        ]);
        
        $builder->add('description', TextareaType::class, [
            'label' => $this->__('Description') . ':',
            'label_attr' => [
                'class' => 'tooltips',
                'title' => $this->__('Maximum 2000 characters.')
            ],
            'help' => [$this->__('Maximum 2000 characters.'), $this->__f('Note: this value must not exceed %amount% characters.', ['%amount%' => 2000])],
            'empty_data' => '',
            'attr' => [
                'maxlength' => 2000,
                'class' => '',
                'title' => $this->__('Enter the description of the part of menu')
            ],
            'required' => false,
        ]);
        
        if ($this->variableApi->getSystemVar('multilingual') && $this->featureActivationHelper->isEnabled(FeatureActivationHelper::TRANSLATIONS, 'partOfMenu')) {
            $supportedLanguages = $this->translatableHelper->getSupportedLanguages('partOfMenu');
            if (is_array($supportedLanguages) && count($supportedLanguages) > 1) {
                $currentLanguage = $this->translatableHelper->getCurrentLanguage();
                $translatableFields = $this->translatableHelper->getTranslatableFields('partOfMenu');
                $mandatoryFields = $this->translatableHelper->getMandatoryFields('partOfMenu');
                foreach ($supportedLanguages as $language) {
                    if ($language == $currentLanguage) {
                        continue;
                    }
                    $builder->add('translations' . $language, TranslationType::class, [
                        'fields' => $translatableFields,
                        'mandatory_fields' => $mandatoryFields[$language],
                        'values' => isset($options['translations'][$language]) ? $options['translations'][$language] : []
                    ]);
                }
            }
        }
        
        $builder->add('positionOfPart', IntegerType::class, [
            'label' => $this->__('Position of part') . ':',
            'empty_data' => '0',
            'attr' => [
                'maxlength' => 11,
                'class' => '',
                'title' => $this->__('Enter the position of part of the part of menu.') . ' ' . $this->__('Only digits are allowed.')
            ],
            'required' => true,
            'scale' => 0
        ]);
        
        $listEntries = $this->listHelper->getEntries('partOfMenu', 'myLocation');
        $choices = [];
        $choiceAttributes = [];
        foreach ($listEntries as $entry) {
            $choices[$entry['text']] = $entry['value'];
            $choiceAttributes[$entry['text']] = ['title' => $entry['title']];
        }
        $builder->add('myLocation', ChoiceType::class, [
            'label' => $this->__('My location') . ':',
            'label_attr' => [
                'class' => 'tooltips',
                'title' => $this->__('If you have more than one location, select the correct one!')
            ],
            'help' => $this->__('If you have more than one location, select the correct one!'),
            'empty_data' => '',
            'attr' => [
                'class' => '',
                'title' => $this->__('Choose the my location')
            ],
            'required' => true,
            'choices' => $choices,
            'choices_as_values' => true,
            'choice_attr' => $choiceAttributes,
            'multiple' => false,
            'expanded' => false
        ]);
    }

    /**
     * Adds fields for outgoing relationships.
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array                $options The options
     */
    public function addOutgoingRelationshipFields(FormBuilderInterface $builder, array $options)
    {
        $queryBuilder = function(EntityRepository $er) {
            // select without joins
            return $er->getListQueryBuilder('', '', false);
        };
        $entityDisplayHelper = $this->entityDisplayHelper;
        $choiceLabelClosure = function ($entity) use ($entityDisplayHelper) {
            return $entityDisplayHelper->getFormattedTitle($entity);
        };
        $builder->add('dishes', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', [
            'class' => 'MUYourCityModule:DishEntity',
            'choice_label' => $choiceLabelClosure,
            'by_reference' => false,
            'multiple' => true,
            'expanded' => true,
            'query_builder' => $queryBuilder,
            'required' => false,
            'label' => $this->__('Dishes'),
            'label_attr' => [
                'class' => 'checkbox-inline'
            ],
            'attr' => [
                'title' => $this->__('Choose the dishes')
            ]
        ]);
    }

    /**
     * Adds special fields for moderators.
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array                $options The options
     */
    public function addModerationFields(FormBuilderInterface $builder, array $options)
    {
        if (!$options['has_moderate_permission']) {
            return;
        }
        if ($options['inline_usage']) {
            return;
        }
    
        $builder->add('moderationSpecificCreator', UserLiveSearchType::class, [
            'mapped' => false,
            'label' => $this->__('Creator') . ':',
            'attr' => [
                'maxlength' => 11,
                'title' => $this->__('Here you can choose a user which will be set as creator')
            ],
            'empty_data' => 0,
            'required' => false,
            'help' => $this->__('Here you can choose a user which will be set as creator')
        ]);
        $builder->add('moderationSpecificCreationDate', DateTimeType::class, [
            'mapped' => false,
            'label' => $this->__('Creation date') . ':',
            'attr' => [
                'class' => '',
                'title' => $this->__('Here you can choose a custom creation date')
            ],
            'empty_data' => '',
            'required' => false,
            'with_seconds' => true,
            'date_widget' => 'single_text',
            'time_widget' => 'single_text',
            'help' => $this->__('Here you can choose a custom creation date')
        ]);
    }

    /**
     * Adds submit buttons.
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array                $options The options
     */
    public function addSubmitButtons(FormBuilderInterface $builder, array $options)
    {
        foreach ($options['actions'] as $action) {
            $builder->add($action['id'], SubmitType::class, [
                'label' => $action['title'],
                'icon' => ($action['id'] == 'delete' ? 'fa-trash-o' : ''),
                'attr' => [
                    'class' => $action['buttonClass']
                ]
            ]);
            if ($options['mode'] == 'create' && $action['id'] == 'submit' && !$options['inline_usage']) {
                // add additional button to submit item and return to create form
                $builder->add('submitrepeat', SubmitType::class, [
                    'label' => $this->__('Submit and repeat'),
                    'icon' => 'fa-repeat',
                    'attr' => [
                        'class' => $action['buttonClass']
                    ]
                ]);
            }
        }
        $builder->add('reset', ResetType::class, [
            'label' => $this->__('Reset'),
            'icon' => 'fa-refresh',
            'attr' => [
                'class' => 'btn btn-default',
                'formnovalidate' => 'formnovalidate'
            ]
        ]);
        $builder->add('cancel', SubmitType::class, [
            'label' => $this->__('Cancel'),
            'icon' => 'fa-times',
            'attr' => [
                'class' => 'btn btn-default',
                'formnovalidate' => 'formnovalidate'
            ]
        ]);
    }

    /**
     * @inheritDoc
     */
    public function getBlockPrefix()
    {
        return 'muyourcitymodule_partofmenu';
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                // define class for underlying data (required for embedding forms)
                'data_class' => 'MU\YourCityModule\Entity\PartOfMenuEntity',
                'empty_data' => function (FormInterface $form) {
                    return $this->entityFactory->createPartOfMenu();
                },
                'error_mapping' => [
                ],
                'mode' => 'create',
                'actions' => [],
                'has_moderate_permission' => false,
                'translations' => [],
                'filter_by_ownership' => true,
                'inline_usage' => false
            ])
            ->setRequired(['mode', 'actions'])
            ->setAllowedTypes('mode', 'string')
            ->setAllowedTypes('actions', 'array')
            ->setAllowedTypes('has_moderate_permission', 'bool')
            ->setAllowedTypes('translations', 'array')
            ->setAllowedTypes('filter_by_ownership', 'bool')
            ->setAllowedTypes('inline_usage', 'bool')
            ->setAllowedValues('mode', ['create', 'edit'])
        ;
    }
}
