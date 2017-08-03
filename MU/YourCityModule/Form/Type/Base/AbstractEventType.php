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

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
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
use MU\YourCityModule\Form\Type\Field\GeoType;
use MU\YourCityModule\Form\Type\Field\MultiListType;
use MU\YourCityModule\Form\Type\Field\TranslationType;
use MU\YourCityModule\Form\Type\Field\UploadType;
use Zikula\UsersModule\Form\Type\UserLiveSearchType;
use MU\YourCityModule\Helper\FeatureActivationHelper;
use MU\YourCityModule\Helper\ListEntriesHelper;
use MU\YourCityModule\Helper\TranslatableHelper;

/**
 * Event editing form type base class.
 */
abstract class AbstractEventType extends AbstractType
{
    use TranslatorTrait;

    /**
     * @var EntityFactory
     */
    protected $entityFactory;

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
     * EventType constructor.
     *
     * @param TranslatorInterface $translator     Translator service instance
     * @param EntityFactory $entityFactory EntityFactory service instance
     * @param VariableApiInterface $variableApi VariableApi service instance
     * @param TranslatableHelper $translatableHelper TranslatableHelper service instance
     * @param ListEntriesHelper $listHelper ListEntriesHelper service instance
     * @param FeatureActivationHelper $featureActivationHelper FeatureActivationHelper service instance
     */
    public function __construct(
        TranslatorInterface $translator,
        EntityFactory $entityFactory,
        VariableApiInterface $variableApi,
        TranslatableHelper $translatableHelper,
        ListEntriesHelper $listHelper,
        FeatureActivationHelper $featureActivationHelper
    ) {
        $this->setTranslator($translator);
        $this->entityFactory = $entityFactory;
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
        $this->addModerationFields($builder, $options);
        $this->addReturnControlField($builder, $options);
        $this->addSubmitButtons($builder, $options);

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $entity = $event->getData();
            foreach (['imageOfEvent'] as $uploadFieldName) {
                $entity[$uploadFieldName] = [
                    $uploadFieldName => $entity[$uploadFieldName] instanceof File ? $entity[$uploadFieldName]->getPathname() : null
                ];
            }
        });
        $builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
            $entity = $event->getData();
            foreach (['imageOfEvent'] as $uploadFieldName) {
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
            'label_attr' => [
                'class' => 'tooltips',
                'title' => $this->__('Maximum 100 characters; better only 57 for SEO.')
            ],
            'help' => $this->__('Maximum 100 characters; better only 57 for SEO.'),
            'empty_data' => '',
            'attr' => [
                'maxlength' => 100,
                'class' => '',
                'title' => $this->__('Enter the name of the event')
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
                'title' => $this->__('Enter the description of the event')
            ],
            'required' => false,
        ]);
        
        if ($this->variableApi->getSystemVar('multilingual') && $this->featureActivationHelper->isEnabled(FeatureActivationHelper::TRANSLATIONS, 'event')) {
            $supportedLanguages = $this->translatableHelper->getSupportedLanguages('event');
            if (is_array($supportedLanguages) && count($supportedLanguages) > 1) {
                $currentLanguage = $this->translatableHelper->getCurrentLanguage();
                $translatableFields = $this->translatableHelper->getTranslatableFields('event');
                $mandatoryFields = $this->translatableHelper->getMandatoryFields('event');
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
        
        $builder->add('imageOfEvent', UploadType::class, [
            'label' => $this->__('Image of event') . ':',
            'attr' => [
                'class' => ' validate-upload',
                'title' => $this->__('Enter the image of event of the event')
            ],
            'required' => false && $options['mode'] == 'create',
            'entity' => $options['entity'],
            'allowed_extensions' => 'gif, jpeg, jpg, png',
            'allowed_size' => '200KB'
        ]);
        
        $listEntries = $this->listHelper->getEntries('event', 'kindOfEvent');
        $choices = [];
        $choiceAttributes = [];
        foreach ($listEntries as $entry) {
            $choices[$entry['text']] = $entry['value'];
            $choiceAttributes[$entry['text']] = ['title' => $entry['title']];
        }
        $builder->add('kindOfEvent', MultiListType::class, [
            'label' => $this->__('Kind of event') . ':',
            'empty_data' => 'other',
            'attr' => [
                'class' => '',
                'title' => $this->__('Choose the kind of event')
            ],
            'required' => true,
            'choices' => $choices,
            'choices_as_values' => true,
            'choice_attr' => $choiceAttributes,
            'multiple' => true,
            'expanded' => false
        ]);
        
        $builder->add('street', TextType::class, [
            'label' => $this->__('Street') . ':',
            'empty_data' => '',
            'attr' => [
                'maxlength' => 255,
                'class' => '',
                'title' => $this->__('Enter the street of the event')
            ],
            'required' => false,
        ]);
        
        $builder->add('numberOfStreet', TextType::class, [
            'label' => $this->__('Number of street') . ':',
            'empty_data' => '',
            'attr' => [
                'maxlength' => 255,
                'class' => '',
                'title' => $this->__('Enter the number of street of the event')
            ],
            'required' => false,
        ]);
        
        $builder->add('zipCode', TextType::class, [
            'label' => $this->__('Zip code') . ':',
            'empty_data' => '',
            'attr' => [
                'maxlength' => 255,
                'class' => '',
                'title' => $this->__('Enter the zip code of the event')
            ],
            'required' => true,
        ]);
        
        $builder->add('city', TextType::class, [
            'label' => $this->__('City') . ':',
            'empty_data' => '',
            'attr' => [
                'maxlength' => 255,
                'class' => '',
                'title' => $this->__('Enter the city of the event')
            ],
            'required' => true,
        ]);
        
        $builder->add('startDate', DateTimeType::class, [
            'label' => $this->__('Start date') . ':',
            'empty_data' => '',
            'attr' => [
                'class' => ' validate-daterange-event',
                'title' => $this->__('Enter the start date of the event')
            ],
            'required' => true,
            'empty_data' => date('Y-m-d H:i:s'),
            'with_seconds' => true,
            'date_widget' => 'single_text',
            'time_widget' => 'single_text'
        ]);
        
        $builder->add('endDate', DateTimeType::class, [
            'label' => $this->__('End date') . ':',
            'empty_data' => '',
            'attr' => [
                'class' => ' validate-daterange-event',
                'title' => $this->__('Enter the end date of the event')
            ],
            'required' => true,
            'empty_data' => date('Y-m-d H:i:s'),
            'with_seconds' => true,
            'date_widget' => 'single_text',
            'time_widget' => 'single_text'
        ]);
        
        $builder->add('start2Date', DateTimeType::class, [
            'label' => $this->__('Start 2 date') . ':',
            'empty_data' => '',
            'attr' => [
                'class' => ' validate-daterange-event',
                'title' => $this->__('Enter the start 2 date of the event')
            ],
            'required' => false,
            'empty_data' => null,
            'with_seconds' => true,
            'date_widget' => 'single_text',
            'time_widget' => 'single_text'
        ]);
        
        $builder->add('end2Date', DateTimeType::class, [
            'label' => $this->__('End 2 date') . ':',
            'empty_data' => '',
            'attr' => [
                'class' => ' validate-daterange-event',
                'title' => $this->__('Enter the end 2 date of the event')
            ],
            'required' => false,
            'empty_data' => null,
            'with_seconds' => true,
            'date_widget' => 'single_text',
            'time_widget' => 'single_text'
        ]);
        
        $builder->add('inViewFrom', DateTimeType::class, [
            'label' => $this->__('In view from') . ':',
            'label_attr' => [
                'class' => 'tooltips',
                'title' => $this->__('Here you can enter the date and time from this event will appear in the overview of events.
                Then it will get put into the archive. Then you only are able to reuse it as model.
                If you do not enter a value, this event will be shown further after the end.')
            ],
            'help' => $this->__('Here you can enter the date and time from this event will appear in the overview of events.
            Then it will get put into the archive. Then you only are able to reuse it as model.
            If you do not enter a value, this event will be shown further after the end.'),
            'empty_data' => '',
            'attr' => [
                'class' => ' validate-daterange-event',
                'title' => $this->__('Enter the in view from of the event')
            ],
            'required' => false,
            'empty_data' => null,
            'with_seconds' => true,
            'date_widget' => 'single_text',
            'time_widget' => 'single_text'
        ]);
        
        $builder->add('inViewUntil', DateTimeType::class, [
            'label' => $this->__('In view until') . ':',
            'label_attr' => [
                'class' => 'tooltips',
                'title' => $this->__('Here you can enter the date and time until this event will appear in the overview of events.
                Then it will get put into the archive. Then you only are able to reuse it as model.
                If you do not enter a value, this event will be shown further after the end.')
            ],
            'help' => $this->__('Here you can enter the date and time until this event will appear in the overview of events.
            Then it will get put into the archive. Then you only are able to reuse it as model.
            If you do not enter a value, this event will be shown further after the end.'),
            'empty_data' => '',
            'attr' => [
                'class' => ' validate-daterange-event',
                'title' => $this->__('Enter the in view until of the event')
            ],
            'required' => false,
            'empty_data' => null,
            'with_seconds' => true,
            'date_widget' => 'single_text',
            'time_widget' => 'single_text'
        ]);
        
        $listEntries = $this->listHelper->getEntries('event', 'myLocation');
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
        $this->addGeographicalFields($builder, $options);
    }

    /**
     * Adds fields for coordinates.
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array                $options The options
     */
    public function addGeographicalFields(FormBuilderInterface $builder, array $options)
    {
        $builder->add('latitude', GeoType::class, [
            'label' => $this->__('Latitude') . ':',
            'attr' => [
                'class' => 'validate-number'
            ],
            'required' => false
        ]);
        $builder->add('longitude', GeoType::class, [
            'label' => $this->__('Longitude') . ':',
            'attr' => [
                'class' => 'validate-number'
            ],
            'required' => false
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
    
        $builder->add('moderationSpecificCreator', UserLiveSearchType::class, [
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
        return 'muyourcitymodule_event';
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                // define class for underlying data (required for embedding forms)
                'data_class' => 'MU\YourCityModule\Entity\EventEntity',
                'empty_data' => function (FormInterface $form) {
                    return $this->entityFactory->createEvent();
                },
                'error_mapping' => [
                    'isKindOfEventValueAllowed' => 'kindOfEvent',
                    'imageOfEvent' => 'imageOfEvent.imageOfEvent',
                    'isInViewFromBeforeInViewUntil' => 'inViewFrom',
                ],
                'mode' => 'create',
                'actions' => [],
                'has_moderate_permission' => false,
                'translations' => [],
            ])
            ->setRequired(['entity', 'mode', 'actions'])
            ->setAllowedTypes('mode', 'string')
            ->setAllowedTypes('actions', 'array')
            ->setAllowedTypes('has_moderate_permission', 'bool')
            ->setAllowedTypes('translations', 'array')
            ->setAllowedValues('mode', ['create', 'edit'])
        ;
    }
}
