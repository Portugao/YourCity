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

namespace MU\YourCityModule\Form\Type\Base;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Zikula\Common\Translator\TranslatorInterface;
use Zikula\Common\Translator\TranslatorTrait;
use Zikula\ExtensionsModule\Api\ApiInterface\VariableApiInterface;
use MU\YourCityModule\Entity\Factory\EntityFactory;
use MU\YourCityModule\Form\Type\Field\MultiListType;
use MU\YourCityModule\Form\Type\Field\TranslationType;
use MU\YourCityModule\Form\Type\Field\UploadType;
use MU\YourCityModule\Form\Type\Field\UserType;
use MU\YourCityModule\Helper\CollectionFilterHelper;
use MU\YourCityModule\Helper\EntityDisplayHelper;
use MU\YourCityModule\Helper\FeatureActivationHelper;
use MU\YourCityModule\Helper\ListEntriesHelper;
use MU\YourCityModule\Helper\TranslatableHelper;

/**
 * Dish editing form type base class.
 */
abstract class AbstractDishType extends AbstractType
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
     * DishType constructor.
     *
     * @param TranslatorInterface $translator     Translator service instance
     * @param EntityFactory       $entityFactory EntityFactory service instance
     * @param CollectionFilterHelper $collectionFilterHelper CollectionFilterHelper service instance
     * @param EntityDisplayHelper $entityDisplayHelper EntityDisplayHelper service instance
     * @param VariableApiInterface $variableApi VariableApi service instance
     * @param TranslatableHelper  $translatableHelper TranslatableHelper service instance
     * @param ListEntriesHelper   $listHelper     ListEntriesHelper service instance
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
        $this->addIncomingRelationshipFields($builder, $options);
        $this->addModerationFields($builder, $options);
        $this->addReturnControlField($builder, $options);
        $this->addSubmitButtons($builder, $options);

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $entity = $event->getData();
            foreach (['imageOfDish'] as $uploadFieldName) {
                $entity[$uploadFieldName] = [
                    $uploadFieldName => $entity[$uploadFieldName] instanceof File ? $entity[$uploadFieldName]->getPathname() : null
                ];
            }
        });
        $builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
            $entity = $event->getData();
            foreach (['imageOfDish'] as $uploadFieldName) {
                if (is_array($entity[$uploadFieldName])) {
                    $entity[$uploadFieldName] = $entity[$uploadFieldName][$uploadFieldName];
                }
            }
        });
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
            'empty_data' => '',
            'attr' => [
                'maxlength' => 255,
                'class' => '',
                'title' => $this->__('Enter the name of the dish')
            ],
            'required' => true,
        ]);
        
        $builder->add('description', TextareaType::class, [
            'label' => $this->__('Description') . ':',
            'label_attr' => [
                'class' => 'tooltips',
                'title' => $this->__('Maximum 2000 characters.')
            ],
            'help' => $this->__('Maximum 2000 characters.'),
            'empty_data' => '',
            'attr' => [
                'maxlength' => 2000,
                'class' => '',
                'title' => $this->__('Enter the description of the dish')
            ],
            'required' => false,
        ]);
        
        if ($this->variableApi->getSystemVar('multilingual') && $this->featureActivationHelper->isEnabled(FeatureActivationHelper::TRANSLATIONS, 'dish')) {
            $supportedLanguages = $this->translatableHelper->getSupportedLanguages('dish');
            if (is_array($supportedLanguages) && count($supportedLanguages) > 1) {
                $currentLanguage = $this->translatableHelper->getCurrentLanguage();
                $translatableFields = $this->translatableHelper->getTranslatableFields('dish');
                $mandatoryFields = $this->translatableHelper->getMandatoryFields('dish');
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
        
        $listEntries = $this->listHelper->getEntries('dish', 'kindOfDish');
        $choices = [];
        $choiceAttributes = [];
        foreach ($listEntries as $entry) {
            $choices[$entry['text']] = $entry['value'];
            $choiceAttributes[$entry['text']] = ['title' => $entry['title']];
        }
        $builder->add('kindOfDish', MultiListType::class, [
            'label' => $this->__('Kind of dish') . ':',
            'empty_data' => 'other',
            'attr' => [
                'class' => '',
                'title' => $this->__('Choose the kind of dish')
            ],
            'required' => true,
            'choices' => $choices,
            'choices_as_values' => true,
            'choice_attr' => $choiceAttributes,
            'multiple' => true,
            'expanded' => false
        ]);
        
        $builder->add('imageOfDish', UploadType::class, [
            'label' => $this->__('Image of dish') . ':',
            'attr' => [
                'class' => ' validate-upload',
                'title' => $this->__('Enter the image of dish of the dish')
            ],
            'required' => false && $options['mode'] == 'create',
            'entity' => $options['entity'],
            'allowed_extensions' => 'gif, jpeg, jpg, png',
            'allowed_size' => ''
        ]);
        
        $builder->add('priceOfDish', MoneyType::class, [
            'label' => $this->__('Price of dish') . ':',
            'empty_data' => '0.00',
            'attr' => [
                'maxlength' => 15,
                'class' => ' validate-number',
                'title' => $this->__('Enter the price of dish of the dish')
            ],
            'required' => true,
            
            
            'scale' => 2
        ]);
        
        $builder->add('ingredients', TextType::class, [
            'label' => $this->__('Ingredients') . ':',
            'label_attr' => [
                'class' => 'tooltips',
                'title' => $this->__('Enter the numbers of ingredients, that you entered in the addtional remarks of your menu!')
            ],
            'help' => $this->__('Enter the numbers of ingredients, that you entered in the addtional remarks of your menu!'),
            'empty_data' => '',
            'attr' => [
                'maxlength' => 255,
                'class' => '',
                'title' => $this->__('Enter the ingredients of the dish')
            ],
            'required' => false,
        ]);
        
        $builder->add('positionOfDish', IntegerType::class, [
            'label' => $this->__('Position of dish') . ':',
            'empty_data' => '0',
            'attr' => [
                'maxlength' => 11,
                'class' => ' validate-digits',
                'title' => $this->__('Enter the position of dish of the dish.') . ' ' . $this->__('Only digits are allowed.')
            ],
            'required' => true,
            'scale' => 0
        ]);
    }

    /**
     * Adds fields for incoming relationships.
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array                $options The options
     */
    public function addIncomingRelationshipFields(FormBuilderInterface $builder, array $options)
    {
        $queryBuilder = function(EntityRepository $er) {
            // select without joins
            return $er->getListQueryBuilder('', '', false);
        };
        $entityDisplayHelper = $this->entityDisplayHelper;
        $choiceLabelClosure = function ($entity) use ($entityDisplayHelper) {
            return $entityDisplayHelper->getFormattedTitle($entity);
        };
        $builder->add('menuOfLocation', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', [
            'class' => 'MUYourCityModule:MenuOfLocationEntity',
            'choice_label' => $choiceLabelClosure,
            'multiple' => false,
            'expanded' => false,
            'query_builder' => $queryBuilder,
            'placeholder' => $this->__('Please choose an option'),
            'required' => false,
            'label' => $this->__('Menu of location'),
            'attr' => [
                'title' => $this->__('Choose the menu of location')
            ]
        ]);
        $queryBuilder = function(EntityRepository $er) {
            // select without joins
            return $er->getListQueryBuilder('', '', false);
        };
        $entityDisplayHelper = $this->entityDisplayHelper;
        $choiceLabelClosure = function ($entity) use ($entityDisplayHelper) {
            return $entityDisplayHelper->getFormattedTitle($entity);
        };
        $builder->add('partOfMenu', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', [
            'class' => 'MUYourCityModule:PartOfMenuEntity',
            'choice_label' => $choiceLabelClosure,
            'multiple' => false,
            'expanded' => false,
            'query_builder' => $queryBuilder,
            'placeholder' => $this->__('Please choose an option'),
            'required' => false,
            'label' => $this->__('Part of menu'),
            'attr' => [
                'title' => $this->__('Choose the part of menu')
            ]
        ]);
        $queryBuilder = function(EntityRepository $er) {
            // select without joins
            return $er->getListQueryBuilder('', '', false);
        };
        $entityDisplayHelper = $this->entityDisplayHelper;
        $choiceLabelClosure = function ($entity) use ($entityDisplayHelper) {
            return $entityDisplayHelper->getFormattedTitle($entity);
        };
        $builder->add('location', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', [
            'class' => 'MUYourCityModule:LocationEntity',
            'choice_label' => $choiceLabelClosure,
            'multiple' => false,
            'expanded' => false,
            'query_builder' => $queryBuilder,
            'label' => $this->__('Location'),
            'attr' => [
                'title' => $this->__('Choose the location')
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
    
        $builder->add('moderationSpecificCreator', UserType::class, [
            'mapped' => false,
            'label' => $this->__('Creator') . ':',
            'attr' => [
                'maxlength' => 11,
                'class' => ' validate-digits',
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
     * Adds the return control field.
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array                $options The options
     */
    public function addReturnControlField(FormBuilderInterface $builder, array $options)
    {
        if ($options['mode'] != 'create') {
            return;
        }
        $builder->add('repeatCreation', CheckboxType::class, [
            'mapped' => false,
            'label' => $this->__('Create another item after save'),
            'required' => false
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
        return 'muyourcitymodule_dish';
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                // define class for underlying data (required for embedding forms)
                'data_class' => 'MU\YourCityModule\Entity\DishEntity',
                'empty_data' => function (FormInterface $form) {
                    return $this->entityFactory->createDish();
                },
                'error_mapping' => [
                    'isKindOfDishValueAllowed' => 'kindOfDish',
                    'imageOfDish' => 'imageOfDish.imageOfDish',
                ],
                'mode' => 'create',
                'actions' => [],
                'has_moderate_permission' => false,
                'translations' => [],
                'filter_by_ownership' => true,
                'inline_usage' => false
            ])
            ->setRequired(['entity', 'mode', 'actions'])
            ->setAllowedTypes([
                'mode' => 'string',
                'actions' => 'array',
                'has_moderate_permission' => 'bool',
                'translations' => 'array',
                'filter_by_ownership' => 'bool',
                'inline_usage' => 'bool'
            ])
            ->setAllowedValues([
                'mode' => ['create', 'edit']
            ])
        ;
    }
}
