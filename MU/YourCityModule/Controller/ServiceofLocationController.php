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

namespace MU\YourCityModule\Controller;

use MU\YourCityModule\Controller\Base\AbstractServiceOfLocationController;

use RuntimeException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Zikula\ThemeModule\Engine\Annotation\Theme;
use MU\YourCityModule\Entity\ServiceOfLocationEntity;

/**
 * Service of location controller class providing navigation and interaction functionality.
 */
class ServiceOfLocationController extends AbstractServiceOfLocationController
{
    /**
     * @inheritDoc
     *
     * @Route("/admin/servicesOfLocation",
     *        methods = {"GET"}
     * )
     * @Cache(expires="+7 days", public=true)
     * @Theme("admin")
     *
     * @param Request $request Current request instance
     *
     * @return Response Output
     *
     * @throws AccessDeniedException Thrown if the user doesn't have required permissions
     */
    public function adminIndexAction(Request $request)
    {
        return parent::adminIndexAction($request);
    }
    
    /**
     * @inheritDoc
     *
     * @Route("/servicesOfLocation",
     *        methods = {"GET"}
     * )
     * @Cache(expires="+7 days", public=true)
     *
     * @param Request $request Current request instance
     *
     * @return Response Output
     *
     * @throws AccessDeniedException Thrown if the user doesn't have required permissions
     */
    public function indexAction(Request $request)
    {
        return parent::indexAction($request);
    }
    /**
     * @inheritDoc
     *
     * @Route("/admin/servicesOfLocation/view/{sort}/{sortdir}/{pos}/{num}.{_format}",
     *        requirements = {"sortdir" = "asc|desc|ASC|DESC", "pos" = "\d+", "num" = "\d+", "_format" = "html|csv|rss|atom|xml|json|kml"},
     *        defaults = {"sort" = "", "sortdir" = "asc", "pos" = 1, "num" = 10, "_format" = "html"},
     *        methods = {"GET"}
     * )
     * @Cache(expires="+2 hours", public=false)
     * @Theme("admin")
     *
     * @param Request $request Current request instance
     * @param string $sort         Sorting field
     * @param string $sortdir      Sorting direction
     * @param int    $pos          Current pager position
     * @param int    $num          Amount of entries to display
     *
     * @return Response Output
     *
     * @throws AccessDeniedException Thrown if the user doesn't have required permissions
     */
    public function adminViewAction(Request $request, $sort, $sortdir, $pos, $num)
    {
        return parent::adminViewAction($request, $sort, $sortdir, $pos, $num);
    }
    
    /**
     * @inheritDoc
     *
     * @Route("/servicesOfLocation/view/{sort}/{sortdir}/{pos}/{num}.{_format}",
     *        requirements = {"sortdir" = "asc|desc|ASC|DESC", "pos" = "\d+", "num" = "\d+", "_format" = "html|csv|rss|atom|xml|json|kml"},
     *        defaults = {"sort" = "", "sortdir" = "asc", "pos" = 1, "num" = 10, "_format" = "html"},
     *        methods = {"GET"}
     * )
     * @Cache(expires="+2 hours", public=false)
     *
     * @param Request $request Current request instance
     * @param string $sort         Sorting field
     * @param string $sortdir      Sorting direction
     * @param int    $pos          Current pager position
     * @param int    $num          Amount of entries to display
     *
     * @return Response Output
     *
     * @throws AccessDeniedException Thrown if the user doesn't have required permissions
     */
    public function viewAction(Request $request, $sort, $sortdir, $pos, $num)
    {
        return parent::viewAction($request, $sort, $sortdir, $pos, $num);
    }
    /**
     * @inheritDoc
     *
     * @Route("/admin/serviceOfLocation/{id}.{_format}",
     *        requirements = {"id" = "\d+", "_format" = "html|xml|json|kml|ics"},
     *        defaults = {"_format" = "html"},
     *        methods = {"GET"}
     * )
     * @ParamConverter("serviceOfLocation", class="MUYourCityModule:ServiceOfLocationEntity", options = {"repository_method" = "selectById", "mapping": {"id": "id"}, "map_method_signature" = true})
     * @Cache(lastModified="serviceOfLocation.getUpdatedDate()", ETag="'ServiceOfLocation' ~ serviceOfLocation.getid() ~ serviceOfLocation.getUpdatedDate().format('U')")
     * @Theme("admin")
     *
     * @param Request $request Current request instance
     * @param ServiceOfLocationEntity $serviceOfLocation Treated service of location instance
     *
     * @return Response Output
     *
     * @throws AccessDeniedException Thrown if the user doesn't have required permissions
     * @throws NotFoundHttpException Thrown by param converter if service of location to be displayed isn't found
     */
    public function adminDisplayAction(Request $request, ServiceOfLocationEntity $serviceOfLocation)
    {
        return parent::adminDisplayAction($request, $serviceOfLocation);
    }
    
