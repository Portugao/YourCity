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

namespace MU\YourCityModule\Event\Base;

use Symfony\Component\EventDispatcher\Event;
use MU\YourCityModule\Entity\BranchEntity;

/**
 * Event base class for filtering branch processing.
 */
class AbstractFilterBranchEvent extends Event
{
    /**
     * @var BranchEntity Reference to treated entity instance.
     */
    protected $branch;

    /**
     * @var array Entity change set for preUpdate events.
     */
    protected $entityChangeSet = [];

    /**
     * FilterBranchEvent constructor.
     *
     * @param BranchEntity $branch Processed entity
     * @param array $entityChangeSet Change set for preUpdate events
     */
    public function __construct(BranchEntity $branch, $entityChangeSet = [])
    {
        $this->branch = $branch;
        $this->entityChangeSet = $entityChangeSet;
    }

    /**
     * Returns the entity.
     *
     * @return BranchEntity
     */
    public function getBranch()
    {
        return $this->branch;
    }

    /**
     * Returns the change set.
     *
     * @return array
     */
    public function getEntityChangeSet()
    {
        return $this->entityChangeSet;
    }
}
