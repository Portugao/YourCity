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
use MU\YourCityModule\Entity\ProductEntity;

/**
 * Event base class for filtering product processing.
 */
class AbstractFilterProductEvent extends Event
{
    /**
     * @var ProductEntity Reference to treated entity instance.
     */
    protected $product;

    /**
     * @var array Entity change set for preUpdate events.
     */
    protected $entityChangeSet = [];

    /**
     * FilterProductEvent constructor.
     *
     * @param ProductEntity $product Processed entity
     * @param array $entityChangeSet Change set for preUpdate events
     */
    public function __construct(ProductEntity $product, $entityChangeSet = [])
    {
        $this->product = $product;
        $this->entityChangeSet = $entityChangeSet;
    }

    /**
     * Returns the entity.
     *
     * @return ProductEntity
     */
    public function getProduct()
    {
        return $this->product;
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
