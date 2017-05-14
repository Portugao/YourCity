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
use MU\YourCityModule\Form\Type\ImportType;
use DataUtil;
use ServiceUtil;
use PDO;
use PDOException;
use Doctrine_Manager;

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
        
        $form = $this->createForm(ImportType::class);
        
        if ($form->handleRequest($request)->isValid()) {
            if ($form->get('import')->isClicked()) {
            	
            	$entries = $this->getDatas();
            	
            	$this->insertDatas($entries);
            	
                //$formData = $form->getData();

                //$this->setVars($formData);
        
                $this->addFlash('status', $this->__('Done! Module configuration updated.'));
                $userName = $this->get('zikula_users_module.current_user')->get('uname');
                $this->get('logger')->notice('{app}: User {user} updated the configuration.', ['app' => 'MUYourCityModule', 'user' => $userName]);
            } elseif ($form->get('cancel')->isClicked()) {
                $this->addFlash('status', $this->__('Operation cancelled.'));
            }
        
            // redirect to import page again (to show with GET request)
            return $this->redirectToRoute('muyourcitymodule_import_import');
        }
        
        $templateParameters = [
            'form' => $form->createView()
        ];
        
        // render the config form
        return $this->render('@MUYourCityModule/Import/import.html.twig', $templateParameters);
    }
    
    /**
     *
     * @param array $args
     * return string $status
     */
    public function insertDatas($results)
    {
    	
    	
    	$results = $this->getDatas();

    	if ($results) {
    		foreach ($results as $result) {
    			$locations[] = $result;
    		}
    	}

    	// we get an entity manager
    	$entityManager = $this->container->get('doctrine.entitymanager');
    	
    	

    	if (is_array($locations)) {
    		foreach ($locations as $location) {

    			$data = $this->buildArrayForDatas($location);
    			// we build new location
    			$newLocation = new \MU\YourCityModule\Entity\LocationEntity();
    			
    			$newLocation->setWorkflowState('approved');    			
    			$newLocation->setName($data[0]['name']);
    			$newLocation->setLetterForOrder($data[0]['letterForOrder']);   			
    			$newLocation->setDescription($data[0]['description']);
    			$newLocation->setDescription2(NULL);
    			$newLocation->setDescriptionForGoogle(NULL);
    			$newLocation->setSlogan($data[0]['slogan']);
    			
    			$newLocation->setStreet($data[0]['street']);
    			$newLocation->setNumberOfStreet($data[0]['numberOfStreet']);
    			$newLocation->setZipCode($data[0]['zipCode']);
    			$newLocation->setCity($data[0]['city']);
    			$newLocation->setTelefon($data[0]['telefon']);
    			$newLocation->setMobil($data[0]['mobil']);
    			$newLocation->setHomepage($data[0]['homepage']);
    			
    			$newLocation->setLatitude($data[0]['latitude']);
    			$newLocation->setLongitude($data[0]['longitude']);
    			
    			$newLocation->setBsagStop($data[0]['bsagStop']);
    			$newLocation->setBus($data[0]['bus']);
    			$newLocation->setTram($data[0]['tram']);
    			
    			$newLocation->setClosedForEver($data[0]['closedForEver']);
    			$newLocation->setAgreement($data[0]['agreement']);
    			$newLocation->setUnclearTimes($data[0]['unclearTimes']);
    			
    			$newLocation->setClosedOnMonday($data[0]['closedOnMonday']);
    			$newLocation->setStartOnMonday($data[0]['startOnMonday']);
    			$newLocation->setEndOnMonday($data[0]['endOnMonday']);
    			$newLocation->setStart2OnMonday($data[0]['start2OnMonday']);
    			$newLocation->setEnd2OnMonday($data[0]['end2OnMonday']);
    			
    			$newLocation->setClosedOnTuesday($data[0]['closedOnTuesday']);
    			$newLocation->setStartOnTuesday($data[0]['startOnTuesday']);
    			$newLocation->setEndOnTuesday($data[0]['endOnTuesday']);
    			$newLocation->setStart2OnTuesday($data[0]['start2OnTuesday']);
    			$newLocation->setEnd2OnTuesday($data[0]['end2OnTuesday']);
    			
    			$newLocation->setClosedOnWednesday($data[0]['closedOnWednesday']);
    			$newLocation->setStartOnWednesday($data[0]['startOnWednesday']);
    			$newLocation->setEndOnWednesday($data[0]['endOnWednesday']);
    			$newLocation->setStart2OnWednesday($data[0]['start2OnWednesday']);
    			$newLocation->setEnd2OnWednesday($data[0]['end2OnWednesday']);
    			
    			$newLocation->setClosedOnThursday($data[0]['closedOnThursday']);
    			$newLocation->setStartOnThursday($data[0]['startOnThursday']);
    			$newLocation->setEndOnThursday($data[0]['endOnThursday']);
    			$newLocation->setStart2OnThursday($data[0]['start2OnThursday']);
    			$newLocation->setEnd2OnThursday($data[0]['end2OnThursday']);
    			
    			$newLocation->setClosedOnFriday($data[0]['closedOnFriday']);
    			$newLocation->setStartOnFriday($data[0]['startOnFriday']);
    			$newLocation->setEndOnFriday($data[0]['endOnFriday']);
    			$newLocation->setStart2OnFriday($data[0]['start2OnFriday']);
    			$newLocation->setEnd2OnFriday($data[0]['end2OnFriday']);
    			
    			$newLocation->setClosedOnSaturday($data[0]['closedOnSaturday']);
    			$newLocation->setStartOnSaturday($data[0]['startOnSaturday']);
    			$newLocation->setEndOnSaturday($data[0]['endOnSaturday']);
    			$newLocation->setStart2OnSaturday($data[0]['start2OnSaturday']);
    			$newLocation->setEnd2OnSaturday($data[0]['end2OnSaturday']);
    			
    			$newLocation->setClosedOnSunday($data[0]['closedOnSunday']);
    			$newLocation->setStartOnSunday($data[0]['startOnSunday']);
    			$newLocation->setEndOnSunday($data[0]['endOnSunday']);
    			$newLocation->setStart2OnSunday($data[0]['start2OnSunday']);
    			$newLocation->setEnd2OnSunday($data[0]['end2OnSunday']);
    			
    			$newLocation->setSlug($data[0]['slug']);
    			
    			$modelHelper = $this->get('mu_yourcity_module.model_helper');
    			$branchRespository = $modelHelper->getRepository('Branch');
    			$partRepository = $modelHelper->getRepository('Part');
    			
    			if ($data[0]['branchId'] && $data[0]['branchId'] > 0) {
    			$branches[] = $branchRespository->find($data[0]['branchId']);
    			$newLocation->setBranches($branches);
    			}
    			if ($data[0]['partId'] && $data[0]['partId'] > 0) {    			
    			$parts[] = $partRepository->find($data[0]['partId']);
    			$newLocation->setParts($parts);
    			}
    			
    			unset($branches);
    			unset($parts);
    			
    			$entityManager->persist($newLocation);
    			$entityManager->flush();
    		}
    	}
    	else {
    		return;
    	}
    
    	return;
    }
    
    /**
     *
     * Build data array for creating new entries
     * @param array $result
     * @return array of values
     */
    private function buildArrayForDatas($result)
    {

    		$result['field9'] = utf8_encode($result['field9']);
    		$result['field9'] = html_entity_decode($result['field9'], ENT_COMPAT);
    		$result['field10'] = utf8_encode($result['field10']);
    		
    		$partId = 0;
    		
    		// part handling
    		if ($result['field15'] == 'Alte Neustadt') {
    			$partId = 1;
    		}
    		if ($result['field15'] == 'Altstadt') {
    			$partId = 2;
    		}
    		if ($result['field15'] == 'Arbergen') {
    			$partId = 3;
    		}
    		if ($result['field15'] == 'Arsten') {
    			$partId = 4;
    		}
    		if ($result['field15'] == 'Aumund-Hammersbeck') {
    			$partId = 5;
    		}
    		if ($result['field15'] == 'Bahnhofsvorstadt') {
    			$partId = 6;
    		}
    		if ($result['field15'] == 'Barkhof') {
    			$partId = 7;
    		}
    		if ($result['field15'] == 'Blockdiek') {
    			$partId = 8;
    		}
    		if ($result['field15'] == 'Blockland') {
    			$partId = 9;
    		}
    		if ($result['field15'] == 'Blumenthal') {
    			$partId = 10;
    		}
    		if ($result['field15'] == 'Borgfeld') {
    			$partId = 11;
    		}
    		if ($result['field15'] == 'Buntentor') {
    			$partId = 12;
    		}
    		if ($result['field15'] == 'Burgdamm') {
    			$partId = 13;
    		}
    		if ($result['field15'] == 'Burg-Grambke') {
    			$partId = 14;
    		}
    		if ($result['field15'] == 'B�rgerpark') {
    			$partId = 15;
    		}    		
    		if ($result['field15'] == 'Ellener Feld') {
    			$partId = 16;
    		}
    		if ($result['field15'] == 'Ellenerbrok-Schevemoor') {
    			$partId = 17;
    		}
    		if ($result['field15'] == 'F�hr-Lobbendorf') {
    			$partId = 18;
    		}
    		if ($result['field15'] == 'Farge') {
    			$partId = 19;
    		}
    		if ($result['field15'] == 'Fesenfeld') {
    			$partId = 20;
    		}
    		if ($result['field15'] == 'Findorff-B�rgerweide') {
    			$partId = 21;
    		}
    		if ($result['field15'] == 'Gatrenstadt S�d') {
    			$partId = 22;
    		}
    		if ($result['field15'] == 'Gartenstadt Vahr') {
    			$partId = 23;
    		}
    		if ($result['field15'] == 'Gete') {
    			$partId = 24;
    		}
    		if ($result['field15'] == 'Grohn') {
    			$partId = 25;
    		}
    		if ($result['field15'] == 'Grolland') {
    			$partId = 26;
    		}
    		if ($result['field15'] == 'Gr�pelingen') {
    			$partId = 27;
    		}
    		if ($result['field15'] == 'Habenhausen') {
    			$partId = 28;
    		}
    		if ($result['field15'] == 'Handelsh�fen') {
    			$partId = 29;
    		}
    		if ($result['field15'] == 'Hastedt') {
    			$partId = 30;
    		}
    		if ($result['field15'] == 'Hemelingen') {
    			$partId = 31;
    		}
    		if ($result['field15'] == 'Hohentor') {
    			$partId = 32;
    		}
    		if ($result['field15'] == 'Hohentorshafen') {
    			$partId = 33;
    		}
    		if ($result['field15'] == 'Hohweg') {
    			$partId = 34;
    		}
    		if ($result['field15'] == 'Horn') {
    			$partId = 35;
    		}
    		if ($result['field15'] == 'Huckelriede') {
    			$partId = 36;
    		}
    		if ($result['field15'] == 'Hulsberg') {
    			$partId = 37;
    		}
    		if ($result['field15'] == 'In den Hufen') {
    			$partId = 38;
    		}
    		if ($result['field15'] == 'In den Wischen') {
    			$partId = 39;
    		}
    		if ($result['field15'] == 'Indutrieh�fen') {
    			$partId = 40;
    		}
    		if ($result['field15'] == 'Kattenesch') {
    			$partId = 41;
    		}
    		if ($result['field15'] == 'Kattenturm') {
    			$partId = 42;
    		}
    		if ($result['field15'] == 'Kirchhuchting') {
    			$partId = 43;
    		}
    		if ($result['field15'] == 'Lehe') {
    			$partId = 44;
    		}
    		if ($result['field15'] == 'Lehester Deich') {
    			$partId = 45;
    		}
    		if ($result['field15'] == 'Lesum') {
    			$partId = 46;
    		}
    		if ($result['field15'] == 'Lindenhof') {
    			$partId = 47;
    		}
    		if ($result['field15'] == 'L�ssum-Bockhorn') {
    			$partId = 48;
    		}
    		if ($result['field15'] == 'Mahndorf') {
    			$partId = 49;
    		}
    		if ($result['field15'] == 'Mitte') {
    			$partId = 50;
    		}
    		if ($result['field15'] == 'Mittelshuchting') {
    			$partId = 51;
    		}
    		if ($result['field15'] == 'Neu-Schwachhausen') {
    			$partId = 52;
    		}
    		if ($result['field15'] == 'Neue Vahr Nord') {
    			$partId = 53;
    		}
    		if ($result['field15'] == 'Neue Vahr S�dost') {
    			$partId = 54;
    		}
    		if ($result['field15'] == 'Neue Vahr S�dwest') {
    			$partId = 55;
    		}
    		if ($result['field15'] == 'Neuenland') {
    			$partId = 56;
    		}
    		if ($result['field15'] == 'Neust�dter Hafen') {
    			$partId = 57;
    		}
    		if ($result['field15'] == 'Oberneuland') {
    			$partId = 58;
    		}
    		if ($result['field15'] == 'Ohlenhof') {
    			$partId = 59;
    		}
    		if ($result['field15'] == 'Oslebshausen') {
    			$partId = 60;
    		}
    		if ($result['field15'] == 'Osterfeuerberg') {
    			$partId = 61;
    		}
    		if ($result['field15'] == 'Osterholz') {
    			$partId = 62;
    		}
    		if ($result['field15'] == 'Ostertor') {
    			$partId = 63;
    		}
    		if ($result['field15'] == 'Peterswerder') {
    			$partId = 64;
    		}
    		if ($result['field15'] == 'Rablinghausen') {
    			$partId = 65;
    		}
    		if ($result['field15'] == 'Radio Bremen') {
    			$partId = 66;
    		}
    		if ($result['field15'] == 'Regensburger Stra�e') {
    			$partId = 67;
    		}
    		if ($result['field15'] == 'Rekum') {
    			$partId = 68;
    		}
    		if ($result['field15'] == 'Riensberg') {
    			$partId = 69;
    		}
    		if ($result['field15'] == 'R�nnebeck') {
    			$partId = 70;
    		}
    		if ($result['field15'] == 'Sch�nebeck') {
    			$partId = 71;
    		}
    		if ($result['field15'] == 'Schwachhausen') {
    			$partId = 72;
    		}
    		if ($result['field15'] == 'Sebaldsbr�ck') {
    			$partId = 73;
    		}
    		if ($result['field15'] == 'Seehausen') {
    			$partId = 74;
    		}
    		if ($result['field15'] == 'Sodenmatt') {
    			$partId = 75;
    		}
    		if ($result['field15'] == 'St. Magnus') {
    			$partId = 76;
    		}
    		if ($result['field15'] == 'Steffensweg') {
    			$partId = 77;
    		}
    		if ($result['field15'] == 'Steintor') {
    			$partId = 78;
    		}
    		if ($result['field15'] == 'Strom') {
    			$partId = 79;
    		}
    		if ($result['field15'] == 'S�dervorstadt') {
    			$partId = 80;
    		}
    		if ($result['field15'] == 'Tenever') {
    			$partId = 81;
    		}
    		if ($result['field15'] == 'Utbremen') {
    			$partId = 82;
    		}
    		if ($result['field15'] == 'Vegesack') {
    			$partId = 83;
    		}
    		if ($result['field15'] == 'Walle') {
    			$partId = 84;
    		}
    		if ($result['field15'] == 'Weidedamm') {
    			$partId = 85;
    		}
    		if ($result['field15'] == 'Werderland') {
    			$partId = 86;
    		}
    		if ($result['field15'] == 'Westend') {
    			$partId = 87;
    		}
    		if ($result['field15'] == 'Woltmershausen') {
    			$partId = 88;
    		}
    		
    		$branchId = 0;
    		
    		// branch handling
    		if ($result['field16'] == 'Autohaus & Co') {
    			$branchId = 1;
    		}
    		if ($result['field16'] == 'B�ckerei') {
    			$branchId = 2;
    		}
    		if ($result['field16'] == 'Banken') {
    			$branchId = 3;
    		}
    		if ($result['field16'] == 'Baumarkt') {
    			$branchId = 4;
    		}
    		if ($result['field16'] == 'Beh�rden') {
    			$branchId = 5;
    		}
    		if ($result['field16'] == 'Dienstleistung') {
    			$branchId = 6;
    		}
    		if ($result['field16'] == 'Discounter') {
    			$branchId = 7;
    		}
    		if ($result['field16'] == 'Einkaufszentren') {
    			$branchId = 8;
    		}
    		if ($result['field16'] == 'Einzelhandel') {
    			$branchId = 9;
    		}
    		if ($result['field16'] == 'Freizeit') {
    			$branchId = 10;
    		}
    		if ($result['field16'] == 'Gastronomie') {
    			$branchId = 11;
    		}
    		if ($result['field16'] == 'Gesundheit') {
    			$branchId = 12;
    		}
    		if ($result['field16'] == 'Handelskette') {
    			$branchId = 13;
    		}
    		if ($result['field16'] == 'Handwerk') {
    			$branchId = 14;
    		}
    		if ($result['field16'] == 'Hotel & Co') {
    			$branchId = 15;
    		}
    		if ($result['field16'] == 'Kaufhaus') {
    			$branchId = 16;
    		}
    		if ($result['field16'] == 'Kultur') {
    			$branchId = 17;
    		}
    		if ($result['field16'] == 'Post') {
    			$branchId = 18;
    		}
    		if ($result['field16'] == 'Supermarkt') {
    			$branchId = 19;
    		}
    		if ($result['field16'] == 'Verein') {
    			$branchId = 20;
    		}
    		if ($result['field16'] == 'Wochenm�rkte') {
    			$branchId = 21;
    		}
    		
    		if ($result['field32'] == '' && $result['field33'] == '' && $result['field34'] == '' && $result['field35'] == '') {
    			$closedMonday = true;
    		} else {
    			$closedMonday = false;
    		}
    		if ($result['field36'] == '' && $result['field37'] == '' && $result['field38'] == '' && $result['field39'] == '') {
    			$closedTuesday = true;
    		} else {
    			$closedTuesday = false;
    		}
    		if ($result['field43'] == '' && $result['field44'] == '' && $result['field44'] == '' && $result['field46'] == '') {
    			$closedWednesday = true;
    		} else {
    			$closedWednesday = false;
    		}
    		if ($result['field47'] == '' && $result['field48'] == '' && $result['field49'] == '' && $result['field50'] == '') {
    			$closedThursday = true;
    		} else {
    			$closedThursday = false;
    		}
    		if ($result['field51'] == '' && $result['field52'] == '' && $result['field53'] == '' && $result['field54'] == '') {
    			$closedFriday = true;
    		} else {
    			$closedFriday = false;
    		}
    		if ($result['field55'] == '' && $result['field56'] == '' && $result['field57'] == '' && $result['field58'] == '') {
    			$closedSaturday = true;
    		} else {
    			$closedSaturday = false;
    		}
    		if ($result['field59'] == '' && $result['field60'] == '' && $result['field61'] == '' && $result['field62'] == '') {
    			$closedSunday = true;
    		} else {
    			$closedSunday = false;
    		}
    		
    		$result['field11'] = str_replace('�', 'ae', $result['field11']);
    		$result['field102'] = str_replace('�', 'ae', $result['field102']);
    		
    		$result['field11'] = str_replace('�', 'oe', $result['field11']);
    		$result['field102'] = str_replace('�', 'oe', $result['field102']);
    		
    		$result['field11'] = str_replace('�', 'ue', $result['field11']);
    		$result['field102'] = str_replace('�', 'ue', $result['field102']);
    		
    		$result['field11'] = str_replace('�', 'Ae', $result['field11']);
    		$result['field102'] = str_replace('�', 'Ae', $result['field102']);
    		
    		$result['field11'] = str_replace('�', 'Oe', $result['field11']);
    		$result['field102'] = str_replace('�', 'Oe', $result['field102']);
    		
    		$result['field11'] = str_replace('�', 'Ue', $result['field11']);
    		$result['field102'] = str_replace('�', 'Ue', $result['field102']);
    		
    		$result['field11'] = str_replace('�', 'ss', $result['field11']);
    		$result['field102'] = str_replace('�', 'ss', $result['field102']);
    		
    		
    		if ($result['field91'] != '') {
    			
    		$result['field91'] = str_replace('(', '', $result['field91']);
    		$result['field91'] = str_replace(')', '', $result['field91']);

    		$geo = explode(",", $result['field91']);
    		if (is_array($geo)) {
    		if ($geo[0] != '') {
    		$latitude = $geo[0];
    		} else {
    			$latitude = '';
    		}
    		if ($geo[1] != '') {
    		$longitude = $geo[1];
    		} else {
    			$longitude = '';
    		}
    		}
    		} else {
    			$latitude = '';
    			$longitude = '';
    		}
    		
    		if (isset($result['187'])) {
    			$closedForEver = $result['187'];
    		} else {
    			$closedForEver = 0;
    		}
    		if (isset($result['199'])) {
    			$openingHours = $result['199'];
    		} else {
    			$openingHours = '';
    		}
    		
    		$data[0] = array(
    				'id' => $result['id'],
    				'workflowState' => 'approved',
    				'name' => $result['field9'],
    				'letterForOrder' => $result['field107'],
    				'slogan' => $result['field106'],
    				'logoOfYourLocationMeta' => 'a:0:{}',
    				'logoOfYourLocation' => NULL,
    				'descriptionForGoogle' => '',
    				'description' => $result['field10'],
    		        'description2' => '',
    		        'imageOfLocationMeta' => 'a:0:{}',
    		        'imageOfLocation' => NULL,
    		        'street' => $result['field11'],
    		        'numberOfStreet' => $result['field12'],
    		        'zipCode' => $result['field42'],
    		        'city' => $result['field14'],
    		        'telefon' => $result['field21'],
    		        'mobil' => $result['field22'],
    		        'homepage' => $result['field24'],
    		        'bsagStop' => $result['field102'],
    		        'tram' => $result['field103'],
    		        'bus' => $result['field104'],
    				'branchId' => $branchId,
    				'partId' => $partId,
    		        'closedForEver' => $closedForEver,
    		        'agreement' => $result['field69'],
    		        'unclearTimes' => $result['field67'],
    		        'openingHours' => $openingHours,
    		        'closedOnMonday' => $closedMonday,
    		        'startOnMonday' => $result['field32'],
    		        'endOnMonday' => $result['field33'],
    				'start2OnMonday' => $result['field34'],
    				'end2OnMonday' => $result['field35'],
    				'closedOnTuesday' => $closedTuesday,
    				'startOnTuesday' => $result['field36'],
    				'endOnTuesday' => $result['field37'],
    				'start2OnTuesday' => $result['field38'],
    				'end2OnTuesday' => $result['field39'],
    				'closedOnWednesday' => $closedWednesday,
    				'startOnWednesday' => $result['field43'],
    				'endOnWednesday' => $result['field44'],
    				'start2OnWednesday' => $result['field45'],
    				'end2OnWednesday' => $result['field46'],
    				'closedOnThursday' => $closedThursday,
    				'startOnThursday' => $result['field47'],
    				'endOnThursday' => $result['field48'],
    				'start2OnThursday' => $result['field49'],
    				'end2OnThursday' => $result['field50'],
    				'closedOnFriday' => $closedFriday,
    				'startOnFriday' => $result['field51'],
    				'endOnFriday' => $result['field52'],
    				'start2OnFriday' => $result['field53'],
    				'end2OnFriday' => $result['field54'],
    				'closedOnSaturday' => $closedSaturday,
    				'startOnSaturday' => $result['field55'],
    				'endOnSaturday' => $result['field56'],
    				'start2OnSaturday' => $result['field57'],
    				'end2OnSaturday' => $result['field58'], 
    				'closedOnSunday' => $closedSunday,
    				'startOnSunday' => $result['field59'],
    				'endOnSunday' => $result['field60'],
    				'start2OnSunday' => $result['field61'],
    				'end2OnSunday' => $result['field62'], 
    				'slug' => $result['urltitle'],
    				'latitude' => $latitude,
    				'longitude' => $longitude,
    				'createdDate' => $result['cr_date'],
    				'updatedDate' => $result['lu_date'],
    				'owner_id' => NULL,
    				'admin1_id' => NULL,
    				'admin2_id' => NULL,
    				'createdBy_id' => $result['cr_uid'],
    				'updatedBy_id' => $result['lu_uid']
    				)
    		        		;
    	
    	return $data;
    }   
    

    
    
    /**
     *
     * Get entries of table
     * 
     *
     * @return an array of files
     */
    private function getDatas()
    {
    	$table = 'clip_pubdata3';
    	//$moduletable = $this->getPraefix(). $table;
    	$connect = $this->getDBConnection();
    	// ask the DB for entries in the module table
    	// handle the access to the module file table
    	// build sql

    	$query = "SELECT * FROM " . $table . " WHERE id >= 600 and id < 700 ORDER by id";

    	// prepare the sql query
    	$sql = $connect->query($query);
    	
    	$connect = null;
    	return $sql;
    }
    
    /**
     *
     * Get the item just imported by name
     *
     *
     * @return an array of files
     */
    private function getFreshImport($slug)
    {
    	$table2 = 'mu_yourcity_location';
    	//$moduletable = $this->getPraefix(). $table;
    	$connect2 = $this->getDBConnection();
    	// ask the DB for entries in the module table
    	// handle the access to the module file table
    	// build sql    
    	//$query = 'SELECT * FROM mu_yourcity_location WHERE name LIKE %"' . $name . '"%';
    	$query2 = "SELECT * FROM " . $table2 . " WHERE slug LIKE '%" . \DataUtil::formatForStore($slug) . "%'"; 
    	//die($query2);
    	// prepare the sql query
    	$sql2 = $connect2->query($query2);
    	 
    	$connect2 = null;
    	return $sql2;
    }
    

    /**
     * Get a connection to DB
     *
     * @return a connection
     */
    private function getDBConnection()
    {
    	//get host, db, user and pw
    	$databases = ServiceUtil::getManager()->getArgument('databases');
    	$connName = Doctrine_Manager::getInstance()->getCurrentConnection()->getName();
    	$host = $databases[$connName]['host'];
    	$dbname = $databases[$connName]['dbname'];
    	$dbuser = $databases[$connName]['user'];
    	$dbpassword = $databases[$connName]['password'];

    	try {
    		$connect = new \PDO("mysql:host=$host;dbname=$dbname", $dbuser, $dbpassword);
    	}
    	catch (PDOException $e) {
    		$this->__('Connection to database failed');
    	}
    	if (is_object($connect)) {
    		return $connect;
    	} else {
    		return false;
    	}
    
    }
    
    private function mysqliCon()
    {
    	//get host, db, user and pw
    	$databases = ServiceUtil::getManager()->getArgument('databases');
    	$connName = Doctrine_Manager::getInstance()->getCurrentConnection()->getName();
    	$host = $databases[$connName]['host'];
    	$dbname = $databases[$connName]['dbname'];
    	$dbuser = $databases[$connName]['user'];
    	$dbpassword = $databases[$connName]['password'];
    	
    	$con=mysqli_connect($host,$dbuser,$dbpassword,$dbname);
    	return $con;
    }
}
