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

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Zikula\Common\Translator\TranslatorInterface;
use Zikula\Common\Translator\TranslatorTrait;
use Zikula\GroupsModule\Entity\RepositoryInterface\GroupRepositoryInterface;

/**
 * Configuration form type base class.
 */
abstract class AbstractImportType extends AbstractType
{
    use TranslatorTrait;

    /**
     * @var array
     */
    protected $moduleVars;

    /**
     * ConfigType constructor.
     *
     * @param TranslatorInterface      $translator      Translator service instance
     * @param object                   $moduleVars      Existing module vars
     * @param GroupRepositoryInterface $groupRepository GroupRepository service instance
     */
    public function __construct(
        TranslatorInterface $translator,
        $moduleVars,
        GroupRepositoryInterface $groupRepository
    ) {
        $this->setTranslator($translator);
        $this->moduleVars = $moduleVars;

        foreach (['moderationGroupForLocations'] as $groupFieldName) {
            $groupId = intval($this->moduleVars[$groupFieldName]);
            if ($groupId < 1) {
                $groupId = 2; // fallback to admin group
            }
            $this->moduleVars[$groupFieldName] = $groupRepository->find($groupId);
        }
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
        $this->addGeneralSettingsFields($builder, $options);
        $this->addModerationFields($builder, $options);
        $this->addListViewsFields($builder, $options);
        $this->addImagesFields($builder, $options);
        $this->addIntegrationFields($builder, $options);
        $this->addGeoFields($builder, $options);

        $builder
            ->add('save', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', [
                'label' => $this->__('Import'),
                'icon' => 'fa-check',
                'attr' => [
                    'class' => 'btn btn-success'
                ]
            ])
            ->add('cancel', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', [
                'label' => $this->__('Cancel'),
                'icon' => 'fa-times',
                'attr' => [
                    'class' => 'btn btn-default',
                    'formnovalidate' => 'formnovalidate'
                ]
            ])
        ;
    }

    /**
     * @inheritDoc
     */
    public function getBlockPrefix()
    {
        return 'muyourcitymodule_config';
    }
}
