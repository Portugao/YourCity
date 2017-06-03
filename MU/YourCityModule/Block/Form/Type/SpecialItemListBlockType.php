<?php
/**
 * YourCity.
 *
 * @copyright Michael Ueberschaer (MU)
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @author Michael Ueberschaer <info@homepages-mit-zikula.de>.
 * @link https://homepages-mit-zikula.de
 * @link http://zikula.org
 * @version Generated by ModuleStudio (http://modulestudio.de).
 */

namespace MU\YourCityModule\Block\Form\Type;

use MU\YourCityModule\Block\Form\Type\Base\AbstractSpecialItemListBlockType;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * List block form type implementation class.
 */
class SpecialItemListBlockType extends AbstractSpecialItemListBlockType
{
    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->addObjectTypeField($builder, $options);
        $this->addSortingField($builder, $options);
        $this->addAmountField($builder, $options);
        $this->addTemplateFields($builder, $options);
        $this->addFilterField($builder, $options);
        $this->addOptionFields($builder, $options);
    }
    
    /**
     * Adds a sorting field.
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array                $options The options
     */
    public function addOptionFields(FormBuilderInterface $builder, array $options)
    {
    	$builder->add('branch', ChoiceType::class, [
    			'label' => $this->__('Branch') . ':',
    			'empty_data' => 'default',
    			'choices' => [
    					$this->__('Slide') => 'slide',
    					$this->__('Fade') => 'fade'
    			],
    			'choices_as_values' => true,
    			'multiple' => false,
    			'expanded' => false,
    			'required' => false
    	]);
    	$builder->add('part', ChoiceType::class, [
    			'label' => $this->__('Part') . ':',
    			'empty_data' => 'default',
    			'choices' => [
    					$this->__('Slide') => 'slide',
    					$this->__('Fade') => 'fade'
    			],
    			'choices_as_values' => true,
    			'multiple' => false,
    			'expanded' => false,
    			'required' => false
    	]);

    }
}