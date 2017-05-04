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
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
     * ImportType constructor.
     *
     * @param TranslatorInterface      $translator      Translator service instance
     */
    public function __construct(
        TranslatorInterface $translator
    ) {
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
        /*$this->addGeneralSettingsFields($builder, $options);
        $this->addModerationFields($builder, $options);
        $this->addListViewsFields($builder, $options);
        $this->addImagesFields($builder, $options);
        $this->addIntegrationFields($builder, $options);
        $this->addGeoFields($builder, $options);*/

        $builder
            ->add('import', SubmitType::class, [
                'label' => $this->__('Import old entries'),
                'icon' => 'fa-check',
                'attr' => [
                    'class' => 'btn btn-success'
                ]
            ])
            ->add('cancel', SubmitType::class, [
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
        return 'muyourcitymodule_import';
    }
}