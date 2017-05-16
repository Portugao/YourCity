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

namespace MU\YourCityModule\Entity;

use MU\YourCityModule\Entity\Base\AbstractDishTranslationEntity as BaseEntity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entity extension domain class storing dish translations.
 *
 * This is the concrete translation class for dish entities.
 *
 * @ORM\Entity(repositoryClass="MU\YourCityModule\Entity\Repository\DishTranslationRepository")
 * @ORM\Table(name="mu_yourcity_dish_translation",
 *     indexes={
 *         @ORM\Index(name="translations_lookup_idx", columns={
 *             "locale", "object_class", "foreign_key"
 *         })
 *     }
 * )
 */
class DishTranslationEntity extends BaseEntity
{
    // feel free to add your own methods here
}
