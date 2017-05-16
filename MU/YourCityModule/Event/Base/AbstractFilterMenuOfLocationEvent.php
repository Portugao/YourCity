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

namespace MU\YourCityModule\Event\Base;

use Symfony\Component\EventDispatcher\Event;
use MU\YourCityModule\Entity\MenuOfLocationEntity;

/**
 * Event base class for filtering menu of location processing.
 */
class AbstractFilterMenuOfLocationEvent extends Event
{
    /**
     * @var MenuOfLocationEntity Reference to treated entity instance.
     */
    protected $menuOfLocation;

    /**
     * @var array Entity change set for preUpdate events.
     */
    protected $entityChangeSet = [];

    /**
     * FilterMenuOfLocationEvent constructor.
     *
     * @param MenuOfLocationEntity $menuOfLocation Processed entity
     * @param array $entityChangeSet Change set for preUpdate events
     */
    public function __construct(MenuOfLocationEntity $menuOfLocation, $entityChangeSet = [])
    {
        $this->menuOfLocation = $menuOfLocation;
        $this->entityChangeSet = $entityChangeSet;
    }

    /**
     * Returns the entity.
     *
     * @return MenuOfLocationEntity
     */
    public function getMenuOfLocation()
    {
        return $this->menuOfLocation;
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
