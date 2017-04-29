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

namespace MU\YourCityModule\Event\Base;

use Symfony\Component\EventDispatcher\Event;
use MU\YourCityModule\Entity\ImageOfLocationEntity;

/**
 * Event base class for filtering image of location processing.
 */
class AbstractFilterImageOfLocationEvent extends Event
{
    /**
     * @var ImageOfLocationEntity Reference to treated entity instance.
     */
    protected $imageOfLocation;

    /**
     * @var array Entity change set for preUpdate events.
     */
    protected $entityChangeSet = [];

    /**
     * FilterImageOfLocationEvent constructor.
     *
     * @param ImageOfLocationEntity $imageOfLocation Processed entity
     * @param array $entityChangeSet Change set for preUpdate events
     */
    public function __construct(ImageOfLocationEntity $imageOfLocation, $entityChangeSet = [])
    {
        $this->imageOfLocation = $imageOfLocation;
        $this->entityChangeSet = $entityChangeSet;
    }

    /**
     * Returns the entity.
     *
     * @return ImageOfLocationEntity
     */
    public function getImageOfLocation()
    {
        return $this->imageOfLocation;
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