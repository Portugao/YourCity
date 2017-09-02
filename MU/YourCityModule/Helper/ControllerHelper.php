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

namespace MU\YourCityModule\Helper;

use MU\YourCityModule\Helper\Base\AbstractControllerHelper;

use Zikula\Component\SortableColumns\SortableColumns;
use Zikula\Core\RouteUrl;
use Zikula\UsersModule\Entity\UserEntity;
use DataUtil;
use DateUtil;
use Doctrine\Common\Collections\Criteria;

/**
 * Helper implementation class for controller layer methods.
 */
class ControllerHelper extends AbstractControllerHelper
{    
    /**
     * Processes the parameters for a display action.
     *
     * @param string  $objectType         Name of treated entity type
     * @param array   $templateParameters Template data
     * @param boolean $supportsHooks      Whether hooks are supported or not
     *
     * @return array Enriched template parameters used for creating the response
     */
    public function processDisplayActionParameters($objectType, array $templateParameters = [], $supportsHooks = false)
    {
    	$contextArgs = ['controller' => $objectType, 'action' => 'display'];
    	if (!in_array($objectType, $this->getObjectTypes('controllerAction', $contextArgs))) {
    		throw new Exception($this->__('Error! Invalid object type received.'));
    	}
    
    	if (true === $supportsHooks) {
    		// build RouteUrl instance for display hooks
    		$entity = $templateParameters[$objectType];
    		$urlParameters = $entity->createUrlArgs();
    		$urlParameters['_locale'] = $this->request->getLocale();
    		$templateParameters['currentUrlObject'] = new RouteUrl('muyourcitymodule_' . $objectType . '_' . /*$templateParameters['routeArea'] . */'display', $urlParameters);
    	}
    	
    	$entity = $templateParameters[$objectType];
    	// we get different repositoriess
    	$locationRepository = $this->modelHelper->getRepository('location');
    	$eventRepository = $this->modelHelper->getRepository('event');
    	$menuRepository = $this->modelHelper->getRepository('menuOfLocation');
    	$offerRepository = $this->modelHelper->getRepository('offer');
    	$productRepository = $this->modelHelper->getRepository('product');
    	
    	if ($objectType == 'branch' || $objectType == 'serviceOfLocation' || $objectType == 'specialOfLocation') {
    		$locations = '';
    		$entityLocations = $entity['locations'];
    		$eventRepository = $this->entityFactory->getRepository('event');
    		$menuRepository = $this->entityFactory->getRepository('menuOfLocation');
    		$offerRepository = $this->entityFactory->getRepository('offer');
    		$productRepository = $this->entityFactory->getRepository('product');
    		if (count($entityLocations) > 0) {
    		foreach ($entityLocations as $location) {
    			$events = $eventRepository->findBy(array('myLocation' => $location['id']), array('name' => 'ASC'));
    			if ($events) {
    				$location['isThereEvents'] = 1;
    			} else {
    				$location['isThereEvents'] = 0;
    			}
    			$menus = $menuRepository->findBy(array('myLocation' => $location['id']), array('name' => 'ASC'));
    			if ($menus) {
    				$location['isThereMenus'] = 1;
    			} else {
    				$location['isThereMenus'] = 0;
    			}
    			$offers = $offerRepository->findBy(array('myLocation' => $location['id']), array('name' => 'ASC'));
    			if ($offers) {
    				$location['isThereOffers'] = 1;
    			} else {
    				$location['isThereOffers'] = 0;
    			}
    			$products = $productRepository->findBy(array('myLocation' => $location['id']), array('name' => 'ASC'));
    			if ($products) {
    				$location['isThereProducts'] = 1;
    			} else {
    				$location['isThereProducts'] = 0;
    			}
    			$locations[] = $location;
    		}
    		//if ($locations && is_array($locations)) {
    			//unset($entity['locations']);
    			$entity['locations'] = $locations;
    		//}
    		}
    	}
    	
    	if ($objectType == 'part') {   		
    		//$criteria = array('partOfCity' => $entity['name']);   		
    		$locationsForPart = $locationRepository->findBy(array('partOfCity' => $entity['name']), array('name' => 'ASC'));
    		if (count($locationsForPart) > 0) {
    			foreach ($locationsForPart as $location) {
    				$events = $eventRepository->findBy(array('myLocation' => $location['id']), array('name' => 'ASC'));
    				if ($events) {
    					$location['isThereEvents'] = 1;
    				} else {
    					$location['isThereEvents'] = 0;
    				}
    				$menus = $menuRepository->findBy(array('myLocation' => $location['id']), array('name' => 'ASC'));
    				if ($menus) {
    					$location['isThereMenus'] = 1;
    				} else {
    					$location['isThereMenus'] = 0;
    				}
    				$offers = $offerRepository->findBy(array('myLocation' => $location['id']), array('name' => 'ASC'));
    				if ($offers) {
    					$location['isThereOffers'] = 1;
    				} else {
    					$location['isThereOffers'] = 0;
    				}
    				$products = $productRepository->findBy(array('myLocation' => $location['id']), array('name' => 'ASC'));
    				if ($products) {
    					$location['isThereProducts'] = 1;
    				} else {
    					$location['isThereProducts'] = 0;
    				}
    				$partLocations[] = $location;
    			}
    			//if ($locations && is_array($locations)) {
    			//unset($entity['locations']);
    			//$entity['locations'] = $locations;
    			//}
    		}
    	}
    	
    	if ($objectType == 'location') {
    		//$criteria = array('partOfCity' => $entity['name']);
    		$events = $eventRepository->findBy(array('myLocation' => $entity['id']), array('name' => 'ASC'));
    		if ($events) {
    			$templateParameters[$objectType]['events'] = $events;
    		}
    		$menus = $menuRepository->findBy(array('myLocation' => $entity['id']), array('name' => 'ASC'));
    		if ($menus) {
    			$templateParameters[$objectType]['menus'] = $menus;
    		}
    		$offers = $offerRepository->findBy(array('myLocation' => $entity['id']), array('name' => 'ASC'));
    		if ($offers) {
    			$templateParameters[$objectType]['offers'] = $offers;
    		}
    		$products = $productRepository->findBy(array('myLocation' => $entity['id']), array('name' => 'ASC'));
    		if ($products) {
    			$templateParameters[$objectType]['products'] = $products;
    		}
    	}
    	
    	/*if ($objectType == 'branch') {
    		$criteria = new \Doctrine\Common\Collections\Criteria();
    		$criteria
    		->orWhere($criteria->expr()->contains('branchOfLocation', '###' . $entity['name'] . '###'));
    		$locationsForBranch = $locationRepository->matching($criteria);
    		
    	}
    	if ($objectType == 'serviceOfLocation') {
    		$criteria = new \Doctrine\Common\Collections\Criteria();
    		$criteria
    		->orWhere($criteria->expr()->contains('servicesOfLocation', '###' . $entity['name'] . '###'));
    		$locationsWithService = $locationRepository->matching($criteria);
    	}
    	
    	if ($objectType == 'specialOfLocation') {
    		$criteria = new \Doctrine\Common\Collections\Criteria();
    		$criteria
    		->orWhere($criteria->expr()->contains('specialsOfLocation', '###' . $entity['name'] . '###'));
    		$locationsWithSpecial = $locationRepository->matching($criteria);
    	}*/
    	
    	$actualDay = $this->getActualDay();
    	
    	if ($objectType == 'location') {
    		$location = $entity;
    		$location['showHours'] = 'none';
    		if ($location['closedForEver'] == 1) {
    			$location['state'] = 'closedForEver';
    			$location['showHours'] = $this->__('Closed for ever');
    			//$locations[] = $location;
    		} else {
    			if ($location['agreement'] == 1) {
    				$location['state'] = 'agreement';
    				$location['showHours'] = $this->__('Appointments by agreement');
    				//$locations[] = $location;
    			} else {
    				if ($location['unclearTimes'] == 1) {
    					$location['state'] = 'unclear';
    					$location['showHours'] = $this->__('Unclear opening hours');
    					//$locations[] = $location;
    				} else {
    					if ($location['closedOn' . $actualDay] == 1) {
    						$location['state'] = 'closedThisDay';
    						$location['showHours'] = $this->__('Closed this day');
    						//$locations[] = $location;
    					} else {
    						$location['state'] = $this->checkActualDay($actualDay, $location);
    						$location['realDay'] = $this->checkActualDay($actualDay, $location, 2);
    						$location['showHours'] = $this->checkActualDay($actualDay, $location, 3);
    						//$locations[] = $location;
    					}
    				}
    			}
    		}    		
    	}
    	
    	if ($objectType == 'part' || $objectType == 'branch' || $objectType == 'serviceOfLocation' || $objectType == 'specialOfLocation') {

    		$locations = array();
    		if ($objectType == 'part') {
    			$relevantLocations = $partLocations;
    		}
    		if ($objectType == 'branch') {
    			$relevantLocations = $entity['locations'];
    		}
    		if ($objectType == 'serviceOfLocation') {
    			$relevantLocations = $entity['locations'];
    		}
    		if ($objectType == 'specialOfLocation') {
    			$relevantLocations = $entity['locations'];
    		}
    		foreach ($relevantLocations as $location) {
    			$location['showHours'] = 'none';
    			if ($location['closedForEver'] == 1) {
    				$location['state'] = 'closedForEver';
    				$location['showHours'] = $this->__('Closed forever');
    				$locations[] = $location;    				
    			} else {
    				if ($location['agreement'] == 1) {
    					$location['state'] = 'agreement';
    					
    					$locations[] = $location;
    				} else {
    					if ($location['unclearTimes'] == 1) {
    						$location['state'] = 'unclear';
    						$locations[] = $location;
    					} else {
    						if ($location['closedOn' . $actualDay] == 1) {
    							$location['state'] = 'closedThisDay';
    							$location['showHours'] = $this->__('Today closed');
    							$locations[] = $location;
    						} else {
    							$location = $locationRepository->find($location['id']);
    							$location['state'] = $this->checkActualDay($actualDay, $location);
    							$location['showHours'] = $this->checkActualDay($actualDay, $location, 3);
    							$locations[] = $location;
    						}
    					}
    				}
    			}
    		}
    		if ($objectType != 'part') {
    		foreach ($templateParameters[$objectType]['locations'] as $i => $value) {
    			unset($templateParameters[$objectType]['locations'][$i]);
    		}
    		}
    		if ($objectType != 'part') {
    		$templateParameters[$objectType]['locations'] = $locations;
    		} else {
    			$templateParameters['locations'] = $locations;
    		}
    	} else {
    		if ($objectType == 'location') {
    			$templateParameters[$objectType] = $location;
    		} else {
    		//$templateParameters[$objectType] = $entities;
    		}
    	}
    
    	return $this->addTemplateParameters($objectType, $templateParameters, 'controllerAction', $contextArgs);
    }
    
