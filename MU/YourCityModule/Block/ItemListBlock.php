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

namespace MU\YourCityModule\Block;

use MU\YourCityModule\Block\Base\AbstractItemListBlock;

/**
 * Generic item list block implementation class.
 */
class ItemListBlock extends AbstractItemListBlock
{
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
    
        $controllerHelper = $this->get('mu_yourcity_module.controller_helper');
        $contextArgs = ['name' => 'list'];
        if (!isset($properties['objectType']) || !in_array($properties['objectType'], $controllerHelper->getObjectTypes('block', $contextArgs))) {
            $properties['objectType'] = $controllerHelper->getDefaultObjectType('block', $contextArgs);
        }
    
        $objectType = $properties['objectType'];
    
        $repository = $this->get('mu_yourcity_module.entity_factory')->getRepository($objectType);
       	
        // create query
        $orderBy = $this->get('mu_yourcity_module.model_helper')->resolveSortParameter($objectType, $properties['sorting']);

        if ($objectType != 'location') {        
        $qb = $repository->genericBaseQuery($properties['filter'], $orderBy);
    
        // get objects from database
        $currentPage = 1;
        $resultsPerPage = $properties['amount'];
        $query = $repository->getSelectWherePaginatedQuery($qb, $currentPage, $resultsPerPage);
        list($entities, $objectCount) = $repository->retrieveCollectionResult($query, true);
        } else {
        	$variableApi = $this->get('zikula_extensions_module.api.variable');
        	//$locations = $repository->selectWhere('', 'id ASC', false, true);
        	$ids = array();
        	$arr = array();
        	/*foreach ($locations as $location) {
        		$ids[] = $location['id'];
        	}*/
        	$ids = $variableApi->get('MUYourCityModule', 'locationIds');
        	$ids = explode(',', $ids);
        	$count = count($ids);
        	$i = 0;        	
        	if ($orderBy == 'RAND()') {
        	    while ($i < $properties['amount']) {
        			$rand = mt_rand(0, $count - 1);
        			if (!in_array($ids[$rand], $arr)) {
        				$arr[] = $ids[$rand];
        				$i++;
        			}
        		}
        		$where = 'tbl.id IN ('.implode(',', $arr).')';
        		$entities = $repository->selectWhere($where);
        	}
        	if ($orderBy == 'id DESC') {
        		arsort($ids);
        		$counter = 0;
        		foreach ($ids as $id) {
        			if ($counter < $properties['amount']) {
        			$arr[] = $id;
        			}
        			$counter = $counter + 1;
        		}
        	    /*while ($i < $properties['amount']) {
        			$arr[] = $ids[$i];
        			$i++;
        		}*/
        		//$arr = implode(',', $arr);
        		$where = 'tbl.id IN ('.implode(',', $arr).')';
        		$entities = $repository->selectWhere($where, $orderBy);
        		}
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
    
        $templateParameters = $this->get('mu_yourcity_module.controller_helper')->addTemplateParameters($properties['objectType'], $templateParameters, 'block', []);
    
        return $this->renderView($template, $templateParameters);
    }
}
