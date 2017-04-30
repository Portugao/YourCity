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

namespace MU\YourCityModule\Controller\Base;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Zikula\Core\Controller\AbstractController;

/**
 * Config controller base class.
 */
abstract class AbstractImportController extends AbstractController
{
    /**
     * This method takes care of the import.
     *
     * @param Request $request Current request instance
     *
     * @return string Output
     *
     * @throws AccessDeniedException Thrown if the user doesn't have required permissions
     */
    public function importAction(Request $request)
    {
        if (!$this->hasPermission($this->name . '::', '::', ACCESS_ADMIN)) {
            throw new AccessDeniedException();
        }
        
        $form = $this->createForm('MU\YourCityModule\Form\Type\ImportType');
        
        if ($form->handleRequest($request)->isValid()) {
            if ($form->get('save')->isClicked()) {
                $formData = $form->getData();
                foreach (['moderationGroupForLocations'] as $groupFieldName) {
                    $formData[$groupFieldName] = is_object($formData[$groupFieldName]) ? $formData[$groupFieldName]->getGid() : $formData[$groupFieldName];
                }
                $this->setVars($formData);
        
                $this->addFlash('status', $this->__('Done! Module configuration updated.'));
                $userName = $this->get('zikula_users_module.current_user')->get('uname');
                $this->get('logger')->notice('{app}: User {user} updated the configuration.', ['app' => 'MUYourCityModule', 'user' => $userName]);
            } elseif ($form->get('cancel')->isClicked()) {
                $this->addFlash('status', $this->__('Operation cancelled.'));
            }
        
            // redirect to config page again (to show with GET request)
            return $this->redirectToRoute('muyourcitymodule_import_import');
        }
        
        $templateParameters = [
            'form' => $form->createView()
        ];
        
        // render the config form
        return $this->render('@MUYourCityModule/Import/import.html.twig', $templateParameters);
    }
}
