<?php
CModule::AddAutoloadClasses(
    '',
    array(
        /**
         * interfaces
         */
        'MWI\IBEntityInterface' => '/local/php_interface/lib/interfaces/MWI/IBEntityInterface.php',
        'MWI\CollectionInterface' => '/local/php_interface/lib/interfaces/MWI/CollectionInterface.php',
        'MWI\TaggedCacheInterface' => '/local/php_interface/lib/interfaces/MWI/TaggedCacheInterface.php',

        /**
         * traits
         */
        'MWI\IBEntityValidatorTrait' => '/local/php_interface/lib/traits/MWI/IBEntityValidatorTrait.php',
        'MWI\DisplayedTrait' => '/local/php_interface/lib/traits/MWI/DisplayedTrait.php',
        'MWI\LangIBInfoTrait' => '/local/php_interface/lib/traits/MWI/LangIBInfoTrait.php',
        'MWI\LangHLBInfoTrait' => '/local/php_interface/lib/traits/MWI/LangHLBInfoTrait.php',

        /**
         * abstract
         */
        'MWI\AbstractCollection' => '/local/php_interface/lib/classes/MWI/AbstractCollection.php',

        /**
         * IB Entities
         */
        'MWI\Device' => '/local/php_interface/lib/classes/MWI/Device.php',
        'MWI\Lang' => '/local/php_interface/lib/classes/MWI/Lang.php',
        'MWI\Version' => '/local/php_interface/lib/classes/MWI/Version.php',
        'MWI\File' => '/local/php_interface/lib/classes/MWI/File.php',
        'MWI\Content' => '/local/php_interface/lib/classes/MWI/Content.php',
        'MWI\Stock' => '/local/php_interface/lib/classes/MWI/Entities/IB/Stock.php',
        'MWI\StockList' => '/local/php_interface/lib/classes/MWI/Entities/IB/StockList.php',
        'MWI\ServiceOffer' => '/local/php_interface/lib/classes/MWI/Entities/IB/ServiceOffer.php',
        'MWI\ServiceOfferList' => '/local/php_interface/lib/classes/MWI/Entities/IB/ServiceOfferList.php',
        'MWI\Direction' => '/local/php_interface/lib/classes/MWI/Entities/IB/Direction.php',
        'MWI\DirectionList' => '/local/php_interface/lib/classes/MWI/Entities/IB/DirectionList.php',
        'MWI\Video' => '/local/php_interface/lib/classes/MWI/Entities/IB/Video.php',
        'MWI\Service' => '/local/php_interface/lib/classes/MWI/Entities/IB/Service.php',
        'MWI\ServiceList' => '/local/php_interface/lib/classes/MWI/Entities/IB/ServiceList.php',
        'MWI\Disease' => '/local/php_interface/lib/classes/MWI/Entities/IB/Disease.php',
        'MWI\DiseaseList' => '/local/php_interface/lib/classes/MWI/Entities/IB/DiseaseList.php',
        'MWI\Symptom' => '/local/php_interface/lib/classes/MWI/Entities/IB/Symptom.php',
        'MWI\SymptomList' => '/local/php_interface/lib/classes/MWI/Entities/IB/SymptomList.php',
        'MWI\Question' => '/local/php_interface/lib/classes/MWI/Entities/IB/Question.php',
        'MWI\QuestionList' => '/local/php_interface/lib/classes/MWI/Entities/IB/QuestionList.php',
        'MWI\Recommendation' => '/local/php_interface/lib/classes/MWI/Entities/IB/Recommendation.php',
        'MWI\RecommendationList' => '/local/php_interface/lib/classes/MWI/Entities/IB/RecommendationList.php',
        'MWI\Personal' => '/local/php_interface/lib/classes/MWI/Entities/IB/Personal.php',
        'MWI\PersonalList' => '/local/php_interface/lib/classes/MWI/Entities/IB/PersonalList.php',
        'MWI\Program' => '/local/php_interface/lib/classes/MWI/Entities/IB/Program.php',
        'MWI\ProgramList' => '/local/php_interface/lib/classes/MWI/Entities/IB/ProgramList.php',
        'MWI\Review' => '/local/php_interface/lib/classes/MWI/Entities/IB/Review.php',
        'MWI\ReviewList' => '/local/php_interface/lib/classes/MWI/Entities/IB/ReviewList.php',
        'MWI\Clinic' => '/local/php_interface/lib/classes/MWI/Entities/IB/Clinic.php',
        'MWI\ClinicList' => '/local/php_interface/lib/classes/MWI/Entities/IB/ClinicList.php',
        'MWI\UsefulInformation' => '/local/php_interface/lib/classes/MWI/Entities/IB/UsefulInformation.php',
        'MWI\Publication' => '/local/php_interface/lib/classes/MWI/Entities/IB/Publication.php',
        'MWI\News' => '/local/php_interface/lib/classes/MWI/Entities/IB/News.php',
        'MWI\ContentPage' => '/local/php_interface/lib/classes/MWI/Entities/IB/ContentPage.php',
        'MWI\FAQ' => '/local/php_interface/lib/classes/MWI/Entities/IB/FAQ.php',
        'MWI\LawDocuments' => '/local/php_interface/lib/classes/MWI/Entities/IB/LawDocuments.php',
        'MWI\VacancyApplication' => '/local/php_interface/lib/classes/MWI/Entities/IB/VacancyApplication.php',
        'MWI\HousecallApplication' => '/local/php_interface/lib/classes/MWI/Entities/IB/HousecallApplication.php',
        'MWI\CreditApplication' => '/local/php_interface/lib/classes/MWI/Entities/IB/CreditApplication.php',
        'MWI\Bank' => '/local/php_interface/lib/classes/MWI/Entities/IB/Bank.php',
        'MWI\Vacancy' => '/local/php_interface/lib/classes/MWI/Entities/IB/Vacancy.php',
        'MWI\Advantage' => '/local/php_interface/lib/classes/MWI/Entities/IB/Advantage.php',
        'MWI\BannerMain' => '/local/php_interface/lib/classes/MWI/Entities/IB/BannerMain.php',

        /**
         * HLB Entities
         */
        'MWI\ProgramsTypes' => '/local/php_interface/lib/classes/MWI/Entities/HLB/ProgramsTypes.php',
        'MWI\PatientsTypes' => '/local/php_interface/lib/classes/MWI/Entities/HLB/PatientsTypes.php',
        'MWI\ServicesTypes' => '/local/php_interface/lib/classes/MWI/Entities/HLB/ServicesTypes.php',
        'MWI\ClinicsTypes' => '/local/php_interface/lib/classes/MWI/Entities/HLB/ClinicsTypes.php',
        'MWI\Departments' => '/local/php_interface/lib/classes/MWI/Entities/HLB/Departments.php',
        'MWI\Cities' => '/local/php_interface/lib/classes/MWI/Entities/HLB/Cities.php',
        'MWI\VideoTypes' => '/local/php_interface/lib/classes/MWI/Entities/HLB/VideoTypes.php',
        'MWI\BodyParts' => '/local/php_interface/lib/classes/MWI/Entities/HLB/BodyParts.php',
        'MWI\Alphabet' => '/local/php_interface/lib/classes/MWI/Entities/HLB/Alphabet.php',

        /**
         * HLB Tables
         */
        'MWI\ProgramsTypesTable' => '/local/php_interface/lib/classes/MWI/Entities/HLB/Tables/ProgramsTypesTable.php',
        'MWI\ServicesTypesTable' => '/local/php_interface/lib/classes/MWI/Entities/HLB/Tables/ServicesTypesTable.php',
        'MWI\PatientsTypesTable' => '/local/php_interface/lib/classes/MWI/Entities/HLB/Tables/PatientsTypesTable.php',
        'MWI\DepartmentsTable' => '/local/php_interface/lib/classes/MWI/Entities/HLB/Tables/DepartmentsTable.php',
        'MWI\ClinicsTypesTable' => '/local/php_interface/lib/classes/MWI/Entities/HLB/Tables/ClinicsTypesTable.php',
        'MWI\CitiesTable' => '/local/php_interface/lib/classes/MWI/Entities/HLB/Tables/CitiesTable.php',
        'MWI\VideoTypesTable' => '/local/php_interface/lib/classes/MWI/Entities/HLB/Tables/VideoTypesTable.php',
        'MWI\BodyPartsTable' => '/local/php_interface/lib/classes/MWI/Entities/HLB/Tables/BodyPartsTable.php',
        'MWI\AlphabetTable' => '/local/php_interface/lib/classes/MWI/Entities/HLB/Tables/AlphabetTable.php',

        /**
         * Properties
         */
        'CustomTypeMenu' => '/local/php_interface/lib/classes/MWI/Properties/CustomTypeMenu.php',

        /**
         * PDO
         */
        'MWI\Dbconnect' => '/local/php_interface/lib/pdo/Db.php',
        'MWI\Price' => '/local/php_interface/lib/pdo/Price.php',
    )
);

