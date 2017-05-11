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

namespace MU\YourCityModule\Helper;

use MU\YourCityModule\Helper\Base\AbstractCollectionFilterHelper;

use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Zikula\UsersModule\Api\ApiInterface\CurrentUserApiInterface;
use Zikula\UsersModule\Constant as UsersConstant;
use MU\YourCityModule\Entity\BranchEntity;
use MU\YourCityModule\Entity\LocationEntity;
use MU\YourCityModule\Entity\PartEntity;
use MU\YourCityModule\Entity\ImageOfLocationEntity;
use MU\YourCityModule\Entity\FileOfLocationEntity;
use MU\YourCityModule\Entity\OfferEntity;
use MU\YourCityModule\Entity\MenuOfLocationEntity;
use MU\YourCityModule\Entity\PartOfMenuEntity;
use MU\YourCityModule\Entity\DishEntity;
use MU\YourCityModule\Entity\EventEntity;
use MU\YourCityModule\Entity\ProductEntity;
use MU\YourCityModule\Entity\SpecialOfLocationEntity;
use MU\YourCityModule\Entity\ServiceOfLocationEntity;
use MU\YourCityModule\Entity\AbonnementEntity;
use MU\YourCityModule\Entity\Factory\YourCityFactory;

/**
 * Entity collection filter helper implementation class.
 */
class CollectionFilterHelper extends AbstractCollectionFilterHelper
{
    /**
     * Adds default filters as where clauses.
     *
     * @param QueryBuilder $qb         Query builder to be enhanced
     * @param array        $parameters List of determined filter options
     *
     * @return QueryBuilder Enriched query builder instance
     */
    protected function applyDefaultFiltersForOffer(QueryBuilder $qb, $parameters = [])
    {
        $routeName = $this->request->get('_route');
        $isAdminArea = false !== strpos($routeName, 'muyourcitymodule_offer_admin');
        if ($isAdminArea) {
            return $qb;
        }
    
        $showOnlyOwnEntries = (bool)$this->request->query->getInt('own', $this->showOnlyOwnEntries);
    
        if (!in_array('workflowState', array_keys($parameters)) || empty($parameters['workflowState'])) {
            // per default we show approved offers only
            $onlineStates = ['approved'];
            $qb->andWhere('tbl.workflowState IN (:onlineStates)')
               ->setParameter('onlineStates', $onlineStates);
        }
    
        if ($showOnlyOwnEntries) {
            $qb = $this->addCreatorFilter($qb);
        }
        

        $userId = $this->currentUserApi->isLoggedIn() ? $this->currentUserApi->get('uid') : UsersConstant::USER_ID_ANONYMOUS;
        $userGroup = \UserUtil::getGroupListForUser($userId);
        $userGroupArray = explode(',', $userGroup);
        if (!in_array('2', $userGroupArray)) {
        $startDate = $this->request->query->get('inViewFrom', date('Y-m-d H:i:s'));
        $qb->andWhere('(tbl.inViewFrom <= :startDate OR tbl.inViewFrom IS NULL)')
           ->setParameter('startDate', $startDate);
        
        $endDate = $this->request->query->get('inViewUntil', date('Y-m-d H:i:s'));
        $qb->andWhere('(tbl.inViewUntil >= :endDate OR tbl.inViewUntil IS NULL)')
           ->setParameter('endDate', $endDate);
        }
    
        return $qb;
    }
}
