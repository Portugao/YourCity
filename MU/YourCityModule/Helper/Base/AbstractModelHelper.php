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

use MU\YourCityModule\Entity\Factory\EntityFactory;

/**
 * Helper base class for model layer methods.
 */
abstract class AbstractModelHelper
{
    /**
     * @var EntityFactory
     */
    protected $entityFactory;

    /**
     * ModelHelper constructor.
     *
     * @param EntityFactory $entityFactory EntityFactory service instance
     */
    public function __construct(EntityFactory $entityFactory)
    {
        $this->entityFactory = $entityFactory;
    }

    /**
     * Determines whether creating an instance of a certain object type is possible.
     * This is when
     *     - no tree is used
     *     - it has no incoming bidirectional non-nullable relationships.
     *     - the edit type of all those relationships has PASSIVE_EDIT and auto completion is used on the target side
     *       (then a new source object can be created while creating the target object).
     *     - corresponding source objects exist already in the system.
     *
     * Note that even creation of a certain object is possible, it may still be forbidden for the current user
     * if he does not have the required permission level.
     *
     * @param string $objectType Name of treated entity type
     *
     * @return boolean Whether a new instance can be created or not
     */
    public function canBeCreated($objectType)
    {
        $result = false;
    
        switch ($objectType) {
            case 'branch':
                $result = true;
                break;
            case 'location':
                $result = true;
                break;
            case 'part':
                $result = true;
                break;
            case 'imageOfLocation':
                $result = true;
                $result &= $this->hasExistingInstances('location');
                break;
            case 'fileOfLocation':
                $result = true;
                $result &= $this->hasExistingInstances('location');
                break;
            case 'offer':
                $result = true;
                $result &= $this->hasExistingInstances('location');
                break;
            case 'menuOfLocation':
                $result = true;
                $result &= $this->hasExistingInstances('location');
                break;
            case 'partOfMenu':
                $result = true;
                $result &= $this->hasExistingInstances('menuOfLocation');
                break;
            case 'dish':
                $result = true;
                $result &= $this->hasExistingInstances('location');
                break;
            case 'event':
                $result = true;
                $result &= $this->hasExistingInstances('location');
                break;
            case 'product':
                $result = true;
                $result &= $this->hasExistingInstances('location');
                break;
            case 'specialOfLocation':
                $result = true;
                break;
            case 'serviceOfLocation':
                $result = true;
                break;
            case 'abonnement':
                $result = true;
                $result &= $this->hasExistingInstances('location');
                break;
        }
    
        return $result;
    }

    /**
     * Determines whether there exists at least one instance of a certain object type in the database.
     *
     * @param string $objectType Name of treated entity type
     *
     * @return boolean Whether at least one instance exists or not
     */
    protected function hasExistingInstances($objectType)
    {
        $repository = $this->entityFactory->getRepository($objectType);
        if (null === $repository) {
            return false;
        }
    
        return $repository->selectCount() > 0;
    }

    /**
     * Returns a desired sorting criteria for passing it to a repository method.
     *
     * @param string $objectType Name of treated entity type
     * @param string $sorting    The type of sorting (newest, random, default)
     *
     * @return string The order by clause
     */
    public function resolveSortParameter($objectType = '', $sorting = 'default')
    {
        if ($sorting == 'random') {
            return 'RAND()';
        }
    
        $sortParam = '';
        if ($sorting == 'newest') {
            $sortParam = $this->entityFactory->getIdField($objectType) . ' DESC';
        } elseif ($sorting == 'default') {
            $repository = $this->entityFactory->getRepository($objectType);
            $sortParam = $repository->getDefaultSortingField() . ' ASC';
        }
    
        return $sortParam;
    }
}
