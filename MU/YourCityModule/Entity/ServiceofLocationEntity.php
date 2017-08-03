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

namespace MU\YourCityModule\Entity;

use MU\YourCityModule\Entity\Base\AbstractServiceOfLocationEntity as BaseEntity;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Entity class that defines the entity structure and behaviours.
 *
 * This is the concrete entity class for service of location entities.
 * @Gedmo\TranslationEntity(class="MU\YourCityModule\Entity\ServiceOfLocationTranslationEntity")
 * @ORM\Entity(repositoryClass="MU\YourCityModule\Entity\Repository\ServiceOfLocationRepository")
 * @ORM\Table(name="mu_yourcity_serviceoflocation",
 *     indexes={
 *         @ORM\Index(name="workflowstateindex", columns={"workflowState"})
 *     }
 * )
 */
class ServiceOfLocationEntity extends BaseEntity
{
    // feel free to add your own methods here
}