    /**
     * @inheritDoc
     *
     * @Route("/serviceOfLocation/{id}.{_format}",
     *        requirements = {"id" = "\d+", "_format" = "html|xml|json|kml|ics"},
     *        defaults = {"_format" = "html"},
     *        methods = {"GET"}
     * )
     * @ParamConverter("serviceOfLocation", class="MUYourCityModule:ServiceOfLocationEntity", options = {"repository_method" = "selectById", "mapping": {"id": "id"}, "map_method_signature" = true})
     * @Cache(lastModified="serviceOfLocation.getUpdatedDate()", ETag="'ServiceOfLocation' ~ serviceOfLocation.getid() ~ serviceOfLocation.getUpdatedDate().format('U')")
     *
     * @param Request $request Current request instance
     * @param ServiceOfLocationEntity $serviceOfLocation Treated service of location instance
     *
     * @return Response Output
     *
     * @throws AccessDeniedException Thrown if the user doesn't have required permissions
     * @throws NotFoundHttpException Thrown by param converter if service of location to be displayed isn't found
     */
    public function displayAction(Request $request, ServiceOfLocationEntity $serviceOfLocation)
    {
        return parent::displayAction($request, $serviceOfLocation);
    }
    /**
     * @inheritDoc
     *
     * @Route("/admin/serviceOfLocation/edit/{id}.{_format}",
     *        requirements = {"id" = "\d+", "_format" = "html"},
     *        defaults = {"id" = "0", "_format" = "html"},
     *        methods = {"GET", "POST"}
     * )
     * @Cache(expires="+30 minutes", public=false)
     * @Theme("admin")
     *
     * @param Request $request Current request instance
     *
     * @return Response Output
     *
     * @throws AccessDeniedException Thrown if the user doesn't have required permissions
     * @throws NotFoundHttpException Thrown by form handler if service of location to be edited isn't found
     * @throws RuntimeException      Thrown if another critical error occurs (e.g. workflow actions not available)
     */
    public function adminEditAction(Request $request)
    {
        return parent::adminEditAction($request);
    }
    
