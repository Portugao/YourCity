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

namespace MU\YourCityModule\Controller;

use MU\YourCityModule\Controller\Base\AbstractImportController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Zikula\ThemeModule\Engine\Annotation\Theme;

/**
 * Import controller implementation class.
 *
 * @Route("/import")
 */
class ImportController extends AbstractImportController
{
    /**
     * This method takes care of the application configuration.
     *
     * @Route("/import",
     *        methods = {"GET", "POST"}
     * )
     * @Theme("admin")
     *
     * @param Request $request Current request instance
     *
     * @return string Output
     *
     * @throws AccessDeniedException Thrown if the user doesn't have required permissions
     */
    public function importAction(Request $request)
    {
        return parent::importAction($request);
    }

    // feel free to add your own config controller methods here
}