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
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Zikula\Common\Translator\TranslatorInterface;
use Zikula\Common\Translator\TranslatorTrait;
use MU\YourCityModule\Entity\Factory\EntityFactory;
use Zikula\UsersModule\Form\Type\UserLiveSearchType;
use MU\YourCityModule\Helper\CollectionFilterHelper;
use MU\YourCityModule\Helper\EntityDisplayHelper;
use MU\YourCityModule\Helper\FeatureActivationHelper;
use MU\YourCityModule\Helper\ListEntriesHelper;

/**
 * Abonnement editing form type base class.
 */
abstract class AbstractAbonnementType extends AbstractType
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
     * @var ListEntriesHelper
     */
    protected $listHelper;

    /**
     * @var FeatureActivationHelper
     */
    protected $featureActivationHelper;

    /**
     * AbonnementType constructor.
     *
     * @param TranslatorInterface $translator    Translator service instance
     * @param EntityFactory $entityFactory EntityFactory service instance
     * @param CollectionFilterHelper $collectionFilterHelper CollectionFilterHelper service instance
     * @param EntityDisplayHelper $entityDisplayHelper EntityDisplayHelper service instance
     * @param ListEntriesHelper $listHelper ListEntriesHelper service instance
     * @param FeatureActivationHelper $featureActivationHelper FeatureActivationHelper service instance
     */
    public function __construct(
        TranslatorInterface $translator,
        EntityFactory $entityFactory,
        CollectionFilterHelper $collectionFilterHelper,
        EntityDisplayHelper $entityDisplayHelper,
        ListEntriesHelper $listHelper,
        FeatureActivationHelper $featureActivationHelper
    ) {
        $this->setTranslator($translator);
        $this->entityFactory = $entityFactory;
        $this->collectionFilterHelper = $collectionFilterHelper;
        $this->entityDisplayHelper = $entityDisplayHelper;
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
                'title' => $this->__('Enter the name of the location, you subscribe to.')
            ],
            'help' => $this->__('Enter the name of the location, you subscribe to.'),
            'empty_data' => 'Abonnement',
            'attr' => [
                'maxlength' => 255,
                'class' => '',
                'title' => $this->__('Enter the name of the abonnement')
            ],
            'required' => false,
        ]);
        
        $builder->add('showMenus', CheckboxType::class, [
            'label' => $this->__('Show menus') . ':',
            'attr' => [
                'class' => '',
                'title' => $this->__('show menus ?')
            ],
            'required' => false,
        ]);
        
        $builder->add('sendMessageForMenus', CheckboxType::class, [
            'label' => $this->__('Send message for menus') . ':',
            'attr' => [
                'class' => '',
                'title' => $this->__('send message for menus ?')
            ],
            'required' => false,
        ]);
        
        $builder->add('showOffers', CheckboxType::class, [
            'label' => $this->__('Show offers') . ':',
            'attr' => [
                'class' => '',
                'title' => $this->__('show offers ?')
            ],
            'required' => false,
        ]);
        
        $builder->add('sendMessageForOffers', CheckboxType::class, [
            'label' => $this->__('Send message for offers') . ':',
            'attr' => [
                'class' => '',
                'title' => $this->__('send message for offers ?')
            ],
            'required' => false,
        ]);
        
        $builder->add('showEvents', CheckboxType::class, [
            'label' => $this->__('Show events') . ':',
            'attr' => [
                'class' => '',
                'title' => $this->__('show events ?')
            ],
            'required' => false,
        ]);
        
        $builder->add('sendMessageForEvents', CheckboxType::class, [
            'label' => $this->__('Send message for events') . ':',
            'attr' => [
                'class' => '',
                'title' => $this->__('send message for events ?')
            ],
            'required' => false,
        ]);
        
        $builder->add('showProducts', CheckboxType::class, [
            'label' => $this->__('Show products') . ':',
            'attr' => [
                'class' => '',
                'title' => $this->__('show products ?')
            ],
            'required' => false,
        ]);
        
        $builder->add('sendMessageForProducts', CheckboxType::class, [
            'label' => $this->__('Send message for products') . ':',
            'attr' => [
                'class' => '',
                'title' => $this->__('send message for products ?')
            ],
            'required' => false,
        ]);
        
        $builder->add('showOptionOne', CheckboxType::class, [
            'label' => $this->__('Show option one') . ':',
            'attr' => [
                'class' => '',
                'title' => $this->__('show option one ?')
            ],
            'required' => false,
        ]);
        
        $builder->add('sendMessageToOptionOne', CheckboxType::class, [
            'label' => $this->__('Send message to option one') . ':',
            'attr' => [
                'class' => '',
                'title' => $this->__('send message to option one ?')
            ],
            'required' => false,
        ]);
        
        $builder->add('showOptionTwo', CheckboxType::class, [
            'label' => $this->__('Show option two') . ':',
            'attr' => [
                'class' => '',
                'title' => $this->__('show option two ?')
            ],
            'required' => false,
        ]);
        
        $builder->add('sendMessageToOptionTwo', CheckboxType::class, [
            'label' => $this->__('Send message to option two') . ':',
            'attr' => [
                'class' => '',
                'title' => $this->__('send message to option two ?')
            ],
            'required' => false,
        ]);
        
        $builder->add('showOptionThree', CheckboxType::class, [
            'label' => $this->__('Show option three') . ':',
            'attr' => [
                'class' => '',
                'title' => $this->__('show option three ?')
            ],
            'required' => false,
        ]);
        
        $builder->add('sendMessageToOptionThree', CheckboxType::class, [
            'label' => $this->__('Send message to option three') . ':',
            'attr' => [
                'class' => '',
                'title' => $this->__('send message to option three ?')
            ],
            'required' => false,
        ]);
        
        $builder->add('positionOfAbo', IntegerType::class, [
            'label' => $this->__('Position of abo') . ':',
            'empty_data' => '0',
            'attr' => [
                'maxlength' => 11,
                'class' => '',
                'title' => $this->__('Enter the position of abo of the abonnement.') . ' ' . $this->__('Only digits are allowed.')
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
        return 'muyourcitymodule_abonnement';
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                // define class for underlying data (required for embedding forms)
                'data_class' => 'MU\YourCityModule\Entity\AbonnementEntity',
                'empty_data' => function (FormInterface $form) {
                    return $this->entityFactory->createAbonnement();
                },
                'error_mapping' => [
                ],
                'mode' => 'create',
                'actions' => [],
                'has_moderate_permission' => false,
                'filter_by_ownership' => true,
                'inline_usage' => false
            ])
            ->setRequired(['mode', 'actions'])
            ->setAllowedTypes('mode', 'string')
            ->setAllowedTypes('actions', 'array')
            ->setAllowedTypes('has_moderate_permission', 'bool')
            ->setAllowedTypes('filter_by_ownership', 'bool')
            ->setAllowedTypes('inline_usage', 'bool')
            ->setAllowedValues('mode', ['create', 'edit'])
        ;
    }
}