    /**
     * Processes the parameters for a view action.
     * This includes handling pagination, quick navigation forms and other aspects.
     *
     * @param string          $objectType         Name of treated entity type
     * @param SortableColumns $sortableColumns    Used SortableColumns instance
     * @param array           $templateParameters Template data
     * @param boolean         $supportsHooks      Whether hooks are supported or not
     *
     * @return array Enriched template parameters used for creating the response
     */
    public function processViewActionParameters($objectType, SortableColumns $sortableColumns, array $templateParameters = [], $supportsHooks = false)
    {
    	$contextArgs = ['controller' => $objectType, 'action' => 'view'];
    	if (!in_array($objectType, $this->getObjectTypes('controllerAction', $contextArgs))) {
    		throw new Exception($this->__('Error! Invalid object type received.'));
    	}
    
    	$request = $this->request;
    	$repository = $this->entityFactory->getRepository($objectType);
    
    	// parameter for used sorting field
    	$sort = $request->query->get('sort', '');
    	if (empty($sort) || !in_array($sort, $repository->getAllowedSortingFields())) {
    		$sort = $repository->getDefaultSortingField();
    		$request->query->set('sort', $sort);
    		// set default sorting in route parameters (e.g. for the pager)
    		$routeParams = $request->attributes->get('_route_params');
    		$routeParams['sort'] = $sort;
    		$request->attributes->set('_route_params', $routeParams);
    	}
    	$sortdir = $request->query->get('sortdir', 'ASC');
    	$sortableColumns->setOrderBy($sortableColumns->getColumn($sort), strtoupper($sortdir));
    
    	$templateParameters['all'] = 'csv' == $request->getRequestFormat() ? 1 : $request->query->getInt('all', 0);
    	$templateParameters['own'] = $request->query->getInt('own', $this->variableApi->get('MUYourCityModule', 'showOnlyOwnEntries', 0));
    
    	$resultsPerPage = 0;
    	if ($templateParameters['all'] != 1) {
    		// the number of items displayed on a page for pagination
    		$resultsPerPage = $request->query->getInt('num', 0);
    		if (in_array($resultsPerPage, [0, 10])) {
    			$resultsPerPage = $this->variableApi->get('MUYourCityModule', $objectType . 'EntriesPerPage', 10);
    		}
    	}
    	$templateParameters['num'] = $resultsPerPage;
    	$templateParameters['tpl'] = $request->query->getAlnum('tpl', '');
    
    	$templateParameters = $this->addTemplateParameters($objectType, $templateParameters, 'controllerAction', $contextArgs);
    
    	$quickNavForm = $this->formFactory->create('MU\YourCityModule\Form\Type\QuickNavigation\\' . ucfirst($objectType) . 'QuickNavType', $templateParameters);
    	if ($quickNavForm->handleRequest($request) && $quickNavForm->isSubmitted()) {
    		$quickNavData = $quickNavForm->getData();
    		foreach ($quickNavData as $fieldName => $fieldValue) {
    			if ($fieldName == 'routeArea') {
    				continue;
    			}
    			if (in_array($fieldName, ['all', 'own', 'num'])) {
    				$templateParameters[$fieldName] = $fieldValue;
    			} else {
    				// set filter as query argument, fetched inside repository
    				if ($fieldValue instanceof UserEntity) {
    					$fieldValue = $fieldValue->getUid();
    				}
    				$request->query->set($fieldName, $fieldValue);
    			}
    		}
    	}
    
    	$urlParameters = $templateParameters;
    	foreach ($urlParameters as $parameterName => $parameterValue) {
    		if (false !== stripos($parameterName, 'thumbRuntimeOptions')) {
    			unset($urlParameters[$parameterName]);
    		}
    	}
    
    	$sort = $sortableColumns->getSortColumn()->getName();
    	$sortdir = $sortableColumns->getSortDirection();
    	$sortableColumns->setAdditionalUrlParameters($urlParameters);
    
    	$where = '';
    	if ($templateParameters['all'] == 1) {
    		// retrieve item list without pagination
    		$entities = $repository->selectWhere($where, $sort . ' ' . $sortdir);
    	} else {
    		// the current offset which is used to calculate the pagination
    		$currentPage = $request->query->getInt('pos', 1);
    
    		// OWN CODE
    		// retrieve item list with pagination    		
    		if ($objectType == 'location' || $objectType == 'branch') {
    			//list($entities, $objectCount) = $repository->getLocations(); TODO
    			list($entities, $objectCount) = $repository->selectWherePaginated($where, $sort . ' ' . $sortdir, $currentPage, $resultsPerPage, false);
    			    			
    		} else {
    		    list($entities, $objectCount) = $repository->selectWherePaginated($where, $sort . ' ' . $sortdir, $currentPage, $resultsPerPage);
    		}
    		$templateParameters['currentPage'] = $currentPage;
    		$templateParameters['pager'] = [
    				'amountOfItems' => $objectCount,
    				'itemsPerPage' => $resultsPerPage
    		];
    	}
    
    	$templateParameters['sort'] = $sort;
    	$templateParameters['sortdir'] = $sortdir;
    	$templateParameters['items'] = $entities;
    	
    	if ($objectType == 'abonnement') {

    		$abos = '';
    		$eventRepository = $this->entityFactory->getRepository('event');
    		$menuRepository = $this->entityFactory->getRepository('menuOfLocation');
    		$offerRepository = $this->entityFactory->getRepository('offer');
    		$productRepository = $this->entityFactory->getRepository('product');
    		foreach ($entities as $entity) {
    		$events = $eventRepository->findBy(array('myLocation' => $entity['location']['id']), array('name' => 'ASC'));
    		if ($events) {
    		$entity['location']['events'] = $events;
    		}
    		$menus = $menuRepository->findBy(array('myLocation' => $entity['location']['id']), array('name' => 'ASC'));
    		if ($menus) {
    		$entity['location']['menus'] = $menus;
    		}
    	    $offers = $offerRepository->findBy(array('myLocation' => $entity['location']['id']), array('name' => 'ASC'));
    	    if ($offers) {
    	    $entity['location']['offers'] = $offers;
    	    }
    		$products = $productRepository->findBy(array('myLocation' => $entity['location']['id']), array('name' => 'ASC'));
    		if ($products) {
    		$entity['location']['products'] = $products;
    		}
    		$abos[] = $entity;
    	    }
    
    	if ($abos && is_array($abos)) {
    	unset($templateParameters['items']);
    	$templateParameters['items'] = $abos;
    	}
    	}
    
    	if (true === $supportsHooks) {
    		// build RouteUrl instance for display hooks
    		$urlParameters['_locale'] = $request->getLocale();
    		$templateParameters['currentUrlObject'] = new RouteUrl('muyourcitymodule_' . $objectType . '_' . /*$templateParameters['routeArea'] . */'view', $urlParameters);
    	}
    
    	$templateParameters['sort'] = $sortableColumns->generateSortableColumns();
    	$templateParameters['quickNavForm'] = $quickNavForm->createView();
    
    	$templateParameters['canBeCreated'] = $this->modelHelper->canBeCreated($objectType);
    
    	return $templateParameters;
    }
    