    /**
     * @inheritDoc
     *
     * @Route("/serviceOfLocation/edit/{id}.{_format}",
     *        requirements = {"id" = "\d+", "_format" = "html"},
     *        defaults = {"id" = "0", "_format" = "html"},
     *        methods = {"GET", "POST"}
     * )
     * @Cache(expires="+30 minutes", public=false)
     *
     * @param Request $request Current request instance
     *
     * @return Response Output
     *
     * @throws AccessDeniedException Thrown if the user doesn't have required permissions
     * @throws NotFoundHttpException Thrown by form handler if service of location to be edited isn't found
     * @throws RuntimeException      Thrown if another critical error occurs (e.g. workflow actions not available)
     */
    public function editAction(Request $request)
    {
        return parent::editAction($request);
    }
    /**
     * @inheritDoc
     *
     * @Route("/admin/serviceOfLocation/delete/{id}.{_format}",
     *        requirements = {"id" = "\d+", "_format" = "html"},
     *        defaults = {"_format" = "html"},
     *        methods = {"GET", "POST"}
     * )
     * @ParamConverter("serviceOfLocation", class="MUYourCityModule:ServiceOfLocationEntity", options = {"repository_method" = "selectById", "mapping": {"id": "id"}, "map_method_signature" = true})
     * @Cache(lastModified="serviceOfLocation.getUpdatedDate()", ETag="'ServiceOfLocation' ~ serviceOfLocation.getid() ~ serviceOfLocation.getUpdatedDate().format('U')")
     * @Theme("admin")
     *
     * @param Request $request Current request instance
     * @param ServiceOfLocationEntity $serviceOfLocation Treated service of location instance
     *
     * @return Response Output
     *
     * @throws AccessDeniedException Thrown if the user doesn't have required permissions
     * @throws NotFoundHttpException Thrown by param converter if service of location to be deleted isn't found
     * @throws RuntimeException      Thrown if another critical error occurs (e.g. workflow actions not available)
     */
    public function adminDeleteAction(Request $request, ServiceOfLocationEntity $serviceOfLocation)
    {
        return parent::adminDeleteAction($request, $serviceOfLocation);
    }
    
    /**
     * @inheritDoc
     *
     * @Route("/serviceOfLocation/delete/{id}.{_format}",
     *        requirements = {"id" = "\d+", "_format" = "html"},
     *        defaults = {"_format" = "html"},
     *        methods = {"GET", "POST"}
     * )
     * @ParamConverter("serviceOfLocation", class="MUYourCityModule:ServiceOfLocationEntity", options = {"repository_method" = "selectById", "mapping": {"id": "id"}, "map_method_signature" = true})
     * @Cache(lastModified="serviceOfLocation.getUpdatedDate()", ETag="'ServiceOfLocation' ~ serviceOfLocation.getid() ~ serviceOfLocation.getUpdatedDate().format('U')")
     *
     * @param Request $request Current request instance
     * @param ServiceOfLocationEntity $serviceOfLocation Treated service of location instance
     *
     * @return Response Output
     *
     * @throws AccessDeniedException Thrown if the user doesn't have required permissions
     * @throws NotFoundHttpException Thrown by param converter if service of location to be deleted isn't found
     * @throws RuntimeException      Thrown if another critical error occurs (e.g. workflow actions not available)
     */
    public function deleteAction(Request $request, ServiceOfLocationEntity $serviceOfLocation)
    {
        return parent::deleteAction($request, $serviceOfLocation);
    }

    /**
     * Process status changes for multiple items.
     *
     * This function processes the items selected in the admin view page.
     * Multiple items may have their state changed or be deleted.
     *
     * @Route("/admin/servicesOfLocation/handleSelectedEntries",
     *        methods = {"POST"}
     * )
     * @Theme("admin")
     *
     * @param Request $request Current request instance
     *
     * @return RedirectResponse
     *
     * @throws RuntimeException Thrown if executing the workflow action fails
     */
    public function adminHandleSelectedEntriesAction(Request $request)
    {
        return parent::adminHandleSelectedEntriesAction($request);
    }
    
    /**
     * Process status changes for multiple items.
     *
     * This function processes the items selected in the admin view page.
     * Multiple items may have their state changed or be deleted.
     *
     * @Route("/servicesOfLocation/handleSelectedEntries",
     *        methods = {"POST"}
     * )
     *
     * @param Request $request Current request instance
     *
     * @return RedirectResponse
     *
     * @throws RuntimeException Thrown if executing the workflow action fails
     */
    public function handleSelectedEntriesAction(Request $request)
    {
        return parent::handleSelectedEntriesAction($request);
    }

    // feel free to add your own controller methods here
}
