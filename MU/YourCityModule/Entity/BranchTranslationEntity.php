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

use MU\YourCityModule\Entity\Base\AbstractBranchTranslationEntity as BaseEntity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entity extension domain class storing branch translations.
 *
 * This is the concrete translation class for branch entities.
 *
 * @ORM\Entity(repositoryClass="MU\YourCityModule\Entity\Repository\BranchTranslationRepository")
 * @ORM\Table(name="mu_yourcity_branch_translation",
 *     indexes={
 *         @ORM\Index(name="translations_lookup_idx", columns={
 *             "locale", "object_class", "foreign_key"
 *         })
 *     }
 * )
 */
class BranchTranslationEntity extends BaseEntity
{
    // feel free to add your own methods here
}