    /**
     * Processes the parameters for an edit action.
     *
     * @param string  $objectType         Name of treated entity type
     * @param array   $templateParameters Template data
     *
     * @return array Enriched template parameters used for creating the response
     */
    public function processEditActionParameters($objectType, array $templateParameters = [])
    {
    	$contextArgs = ['controller' => $objectType, 'action' => 'edit'];
    	if (!in_array($objectType, $this->getObjectTypes('controllerAction', $contextArgs))) {
    		throw new Exception($this->__('Error! Invalid object type received.'));
    	}
    
    	return $this->addTemplateParameters($objectType, $templateParameters, 'controllerAction', $contextArgs);
    }
    
    /**
     * 
     * @param string $actualDay
     * @param array $location
     * @param int $kind
     * @return string
     */
    private function checkActualDay($actualDay, $location, $kind = 1) {
    	
    	$function = 'getStartOn' . $actualDay;
    	$startTime = $location->$function();
    	if ($startTime) {
    		$startTime = $startTime->format('H:i');
    	} else {
    		$startTime = '';
    	}
    	    	
    	$function = 'getEndOn' . $actualDay;
    	$endTime = $location->$function();
    	if ($endTime) {
    	$endTime = $endTime->format('H:i');
    	} else {
    		$endTime == '';
    	}

    	$function = 'getStart2On' . $actualDay;
    	$start2Time = $location->$function();
    	if ($start2Time) {
    		$start2Time = $start2Time->format('H:i');
    	} else {
    		$start2Time = '';
    	}
    	
    	$function = 'getEnd2On' . $actualDay;
    	$end2Time = $location->$function();
    	if ($end2Time) {
    		$end2Time = $end2Time->format('H:i');
    	} else {
    		$end2Time == '';
    	}
    	
    	//$end2Time = \DateUtil::formatDatetime($location['end2On' . $actualDay], 'timebrief');
    	
    	/*$startTimeFine = \DateUtil::formatDatetime($location['startOn' . $actualDay], 'timebrief');
    	$endTimeFine = \DateUtil::formatDatetime($location['endOn' . $actualDay], 'timebrief');
    	$start2TimeFine = \DateUtil::formatDatetime($location['start2On' . $actualDay], 'timebrief');
    	$end2TimeFine = \DateUtil::formatDatetime($location['end2On' . $actualDay], 'timebrief');*/
    	
		switch ($actualDay) {
			case 'Sunday' :
				$beforeDay = 'Saturday';
				$nextDay = 'Monday';
				break;
			case 'Monday' :
				$beforeDay = 'Sunday';
				$nextDay = 'Tuesday';
				break;
			case 'Tuesday' :
				$beforeDay = 'Monday';
				$nextDay = 'Wednesday';
				break;
			case 'Wednesday' :
				$beforeDay = 'Tuesday';
				$nextDay = 'Thursday';
				break;
			case 'Thursday' :
				$beforeDay = 'Wednesday';
				$nextDay = 'Friday';
				break;
			case 'Friday' :
				$beforeDay = 'Thursday';
				$nextDay = 'Saturday';
				break;
			case 'Saturday' :
				$beforeDay = 'Friday';
				$nextDay = 'Sunday';
				break;				
		}
		
		$function = 'getStartOn' . $nextDay;
		$nextStartTime = $location->$function();
		if ($nextStartTime) {
			$nextStartTime = $nextStartTime->format('H:i');
		} else {
			$nextStartTime = '';
		}
		
		$function = 'getEndOn' . $nextDay;
		$nextEndTime = $location->$function();
		if ($nextEndTime) {
			$nextEndTime = $nextEndTime->format('H:i');
		} else {
			$nextEndTime == '';
		}
		
		$function = 'getStart2On' . $nextDay;
		$nextStart2Time = $location->$function();
		if ($nextStart2Time) {
			$nextStart2Time = $nextStart2Time->format('H:i');
		} else {
			$nextStart2Time = '';
		}
		
		$function = 'getEnd2On' . $nextDay;
		$nextEnd2Time = $location->$function();
		if ($nextEnd2Time) {
			$nextEnd2Time = $nextEnd2Time->format('H:i');
		} else {
			$nextEnd2Time == '';
		}
		
		$function = 'getStartOn' . $beforeDay;
		$beforeStartTime = $location->$function();
		if ($beforeStartTime) {
			$beforeStartTime = $beforeStartTime->format('H:i');
		} else {
			$beforeStartTime = '';
		}
		
		$function = 'getEndOn' . $beforeDay;
		$beforeEndTime = $location->$function();
		if ($beforeEndTime) {
			$beforeEndTime = $beforeEndTime->format('H:i');
		} else {
			$beforeEndTime = '';
		}
		
		$function = 'getStart2On' . $beforeDay;
		$beforeStart2Time = $location->$function();
		if ($beforeStart2Time) {
			$beforeStart2Time = $beforeStart2Time->format('H:i');
		} else {
			$beforeStart2Time = '';
		}
		
		$function = 'getEnd2On' . $beforeDay;
		$beforeEnd2Time = $location->$function();
		if ($beforeEnd2Time) {
			$beforeEnd2Time = $beforeEnd2Time->format('H:i');
		} else {
			$beforeEnd2Time = '';
		}
    	
    	// we get actual time
    	$actualTime = date('H:i');
    	// we set state
    	$state = '';
    	// we check the first times
    	if ($startTime != '') {
    	    if ($startTime < $actualTime) {
    	    	if ($endTime != '') {
    		        if ($endTime >= $actualTime || $endTime == '00:00') {
    			        $state = 'open';
    		        } else {
    		    	    $state = 'closed';
    		        }
    	        } else {
    		        $state = 'openEnd';
    	        }
    	    } else {
    		if ($endTime == '') {
    			$state = 'openEnd';
    		} else {
    			/*if($actualTime > '00:00' && $actualTime < '06:00' && $beforeEndTime > $actualTime) {
    				$state = 'closed';
    			} else {*/
    		        $state = 'closed';
    			//}
    	    }
    	}
    	}

    	//die($state);
    	//die('Aktueller Tag: ' . $actualDay. 'Actual Time: ' . $actualTime . ', Next Start: ' . $nextStartTime . ', End Time: ' . $endTime);

    	// we check the second times
    	if ($state != 'open' && $state != 'open2') {
    	if ($start2Time != '') {
    		if ($start2Time < $actualTime) {
    			if ($end2Time != '') {
    				if ($end2Time >= $actualTime || $end2Time == '00:00') {
    					    $state = 'open';
 
    				} else {
    					if ($actualTime <= '23:59' && $actualTime > '06:00') {
    						if ($end2Time <= '06:00')
    						$state = 'open';
    						//die('T');
    					}
    					    //$state = 'closed';
    				}
    			} else {
    				    $state = 'openEnd';
    			}
    		} else {
    		    if ($end2Time == '') {
    			$state = 'openEnd';
    		} else {
    			/*if ($actualTime > '00:00' && $actualTime < '06:00' && $beforeEndTime > $actualTime) {
    				$state = 'closed';
    			} else {*/
    		        $state = 'closed';
    			//}
    		}
    		}
    	}
        }
        
        if ($state != 'open' && $actualTime > '00:00' && $actualTime < '06:00' && (($beforeEndTime != '' && $beforeEndTime > $actualTime) || ($beforeEnd2Time != '' && $beforeEnd2Time > $actualTime))) {
        	$state = 'open2';
        }

    	//die($state);
    	// we look for the hours
    	if ($state == 'open' || $state == 'openEnd' || $state == 'closed' || ($end2Time > '00:00' && $end2Time < $nextStartTime && $actualTime > $start2Time) || ($startTime == '00:00' && $startTime == '00:00')) {
    		$hours = $startTime;
    		if ($endTime != '') {
    			$hours .= ' - ' . $endTime;
    		} else {
    			if ($start2Time == '') {
    			$hours .= ' - ' . $this->__('Open end');
    			}
    		}
    		if ($start2Time != '') {
    			$hours .= "\n" . $start2Time;
    			
    		    if ($end2Time != '') {
    			    $hours .= ' - ' . $end2Time;
    		    } else {
    			    $hours .= ' - ' . $this->__('Open End');
    		    }    			
    		}

    	} else {
    		if ($state == 'open2') {
    			$hours = $beforeStartTime;
    			if ($beforeEndTime != '') {
    				$hours .= ' - ' . $beforeEndTime;
    			}
    			if ($beforeStart2Time != '') {
    				$hours .= "\n" . $beforeStart2Time;
    				
    				if ($beforeEnd2Time != '') {
    					$hours .= ' - ' . $beforeEnd2Time;
    				} else {
    					$hours .= ' - ' . $this->__('Open end');
    				}
    			}
    		} else {
    		    $hours = 'none';
    		}
    	}
    	
    	$realDay = $this->getActualDay($state);
    	
    	if ($kind == 1) {
    	    return $state;
    	} elseif ($kind == 2) {
    		return $realDay;
    	} else {  	
    		return $hours;
    	}
    }
    
