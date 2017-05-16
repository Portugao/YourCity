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

namespace MU\YourCityModule\Entity\Repository;

use MU\YourCityModule\Entity\Repository\Base\AbstractLocationRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * Repository class used to implement own convenience methods for performing certain DQL queries.
 *
 * This is the concrete repository class for location entities.
 */
class LocationRepository extends AbstractLocationRepository
{
    /**
     * @var string The default sorting field/expression
     */
    protected $defaultSortingField = 'letterForOrder';
    
    /**
     * Returns query builder for selecting a list of objects with a given where clause.
     *
     * @param string  $where    The where clause to use when retrieving the collection (optional) (default='')
     * @param string  $orderBy  The order-by clause to use when retrieving the collection (optional) (default='')
     * @param boolean $useJoins Whether to include joining related objects (optional) (default=true)
     * @param boolean $slimMode If activated only some basic fields are selected without using any joins (optional) (default=false)
     *
     * @return QueryBuilder Query builder for the given arguments
     */
    public function getListQueryBuilder($where = '', $orderBy = '', $useJoins = true, $slimMode = false)
    {
    	$uid = \UserUtil::getVar('uid');
    	if (\UserUtil::isLoggedIn() && $uid != 2) {
    		$where = 'tbl.owner = ' . \DataUtil::formatForDisplay($uid) . ' or tbl.admin1 = ' . \DataUtil::formatForDisplay($uid)  .  ' or tbl.admin2 = ' . \DataUtil::formatForDisplay($uid);
    	}
    	//$useJoins = false;
    	$qb = $this->genericBaseQuery($where, $orderBy, $useJoins, $slimMode);
    	if ((!$useJoins || !$slimMode) && null !== $this->collectionFilterHelper) {
    		$qb = $this->collectionFilterHelper->addCommonViewFilters('location', $qb);
    	}
    
    	return $qb;
    }
    
    /**
     * Helper method to add join selections.
     *
     * @return String Enhancement for select clause
     */
    protected function addJoinsToSelection()
    {
    	$selection = ', tblImagesOfLocation, tblFilesOfLocation, tblOffers, tblMenuOfLocation, tblEvents, tblProducts, tblSpecialsOfLocation, tblServicesOfLocation';
    
    	return $selection;
    }
    
    /**
     * Helper method to add joins to from clause.
     *
     * @param QueryBuilder $qb Query builder instance used to create the query
     *
     * @return QueryBuilder The query builder enriched by additional joins
     */
    protected function addJoinsToFrom(QueryBuilder $qb)
    {
    	$qb->leftJoin('tbl.imagesOfLocation', 'tblImagesOfLocation');
    	$qb->leftJoin('tbl.filesOfLocation', 'tblFilesOfLocation');
    	$qb->leftJoin('tbl.offers', 'tblOffers');
    	$qb->leftJoin('tbl.menuOfLocation', 'tblMenuOfLocation');
    	$qb->leftJoin('tbl.events', 'tblEvents');
    	$qb->leftJoin('tbl.products', 'tblProducts');
    	$qb->leftJoin('tbl.specialsOfLocation', 'tblSpecialsOfLocation');
    	$qb->leftJoin('tbl.servicesOfLocation', 'tblServicesOfLocation');
    
    	return $qb;
    }
}
