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
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
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
use MU\YourCityModule\Form\Type\Field\TranslationType;
use MU\YourCityModule\Form\Type\Field\UploadType;
use MU\YourCityModule\Form\Type\Field\UserType;
use MU\YourCityModule\Helper\CollectionFilterHelper;
use MU\YourCityModule\Helper\EntityDisplayHelper;
use MU\YourCityModule\Helper\FeatureActivationHelper;
use MU\YourCityModule\Helper\ListEntriesHelper;
use MU\YourCityModule\Helper\TranslatableHelper;

/**
 * Offer editing form type base class.
 */
abstract class AbstractOfferType extends AbstractType
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
     * OfferType constructor.
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
            foreach (['imageOfOffer'] as $uploadFieldName) {
                $entity[$uploadFieldName] = [
                    $uploadFieldName => $entity[$uploadFieldName] instanceof File ? $entity[$uploadFieldName]->getPathname() : null
                ];
            }
        });
        $builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
            $entity = $event->getData();
            foreach (['imageOfOffer'] as $uploadFieldName) {
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
                'title' => $this->__('Enter the name of the offer')
            ],
            'required' => true,
        ]);
        
        $builder->add('description', TextareaType::class, [
            'label' => $this->__('Description') . ':',
            'label_attr' => [
                'class' => 'tooltips',
                'title' => $this->__('Enter a description of this offer.
                You can also give informations about the price if you do not want to use the special field for it.')
            ],
            'help' => [$this->__('Enter a description of this offer.
            You can also give informations about the price if you do not want to use the special field for it.'), $this->__f('Note: this value must not exceed %amount% characters.', ['%amount%' => 4000])],
            'empty_data' => '',
            'attr' => [
                'maxlength' => 4000,
                'class' => '',
                'title' => $this->__('Enter the description of the offer')
            ],
            'required' => false,
        ]);
        
        if ($this->variableApi->getSystemVar('multilingual') && $this->featureActivationHelper->isEnabled(FeatureActivationHelper::TRANSLATIONS, 'offer')) {
            $supportedLanguages = $this->translatableHelper->getSupportedLanguages('offer');
            if (is_array($supportedLanguages) && count($supportedLanguages) > 1) {
                $currentLanguage = $this->translatableHelper->getCurrentLanguage();
                $translatableFields = $this->translatableHelper->getTranslatableFields('offer');
                $mandatoryFields = $this->translatableHelper->getMandatoryFields('offer');
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
        
        $builder->add('urlToOfferOnHomepage', UrlType::class, [
            'label' => $this->__('Url to offer on homepage') . ':',
            'label_attr' => [
                'class' => 'tooltips',
                'title' => $this->__('If there is a special page on your homepage, enter the url here.')
            ],
            'help' => $this->__('If there is a special page on your homepage, enter the url here.'),
            'empty_data' => '',
            'attr' => [
                'maxlength' => 255,
                'class' => ' validate-url',
                'title' => $this->__('Enter the url to offer on homepage of the offer')
            ],
            'required' => false,
        ]);
        
        $builder->add('imageOfOffer', UploadType::class, [
            'label' => $this->__('Image of offer') . ':',
            'attr' => [
                'class' => ' validate-upload',
                'title' => $this->__('Enter the image of offer of the offer')
            ],
            'required' => false && $options['mode'] == 'create',
            'entity' => $options['entity'],
            'allowed_extensions' => 'gif, jpeg, jpg, png',
            'allowed_size' => ''
        ]);
        
        $builder->add('priceOfOffer', MoneyType::class, [
            'label' => $this->__('Price of offer') . ':',
            'label_attr' => [
                'class' => 'tooltips',
                'title' => $this->__('Here you can enter the lower price for this offer.')
            ],
            'help' => $this->__('Here you can enter the lower price for this offer.'),
            'empty_data' => '0.00',
            'attr' => [
                'maxlength' => 15,
                'class' => ' validate-number',
                'title' => $this->__('Enter the price of offer of the offer')
            ],
            'required' => false,
            
            
            'scale' => 2
        ]);
        
        $builder->add('normalPrice', MoneyType::class, [
            'label' => $this->__('Normal price') . ':',
            'label_attr' => [
                'class' => 'tooltips',
                'title' => $this->__('Here you can enter the normal price.')
            ],
            'help' => $this->__('Here you can enter the normal price.'),
            'empty_data' => '0.00',
            'attr' => [
                'maxlength' => 15,
                'class' => ' validate-number',
                'title' => $this->__('Enter the normal price of the offer')
            ],
            'required' => false,
            
            
            'scale' => 2
        ]);
        
        $builder->add('percentOfOffer', PercentType::class, [
            'label' => $this->__('Percent of offer') . ':',
            'label_attr' => [
                'class' => 'tooltips',
                'title' => $this->__('If you enter something here, the informations for the prices will not get shown.')
            ],
            'help' => $this->__('If you enter something here, the informations for the prices will not get shown.'),
            'empty_data' => '',
            'attr' => [
                'maxlength' => 3,
                'class' => ' validate-digits',
                'title' => $this->__('Enter the percent of offer of the offer.') . ' ' . $this->__('Only digits are allowed.')
            ],
            'required' => false,
            'type' => 'integer',
            'scale' => 0
        ]);
        
        $builder->add('effectivFrom', DateTimeType::class, [
            'label' => $this->__('Effectiv from') . ':',
            'label_attr' => [
                'class' => 'tooltips',
                'title' => $this->__('Enter here the date and time for the start of the offer.')
            ],
            'help' => $this->__('Enter here the date and time for the start of the offer.'),
            'empty_data' => '',
            'attr' => [
                'class' => ' validate-daterange-offer',
                'title' => $this->__('Enter the effectiv from of the offer')
            ],
            'required' => true,
            'empty_data' => date('Y-m-d H:i:s'),
            'with_seconds' => true,
            'date_widget' => 'single_text',
            'time_widget' => 'single_text'
        ]);
        
        $builder->add('effectivUntil', DateTimeType::class, [
            'label' => $this->__('Effectiv until') . ':',
            'label_attr' => [
                'class' => 'tooltips',
                'title' => $this->__('Enter here the date and time for the end of the offer.')
            ],
            'help' => $this->__('Enter here the date and time for the end of the offer.'),
            'empty_data' => '',
            'attr' => [
                'class' => ' validate-daterange-offer',
                'title' => $this->__('Enter the effectiv until of the offer')
            ],
            'required' => true,
            'empty_data' => date('Y-m-d H:i:s'),
            'with_seconds' => true,
            'date_widget' => 'single_text',
            'time_widget' => 'single_text'
        ]);
        
        $builder->add('inViewFrom', DateTimeType::class, [
            'label' => $this->__('In view from') . ':',
            'label_attr' => [
                'class' => 'tooltips',
                'title' => $this->__('On this date the offer will get put into the archive.
                if you wish, that the offer is still there after the end, enter none.')
            ],
            'help' => $this->__('On this date the offer will get put into the archive.
            if you wish, that the offer is still there after the end, enter none.'),
            'empty_data' => '',
            'attr' => [
                'class' => ' validate-daterange-offer',
                'title' => $this->__('Enter the in view from of the offer')
            ],
            'required' => false,
            'empty_data' => null,
            'with_seconds' => true,
            'date_widget' => 'single_text',
            'time_widget' => 'single_text'
        ]);
        
        $builder->add('inViewUntil', DateTimeType::class, [
            'label' => $this->__('In view until') . ':',
            'empty_data' => '',
            'attr' => [
                'class' => ' validate-daterange-offer',
                'title' => $this->__('Enter the in view until of the offer')
            ],
            'required' => false,
            'empty_data' => null,
            'with_seconds' => true,
            'date_widget' => 'single_text',
            'time_widget' => 'single_text'
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
        return 'muyourcitymodule_offer';
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                // define class for underlying data (required for embedding forms)
                'data_class' => 'MU\YourCityModule\Entity\OfferEntity',
                'empty_data' => function (FormInterface $form) {
                    return $this->entityFactory->createOffer();
                },
                'error_mapping' => [
                    'imageOfOffer' => 'imageOfOffer.imageOfOffer',
                    'isInViewFromBeforeInViewUntil' => 'inViewFrom',
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
