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

namespace MU\YourCityModule\Helper\Base;

use Doctrine\ORM\QueryBuilder;
use InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Zikula\CategoriesModule\Api\CategoryRegistryApi;
use Zikula\CategoriesModule\Api\CategoryPermissionApi;
use Zikula\Common\Translator\TranslatorInterface;
use Zikula\UsersModule\Api\CurrentUserApi;

/**
 * Category helper base class.
 */
abstract class AbstractCategoryHelper
{
    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var CurrentUserApi
     */
    protected $currentUserApi;

    /**
     * @var CategoryRegistryApi
     */
    protected $categoryRegistryApi;

    /**
     * @var CategoryPermissionApi
     */
    protected $categoryPermissionApi;

    /**
     * CategoryHelper constructor.
     *
     * @param TranslatorInterface   $translator            Translator service instance
     * @param RequestStack          $requestStack          RequestStack service instance
     * @param LoggerInterface       $logger                Logger service instance
     * @param CurrentUserApi        $currentUserApi        CurrentUserApi service instance
     * @param CategoryRegistryApi   $categoryRegistryApi   CategoryRegistryApi service instance
     * @param CategoryPermissionApi $categoryPermissionApi CategoryPermissionApi service instance
     */
    public function __construct(
        TranslatorInterface $translator,
        RequestStack $requestStack,
        LoggerInterface $logger,
        CurrentUserApi $currentUserApi,
        CategoryRegistryApi $categoryRegistryApi,
        CategoryPermissionApi $categoryPermissionApi
    ) {
        $this->translator = $translator;
        $this->request = $requestStack->getCurrentRequest();
        $this->logger = $logger;
        $this->currentUserApi = $currentUserApi;
        $this->categoryRegistryApi = $categoryRegistryApi;
        $this->categoryPermissionApi = $categoryPermissionApi;
    }

    /**
     * Defines whether multiple selection is enabled for a given object type
     * or not. Subclass can override this method to apply a custom behaviour
     * to certain category registries for example.
     *
     * @param string $objectType The object type to retrieve
     * @param string $registry   Name of category registry to be used (optional)
     *
     * @return boolean true if multiple selection is allowed, else false
     */
    public function hasMultipleSelection($objectType = '', $registry = '')
    {
        if (empty($objectType)) {
            throw new InvalidArgumentException($this->translator->__('Invalid object type received.'));
    	}
        if (empty($args['registry'])) {
            // default to the primary registry
            $registry = $this->getPrimaryProperty($objectType);
        }
    
        // we make no difference between different category registries here
        // if you need a custom behaviour you should override this method
    
        $result = false;
        switch ($objectType) {
            case 'product':
                $result = true;
                break;
        }
    
        return $result;
    }
    
    /**
     * Retrieves input data from POST for all registries.
     *
     * @param string $objectType The object type to retrieve
     * @param string $source     Where to retrieve the data from (defaults to POST)
     *
     * @return array The fetched data indexed by the registry id
     */
    public function retrieveCategoriesFromRequest($objectType = '', $source = 'POST')
    {
        if (empty($objectType)) {
            throw new InvalidArgumentException($this->translator->__('Invalid object type received.'));
    	}
    
        $dataSource = $source == 'GET' ? $this->request->query : $this->request->request;
        $catIdsPerRegistry = [];
    
        $properties = $this->getAllProperties($objectType);
        $inputValues = null;
        $inputName = 'muyourcitymodule_' . strtolower($objectType) . 'quicknav';
        if (!$dataSource->has($inputName)) {
            $inputName = 'muyourcitymodule_' . strtolower($objectType) . 'finder';
        }
        if ($dataSource->has($inputName)) {
            $inputValues = $dataSource->get($inputName);
        }
        if (null === $inputValues) {
            return $catIdsPerRegistry;
        }
        $inputCategories = isset($inputValues['categories']) ? $inputValues['categories'] : [];
    
        if (!count($inputCategories)) {
            return $catIdsPerRegistry;
        }
    
        foreach ($properties as $propertyName => $propertyId) {
            $inputValue = isset($inputCategories['registry_' . $propertyId]) ? $inputCategories['registry_' . $propertyId] : [];
            if (!is_array($inputValue)) {
                $inputValue = [$inputValue];
            }
    
            // prevent "All" option hiding all entries
            foreach ($inputValue as $k => $v) {
                if ($v == 0) {
                    unset($inputValue[$k]);
                }
            }
    
            $catIdsPerRegistry[$propertyName] = $inputValue;
        }
    
        return $catIdsPerRegistry;
    }
    
