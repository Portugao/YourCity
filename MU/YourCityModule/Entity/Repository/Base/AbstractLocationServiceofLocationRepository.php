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

namespace MU\YourCityModule\Entity\Repository\Base;

use Doctrine\ORM\EntityRepository;
use Psr\Log\LoggerInterface;

/**
 * Repository class used to implement own convenience methods for performing certain DQL queries.
 *
 * This is the base repository class for the many to many relationship
 * between location and service of location entities.
 */
class AbstractLocationServiceofLocationRepository extends EntityRepository
{
    /**
     * Deletes all items in this table.
     *
     * @param LoggerInterface $logger Logger service instance
     */
    public function truncateTable(LoggerInterface $logger)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->delete('\\MU\\YourCityModule\\Entity\\LocationServiceofLocation', 'tbl');
        $query = $qb->getQuery();
        $query->execute();

        $logArgs = ['app' => 'MUYourCityModule', 'entity' => 'location serviceof location'];
        $logger->debug('{app}: Truncated the {entity} entity table.', $logArgs);
    }
}
