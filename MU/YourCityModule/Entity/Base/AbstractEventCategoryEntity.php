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

namespace MU\YourCityModule\Entity\Base;

use Doctrine\ORM\Mapping as ORM;
use Zikula\CategoriesModule\Entity\AbstractCategoryAssignment;

/**
 * Entity extension domain class storing event categories.
 *
 * This is the base category class for event entities.
 */
abstract class AbstractEventCategoryEntity extends AbstractCategoryAssignment
{
    /**
     * @ORM\ManyToOne(targetEntity="\MU\YourCityModule\Entity\EventEntity", inversedBy="categories")
     * @ORM\JoinColumn(name="entityId", referencedColumnName="id")
     * @var \MU\YourCityModule\Entity\EventEntity
     */
    protected $entity;
    
    /**
     * Get reference to owning entity.
     *
     * @return \MU\YourCityModule\Entity\EventEntity
     */
    public function getEntity()
    {
        return $this->entity;
    }
    
    /**
     * Set reference to owning entity.
     *
     * @param \MU\YourCityModule\Entity\EventEntity $entity
     */
    public function setEntity(/*\MU\YourCityModule\Entity\EventEntity */$entity)
    {
        $this->entity = $entity;
    }
}
