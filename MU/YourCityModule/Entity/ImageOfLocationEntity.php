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

namespace MU\YourCityModule\Entity;

use MU\YourCityModule\Entity\Base\AbstractImageOfLocationEntity as BaseEntity;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Entity class that defines the entity structure and behaviours.
 *
 * This is the concrete entity class for image of location entities.
 * @Gedmo\TranslationEntity(class="MU\YourCityModule\Entity\ImageOfLocationTranslationEntity")
 * @ORM\Entity(repositoryClass="MU\YourCityModule\Entity\Repository\ImageOfLocationRepository")
 * @ORM\Table(name="mu_yourcity_imageoflocation",
 *     indexes={
 *         @ORM\Index(name="workflowstateindex", columns={"workflowState"})
 *     }
 * )
 */
class ImageOfLocationEntity extends BaseEntity
{
    // feel free to add your own methods here
}
