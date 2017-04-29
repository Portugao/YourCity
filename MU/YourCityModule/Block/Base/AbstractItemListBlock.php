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

namespace MU\YourCityModule\Block\Base;

use Zikula\BlocksModule\AbstractBlockHandler;
use Zikula\Core\AbstractBundle;
use MU\YourCityModule\Helper\FeatureActivationHelper;

/**
 * Generic item list block base class.
 */
abstract class AbstractItemListBlock extends AbstractBlockHandler
{
    /**
     * List of object types allowing categorisation.
     *
     * @var array
     */
    protected $categorisableObjectTypes;
    
    /**
     * ItemListBlock constructor.
     *
     * @param AbstractBundle $bundle An AbstractBundle instance
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(AbstractBundle $bundle)
    {
        parent::__construct($bundle);
    
        $this->categorisableObjectTypes = ['location', 'dish', 'event', 'product'];
    }
    
    /**
     * Display the block content.
     *
     * @param array $properties The block properties array
     *
     * @return array|string
     */
    public function display(array $properties)
    {
        // only show block content if the user has the required permissions
        if (!$this->hasPermission('MUYourCityModule:ItemListBlock:', "$properties[title]::", ACCESS_OVERVIEW)) {
            return false;
        }
    
        // set default values for all params which are not properly set
        $defaults = $this->getDefaults();
        $properties = array_merge($defaults, $properties);
    
        $featureActivationHelper = $this->get('mu_yourcity_module.feature_activation_helper');
        if ($featureActivationHelper->isEnabled(FeatureActivationHelper::CATEGORIES, $properties['objectType'])) {
            $properties = $this->resolveCategoryIds($properties);
        }
    
        $controllerHelper = $this->get('mu_yourcity_module.controller_helper');
        $contextArgs = ['name' => 'list'];
        if (!isset($properties['objectType']) || !in_array($properties['objectType'], $controllerHelper->getObjectTypes('block', $contextArgs))) {
            $properties['objectType'] = $controllerHelper->getDefaultObjectType('block', $contextArgs);
        }
    
        $objectType = $properties['objectType'];
    
        $repository = $this->get('mu_yourcity_module.entity_factory')->getRepository($objectType);
    
        // create query
        $orderBy = $this->get('mu_yourcity_module.model_helper')->resolveSortParameter($objectType, $properties['sorting']);
        $qb = $repository->genericBaseQuery($properties['filter'], $orderBy);
    
        // fetch category registries
        $catProperties = null;
        if (in_array($objectType, $this->categorisableObjectTypes)) {
            if ($featureActivationHelper->isEnabled(FeatureActivationHelper::CATEGORIES, $properties['objectType'])) {
                $categoryHelper = $this->get('mu_yourcity_module.category_helper');
                $catProperties = $categoryHelper->getAllProperties($objectType);
                // apply category filters
                if (is_array($properties['catIds']) && count($properties['catIds']) > 0) {
                    $qb = $categoryHelper->buildFilterClauses($qb, $objectType, $properties['catIds']);
                }
            }
        }
    
        // get objects from database
        $currentPage = 1;
        $resultsPerPage = $properties['amount'];
        $query = $repository->getSelectWherePaginatedQuery($qb, $currentPage, $resultsPerPage);
        list($entities, $objectCount) = $repository->retrieveCollectionResult($query, true);
    
        if ($featureActivationHelper->isEnabled(FeatureActivationHelper::CATEGORIES, $objectType)) {
            $entities = $this->get('mu_yourcity_module.category_helper')->filterEntitiesByPermission($entities);
        }
    
        // set a block title
        if (empty($properties['title'])) {
            $properties['title'] = $this->__('MUYourCityModule items');
        }
    
        $template = $this->getDisplayTemplate($properties);
    
        $templateParameters = [
            'vars' => $properties,
            'objectType' => $objectType,
            'items' => $entities
        ];
        if ($featureActivationHelper->isEnabled(FeatureActivationHelper::CATEGORIES, $properties['objectType'])) {
            $templateParameters['properties'] = $properties;
        }
    
        $templateParameters = $this->get('mu_yourcity_module.controller_helper')->addTemplateParameters($properties['objectType'], $templateParameters, 'block', []);
    
        return $this->renderView($template, $templateParameters);
    }
    
    /**
     * Returns the template used for output.
     *
     * @param array $properties The block properties array
     *
     * @return string the template path
     */
    protected function getDisplayTemplate(array $properties)
    {
        $templateFile = $properties['template'];
        if ($templateFile == 'custom') {
            $templateFile = $properties['customTemplate'];
        }
    
        $templateForObjectType = str_replace('itemlist_', 'itemlist_' . $properties['objectType'] . '_', $templateFile);
        $templating = $this->get('templating');
    
        $templateOptions = [
            'ContentType/' . $templateForObjectType,
            'Block/' . $templateForObjectType,
            'ContentType/' . $templateFile,
            'Block/' . $templateFile,
            'Block/itemlist.html.twig'
        ];
    
        $template = '';
        foreach ($templateOptions as $templatePath) {
            if ($templating->exists('@MUYourCityModule/' . $templatePath)) {
                $template = '@MUYourCityModule/' . $templatePath;
                break;
            }
        }
    
        return $template;
    }
    
    /**
     * Returns the fully qualified class name of the block's form class.
     *
     * @return string Template path
     */
    public function getFormClassName()
    {
        return 'MU\YourCityModule\Block\Form\Type\ItemListBlockType';
    }
    
    /**
     * Returns any array of form options.
     *
     * @return array Options array
     */
    public function getFormOptions()
    {
        $objectType = 'location';
    
        $request = $this->get('request_stack')->getCurrentRequest();
        if ($request->attributes->has('blockEntity')) {
            $blockEntity = $request->attributes->get('blockEntity');
            if (is_object($blockEntity) && method_exists($blockEntity, 'getContent')) {
                $blockProperties = $blockEntity->getContent();
                if (isset($blockProperties['objectType'])) {
                    $objectType = $blockProperties['objectType'];
                }
            }
        }
    
        return [
            'object_type' => $objectType,
            'is_categorisable' => in_array($objectType, $this->categorisableObjectTypes),
            'category_helper' => $this->get('mu_yourcity_module.category_helper'),
            'feature_activation_helper' => $this->get('mu_yourcity_module.feature_activation_helper')
        ];
    }
    
    /**
     * Returns the template used for rendering the editing form.
     *
     * @return string Template path
     */
    public function getFormTemplate()
    {
        return '@MUYourCityModule/Block/itemlist_modify.html.twig';
    }
    
    /**
     * Returns default settings for this block.
     *
     * @return array The default settings
     */
    protected function getDefaults()
    {
        $defaults = [
            'objectType' => 'location',
            'sorting' => 'default',
            'amount' => 5,
            'template' => 'itemlist_display.html.twig',
            'customTemplate' => '',
            'filter' => ''
        ];
    
        return $defaults;
    }
    
    
    /**
     * Resolves category filter ids.
     *
     * @param array $properties The block properties array
     *
     * @return array The updated block properties
     */
    protected function resolveCategoryIds(array $properties)
    {
        if (!isset($properties['catIds'])) {
            $categoryHelper = $this->get('mu_yourcity_module.category_helper');
            $primaryRegistry = $categoryHelper->getPrimaryProperty($properties['objectType']);
            $properties['catIds'] = [$primaryRegistry => []];
        } elseif (!is_array($properties['catIds'])) {
            $properties['catIds'] = explode(',', $properties['catIds']);
        }
    
        return $properties;
    }
}