    /**
     * Adds a list of where clauses for a certain list of categories to a given query builder.
     *
     * @param QueryBuilder $queryBuilder Query builder instance to be enhanced
     * @param string       $objectType   The treated object type (optional)
     * @param array        $catIds       Category ids grouped by property name
     *
     * @return QueryBuilder The enriched query builder instance
     */
    public function buildFilterClauses(QueryBuilder $queryBuilder, $objectType = '', $catIds = [])
    {
        $qb = $queryBuilder;
    
        $properties = $this->getAllProperties($objectType);
    
        $filtersPerRegistry = [];
        $filterParameters = [
            'values' => [],
            'registries' => []
        ];
    
        foreach ($properties as $propertyName => $propertyId) {
            if (!isset($catIds[$propertyName]) || !is_array($catIds[$propertyName]) || !count($catIds[$propertyName])) {
                continue;
            }
    
            $filtersPerRegistry[] = '(
                tblCategories.categoryRegistryId = :propId' . $propertyName . '
                AND tblCategories.category IN (:categories' . $propertyName . ')
            )';
            $filterParameters['registries'][$propertyName] = $propertyId;
            $filterParameters['values'][$propertyName] = $catIds[$propertyName];
        }
    
        if (count($filtersPerRegistry) > 0) {
            if (count($filtersPerRegistry) == 1) {
                $qb->andWhere($filtersPerRegistry[0]);
            } else {
                $qb->andWhere('(' . implode(' OR ', $filtersPerRegistry) . ')');
            }
            foreach ($filterParameters['values'] as $propertyName => $filterValue) {
                $qb->setParameter('propId' . $propertyName, $filterParameters['registries'][$propertyName])
                   ->setParameter('categories' . $propertyName, $filterValue);
            }
        }
    
        return $qb;
    }
    
    /**
     * Returns a list of all registries / properties for a given object type.
     *
     * @param string $objectType The object type to retrieve
     *
     * @return array list of the registries (property name as key, id as value)
     */
    public function getAllProperties($objectType = '')
    {
        if (empty($objectType)) {
            throw new InvalidArgumentException($this->translator->__('Invalid object type received.'));
    	}
    
        return $this->categoryRegistryApi->getModuleRegistriesIds('MUYourCityModule', ucfirst($objectType) . 'Entity');
    }
    
    /**
     * Returns a list of all registries with main category for a given object type.
     *
     * @param string $objectType The object type to retrieve
     * @param string $arrayKey   Key for the result array (optional)
     *
     * @return array list of the registries (registry id as key, main category id as value)
     */
    public function getAllPropertiesWithMainCat($objectType = '', $arrayKey = 'property')
    {
        if (empty($objectType)) {
            throw new InvalidArgumentException($this->translator->__('Invalid object type received.'));
    	}
    
        return $this->categoryRegistryApi->getModuleCategoryIds('MUYourCityModule', ucfirst($objectType) . 'Entity', $arrayKey);
    }
    
    /**
     * Returns the main category id for a given object type and a certain property name.
     *
     * @param string $objectType The object type to retrieve
     * @param string $property   The property name (optional)
     *
     * @return integer The main category id of desired tree
     */
    public function getMainCatForProperty($objectType = '', $property = '')
    {
        if (empty($objectType)) {
            throw new InvalidArgumentException($this->translator->__('Invalid object type received.'));
    	}
    
        return $this->categoryRegistryApi->getModuleCategoryId('MUYourCityModule', ucfirst($objectType) . 'Entity', $property);
    }
    
    /**
     * Returns the name of the primary registry.
     *
     * @param string $objectType The object type to retrieve
     *
     * @return string name of the main registry
     */
    public function getPrimaryProperty($objectType = '')
    {
        return 'Main';
    }
    
    /**
     * Filters a given list of entities to these the current user has permissions for.
     *
     * @param array $entities The given list of entities
     *
     * @return array The filtered list of entities
     */
    public function filterEntitiesByPermission($entities)
    {
        $filteredEntities = [];
        foreach ($entities as $entity) {
            if ($this->hasPermission($entity)) {
                $filteredEntities[] = $entity;
            }
        }
    
        return $filteredEntities;
    }
    
    /**
     * Checks whether permissions are granted to the given categories or not.
     *
     * @param object $entity The entity to check permission for
     *
     * @return boolean True if permissions are given, false otherwise
     */
    public function hasPermission($entity)
    {
        $objectType = $entity->get_objectType();
        $categories = $entity['categories'];
    
        $registries = $this->getAllProperties($objectType);
        $registries = array_flip($registries);
    
        $categoryInfo = [];
        foreach ($categories as $category) {
            $registryId = $category->getCategoryRegistryId();
            if (!isset($registries[$registryId])) {
                // seems this registry has been deleted
                continue;
            }
            $registryName = $registries[$registryId];
            if (!isset($categoryInfo[$registryName])) {
                $categoryInfo[$registryName] = [];
            }
            $categoryInfo[$registryName][] = $category->getCategory()->toArray();
        }
    
        return $this->categoryPermissionApi->hasCategoryAccess($categoryInfo, ACCESS_OVERVIEW);
    }
}
