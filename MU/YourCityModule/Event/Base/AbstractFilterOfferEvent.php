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
use MU\YourCityModule\Entity\OfferEntity;

/**
 * Event base class for filtering offer processing.
 */
class AbstractFilterOfferEvent extends Event
{
    /**
     * @var OfferEntity Reference to treated entity instance.
     */
    protected $offer;

    /**
     * @var array Entity change set for preUpdate events.
     */
    protected $entityChangeSet = [];

    /**
     * FilterOfferEvent constructor.
     *
     * @param OfferEntity $offer Processed entity
     * @param array $entityChangeSet Change set for preUpdate events
     */
    public function __construct(OfferEntity $offer, $entityChangeSet = [])
    {
        $this->offer = $offer;
        $this->entityChangeSet = $entityChangeSet;
    }

    /**
     * Returns the entity.
     *
     * @return OfferEntity
     */
    public function getOffer()
    {
        return $this->offer;
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