    /**
     * 
     */
    private function getActualDay($state = '')
    {
    	$wochentage = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
    	
    	$tag = date ( "w" );
    	$year = date ( "Y" );
    	if ($state != '' && $state == 'open2') {
    		$tag = $tag - 1;
    	}
    	
    	return $wochentage[$tag];
    	
    }
    
    /**
     * 
     */
    public function getUid()
    {
    	$uid = $this->currentUserApi->get('uid');
    	return $uid;
    }
    
    /**
     * saves location informations in mod vars depending on different criterias
     * 
     * return
     */
    public function getLocations()
    {
    	$repository = $this->entityFactory->getRepository('location');
    	$locations = $repository->findAll();
    	foreach ($locations as $location) {
    		$ids[] = $location['id'];
    		$idsString = implode(',', $ids);
    	}
    	$this->variableApi->set('MUYourCityModule', 'locationIds', $idsString);
    	return;
    }
    
    /**
     * saves location informations in mod vars depending on different criterias
     *
     * return
     */
    public function getBranchLocations()
    {    	 
    	$repository = $this->entityFactory->getRepository('location');
    	// search location in branches
    	$branchRepository = $this->entityFactory->getRepository('branch');
    	$branches = $branchRepository->findAll();
    	foreach ($branches as $branch) {
    		$where = 'tblBranches.id = ' . $branch['id'];
    		$thisLocations = $repository->selectWhereForModVars($where, '', false);
    		foreach ($thisLocations as $thisLocation) {
    			$branchLocationIds[$branch['id']][] = $thisLocation['id'];
    		}
    	}
    	$branchLocationIds = serialize($branchLocationIds);
    	$this->variableApi->set('MUYourCityModule', 'branchLocationIds', $branchLocationIds);
    	return;
    }
    
