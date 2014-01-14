<?php 
 
class Calendar extends Page {

	private static $has_many = array(
        'CalendarEntries' => 'CalendarEntry'
    );

	private static $icon = "basiccalendar/images/calendar";

	public function getCMSFields() {
		$fields = parent::getCMSFields();
		$CalendarGridField = new GridField(
            'CalendarEntries',
            'Calendar Entry',
            $this->CalendarEntries(),
            GridFieldConfig::create()
                ->addComponent(new GridFieldToolbarHeader())
                ->addComponent(new GridFieldAddNewButton('toolbar-header-right'))
                ->addComponent(new GridFieldSortableHeader())
                ->addComponent(new GridFieldDataColumns())
                ->addComponent(new GridFieldPaginator(50))
                ->addComponent(new GridFieldEditButton())
                ->addComponent(new GridFieldDeleteAction())
                ->addComponent(new GridFieldDetailForm())
        );
        $fields->addFieldToTab("Root.Events", $CalendarGridField);
		return $fields;
	}

    public function getUpcomingEvents() {
        $calendarentries = $this->getComponents("CalendarEntries")->sort("StartDate","ASC");
        $calendarentrylist = new ArrayList();
        if($calendarentries->exists()) {
            foreach($calendarentries AS $calendarenty) {
                if($calendarenty->EndDate) {
                    if(strtotime($calendarenty->EndDate) >= strtotime("now")) {
                        $calendarentrylist->push($calendarenty);
                    }
                }
                elseif(strtotime($calendarenty->StartDate) >= strtotime("now")) {
                    $calendarentrylist->push($calendarenty);
                }
            }
            return $calendarentrylist;
        }
    }

    public function UpcomingEvents($limit=5) {
        return $this->getUpcomingEvents()->limit($limit);
    }
 
}
 
class Calendar_Controller extends Page_Controller {

	private static $allowed_actions = array(
    	'show'
   	);

   	public function getCalendarEntry() {
		$Params = $this->getURLParams();
		if(is_numeric($Params['ID']) && $CalendarEntry = CalendarEntry::get()->byID((int)$Params['ID'])) {
			return $CalendarEntry;
		}
	}

   	public function show() {       
      if($CalendarEntry = $this->getCalendarEntry()) {
         $Data = array(
            'CalendarEntry' => $CalendarEntry
         );
         return $this->Customise($Data);
      }
      else {
         return $this->httpError(404, 'Sorry that calendar entry could not be found');
      }
   }

	public function init() {
    	parent::init();
      	Requirements::CSS("basiccalendar/css/calendar.css");
   	}

   	public function PaginatedUpcomingEvents() {
	  	$PaginatedUpcomingEvents = new PaginatedList($this->getUpcomingEvents(), $this->request);
	  	$PaginatedUpcomingEvents->setPageLength('15');
	  	return $PaginatedUpcomingEvents;
	}
	
}

?>