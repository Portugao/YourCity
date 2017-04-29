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
use MU\YourCityModule\Entity\AbonnementEntity;

/**
 * Event base class for filtering abonnement processing.
 */
class AbstractFilterAbonnementEvent extends Event
{
    /**
     * @var AbonnementEntity Reference to treated entity instance.
     */
    protected $abonnement;

    /**
     * @var array Entity change set for preUpdate events.
     */
    protected $entityChangeSet = [];

    /**
     * FilterAbonnementEvent constructor.
     *
     * @param AbonnementEntity $abonnement Processed entity
     * @param array $entityChangeSet Change set for preUpdate events
     */
    public function __construct(AbonnementEntity $abonnement, $entityChangeSet = [])
    {
        $this->abonnement = $abonnement;
        $this->entityChangeSet = $entityChangeSet;
    }

    /**
     * Returns the entity.
     *
     * @return AbonnementEntity
     */
    public function getAbonnement()
    {
        return $this->abonnement;
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