    /**
     * saves location informations in mod vars depending on different criterias
     *
     * return
     */
    public function getPartLocations()
    {
    	$repository = $this->entityFactory->getRepository('location');
    	// search locations in parts
    	$partRepository = $this->entityFactory->getRepository('part');
    	$parts = $partRepository->findAll();
    	foreach ($parts as $part) {
    		$where = 'tbl.partOfCity = \'' . DataUtil::formatForStore($part['name']) . '\'';
    		$thisLocations = $repository->selectWhereForModVars($where, '', false);
    		foreach ($thisLocations as $thisLocation) {
    			$partLocationIds[$part['id']][] = $thisLocation['id'];
    		}
    	}
    	$partLocationIds = serialize($partLocationIds);
    	$this->variableApi->set('MUYourCityModule', 'partLocationIds', $partLocationIds);
    	return;
    }
    
    /**
     * Returns an array of additional template variables which are specific to the object type treated by this repository.
     *
     * @param string $objectType Name of treated entity type
     * @param array  $parameters Given parameters to enrich
     * @param string $context    Usage context (allowed values: controllerAction, api, actionHandler, block, contentType)
     * @param array  $args       Additional arguments
     *
     * @return array List of template variables to be assigned
     */
    public function addTemplateParameters($objectType = '', array $parameters = [], $context = '', array $args = [])
    {
    	if (!in_array($context, ['controllerAction', 'api', 'actionHandler', 'block', 'contentType', 'mailz'])) {
    		$context = 'controllerAction';
    	} else {
    		if ($context == 'block') {
    		    if ($objectType == 'part') {
    			$thumbRuntimeOptions = [];
    			$thumbRuntimeOptions[$objectType . 'ImageOfPart'] = $this->imageHelper->getRuntimeOptions($objectType, 'imageOfPart', $context, $args);
    			//$thumbRuntimeOptions['location' . 'ImageOfLocation'] = $this->imageHelper->getRuntimeOptions('location', 'imageOfLocation', 'locationInDisplay', $args);
    			$parameters['thumbRuntimeOptions'] = $thumbRuntimeOptions;
    		}
    		}
    	}
    
    	if ($context == 'controllerAction') {
    		if (!isset($args['action'])) {
    			$routeName = $this->request->get('_route');
    			$routeNameParts = explode('_', $routeName);
    			$args['action'] = end($routeNameParts);
    		}
    		if (in_array($args['action'], ['index', 'view'])) {
    			$parameters = array_merge($parameters, $this->collectionFilterHelper->getViewQuickNavParameters($objectType, $context, $args));
    		}
    
    		// initialise Imagine runtime options
    		if ($objectType == 'branch') {
    			$thumbRuntimeOptions = [];
    			$thumbRuntimeOptions[$objectType . 'ImageOfBranch'] = $this->imageHelper->getRuntimeOptions($objectType, 'imageOfBranch', $context, $args);
    			$thumbRuntimeOptions['location' . 'ImageOfLocation'] = $this->imageHelper->getRuntimeOptions('location', 'imageOfLocation', 'locationInDisplay', $args);
    			$parameters['thumbRuntimeOptions'] = $thumbRuntimeOptions;
    		}
    		if ($objectType == 'location') {
    			$thumbRuntimeOptions = [];
    			$thumbRuntimeOptions[$objectType . 'LogoOfYourLocation'] = $this->imageHelper->getRuntimeOptions($objectType, 'logoOfYourLocation', $context, $args);
    			$thumbRuntimeOptions[$objectType . 'ImageOfLocation'] = $this->imageHelper->getRuntimeOptions($objectType, 'imageOfLocation', $context, $args);
    			$thumbRuntimeOptions[$objectType . 'FirstImage'] = $this->imageHelper->getRuntimeOptions($objectType, 'firstImage', $context, $args);
    			$thumbRuntimeOptions[$objectType . 'SecondImage'] = $this->imageHelper->getRuntimeOptions($objectType, 'secondImage', $context, $args);
    			$thumbRuntimeOptions[$objectType . 'ThirdImage'] = $this->imageHelper->getRuntimeOptions($objectType, 'thirdImage', $context, $args);
    			$thumbRuntimeOptions[$objectType . 'FourthImage'] = $this->imageHelper->getRuntimeOptions($objectType, 'fourthImage', $context, $args);
    			$thumbRuntimeOptions[$objectType . 'FifthImage'] = $this->imageHelper->getRuntimeOptions($objectType, 'fifthImage', $context, $args);
    			$thumbRuntimeOptions[$objectType . 'SixthImage'] = $this->imageHelper->getRuntimeOptions($objectType, 'sixthImage', $context, $args);
    			$thumbRuntimeOptions[$objectType . 'FirstFile'] = $this->imageHelper->getRuntimeOptions($objectType, 'firstFile', $context, $args);
    			$thumbRuntimeOptions[$objectType . 'SecondFile'] = $this->imageHelper->getRuntimeOptions($objectType, 'secondFile', $context, $args);
    			$parameters['thumbRuntimeOptions'] = $thumbRuntimeOptions;
    		}
    		if ($objectType == 'part') {
    			$thumbRuntimeOptions = [];
    			$thumbRuntimeOptions[$objectType . 'ImageOfPart'] = $this->imageHelper->getRuntimeOptions($objectType, 'imageOfPart', $context, $args);
    			$thumbRuntimeOptions['location' . 'ImageOfLocation'] = $this->imageHelper->getRuntimeOptions('location', 'imageOfLocation', 'locationInDisplay', $args);
    			$parameters['thumbRuntimeOptions'] = $thumbRuntimeOptions;
    		}
    		if ($objectType == 'offer') {
    			$thumbRuntimeOptions = [];
    			$thumbRuntimeOptions[$objectType . 'ImageOfOffer'] = $this->imageHelper->getRuntimeOptions($objectType, 'imageOfOffer', $context, $args);
    			$parameters['thumbRuntimeOptions'] = $thumbRuntimeOptions;
    		}
    		if ($objectType == 'menuOfLocation') {
    			$thumbRuntimeOptions = [];
    			$thumbRuntimeOptions[$objectType . 'ImageOfMenu'] = $this->imageHelper->getRuntimeOptions($objectType, 'imageOfMenu', $context, $args);
    			$parameters['thumbRuntimeOptions'] = $thumbRuntimeOptions;
    		}
    		if ($objectType == 'dish') {
    			$thumbRuntimeOptions = [];
    			$thumbRuntimeOptions[$objectType . 'ImageOfDish'] = $this->imageHelper->getRuntimeOptions($objectType, 'imageOfDish', $context, $args);
    			$parameters['thumbRuntimeOptions'] = $thumbRuntimeOptions;
    		}
    		if ($objectType == 'event') {
    			$thumbRuntimeOptions = [];
    			$thumbRuntimeOptions[$objectType . 'ImageOfEvent'] = $this->imageHelper->getRuntimeOptions($objectType, 'imageOfEvent', $context, $args);
    			$parameters['thumbRuntimeOptions'] = $thumbRuntimeOptions;
    		}
    		if ($objectType == 'product') {
    			$thumbRuntimeOptions = [];
    			$thumbRuntimeOptions[$objectType . 'ImageOfProduct'] = $this->imageHelper->getRuntimeOptions($objectType, 'imageOfProduct', $context, $args);
    			$parameters['thumbRuntimeOptions'] = $thumbRuntimeOptions;
    		}
    		if (in_array($args['action'], ['display', 'edit', 'view'])) {
    			// use separate preset for images in related items
    			$parameters['relationThumbRuntimeOptions'] = $this->imageHelper->getCustomRuntimeOptions('', '', 'MUYourCityModule_relateditem', $context, $args);
    		}
    	}
    
    	$parameters['featureActivationHelper'] = $this->featureActivationHelper;
    
    	return $parameters;
    }
}