require_once('lib/const/recaptcha.php');

require_once('lib/functions/dev.php');
require_once('lib/functions/recaptcha.php');
require_once('lib/functions/cache.php');
require_once('lib/functions/numbers.php');
require_once('lib/functions/strings.php');
require_once('lib/functions/array.php');
require_once('lib/functions/dbresult.php');

/**
 * handlers
 */
require_once('lib/handlers/HLB/programsTypes.php');
require_once('lib/handlers/HLB/servicesTypes.php');
require_once('lib/handlers/HLB/patientsTypes.php');
require_once('lib/handlers/HLB/clinicsTypes.php');
require_once('lib/handlers/HLB/cities.php');
require_once('lib/handlers/HLB/departments.php');
require_once('lib/handlers/HLB/bodyParts.php');
require_once('lib/handlers/HLB/alphabet.php');

require_once('lib/handlers/Properties/menu.php');

require_once('lib/handlers/404.php');

/**
 * close access for unauth users
 */
require_once('lib/handlers/close_access.php');


/**
 * system tools
 */
require_once('lib/404.php');
//require_once('lib/close_access.php');

define(CUR_LANG, MWI\Lang::getCurrent()['ID']);


function dump ( $arr ){
	global $USER;
	if ($USER->IsAdmin()){
		echo '<pre>';print_r( $arr );echo '</pre>';	
	}
}

\Bitrix\Main\EventManager::getInstance()->addEventHandler("main", "OnEndBufferContent", "checkForms");

function checkForms (&$content) {
	for ($i = 1; $i < 20; $i++ ){
		$content = str_replace('#FORM_'.$i . '#', '<div class="on_ajax_form" id="'. randString(5) .'" data-id="'.$i.'"></div>', $content);
	}
}


/*
if ( $_SERVER['REQUEST_URI'] != strtolower( $_SERVER['REQUEST_URI']) ) {
    header('Location: http://'.$_SERVER['HTTP_HOST'] . 
            strtolower($_SERVER['REQUEST_URI']), true, 301);
    exit();
}
*/