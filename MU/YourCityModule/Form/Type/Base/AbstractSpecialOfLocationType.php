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
 * Special of location editing form type base class.
 */
abstract class AbstractSpecialOfLocationType extends AbstractType
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
     * SpecialOfLocationType constructor.
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
        $this->addModerationFields($builder, $options);
        $this->addReturnControlField($builder, $options);
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
                'title' => $this->__('Only 100 characters, better only 57.')
            ],
            'help' => $this->__('Only 100 characters, better only 57.'),
            'empty_data' => '',
            'attr' => [
                'maxlength' => 100,
                'class' => '',
                'title' => $this->__('Enter the name of the special of location')
            ],
            'required' => true,
        ]);
        
        $builder->add('descriptionForGoogle', TextType::class, [
            'label' => $this->__('Description for google') . ':',
            'empty_data' => '',
            'attr' => [
                'maxlength' => 255,
                'class' => '',
                'title' => $this->__('Enter the description for google of the special of location')
            ],
            'required' => false,
        ]);
        
        $builder->add('description', TextareaType::class, [
            'label' => $this->__('Description') . ':',
            'label_attr' => [
                'class' => 'tooltips',
                'title' => $this->__('Only 2000 characters.')
            ],
            'help' => [$this->__('Only 2000 characters.'), $this->__f('Note: this value must not exceed %amount% characters.', ['%amount%' => 2000])],
            'empty_data' => '',
            'attr' => [
                'maxlength' => 2000,
                'class' => '',
                'title' => $this->__('Enter the description of the special of location')
            ],
            'required' => false,
        ]);
        
        if ($this->variableApi->getSystemVar('multilingual') && $this->featureActivationHelper->isEnabled(FeatureActivationHelper::TRANSLATIONS, 'specialOfLocation')) {
            $supportedLanguages = $this->translatableHelper->getSupportedLanguages('specialOfLocation');
            if (is_array($supportedLanguages) && count($supportedLanguages) > 1) {
                $currentLanguage = $this->translatableHelper->getCurrentLanguage();
                $translatableFields = $this->translatableHelper->getTranslatableFields('specialOfLocation');
                $mandatoryFields = $this->translatableHelper->getMandatoryFields('specialOfLocation');
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
        
        $builder->add('iconForSpecial', TextType::class, [
            'label' => $this->__('Icon for special') . ':',
            'label_attr' => [
                'class' => 'tooltips',
                'title' => $this->__('Enter a bootstrap icon.')
            ],
            'help' => $this->__('Enter a bootstrap icon.'),
            'empty_data' => '',
            'attr' => [
                'maxlength' => 255,
                'class' => '',
                'title' => $this->__('Enter the icon for special of the special of location')
            ],
            'required' => false,
        ]);
        
        $builder->add('colorOfIcon', TextType::class, [
            'label' => $this->__('Color of icon') . ':',
            'empty_data' => '#ff0000',
            'attr' => [
                'maxlength' => 255,
                'class' => '',
                'title' => $this->__('Enter the color of icon of the special of location')
            ],
            'required' => false,
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
        if ($options['inline_usage']) {
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
        return 'muyourcitymodule_specialoflocation';
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                // define class for underlying data (required for embedding forms)
                'data_class' => 'MU\YourCityModule\Entity\SpecialOfLocationEntity',
                'empty_data' => function (FormInterface $form) {
                    return $this->entityFactory->createSpecialOfLocation();
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
