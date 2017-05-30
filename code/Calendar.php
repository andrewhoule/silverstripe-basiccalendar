<?php

class Calendar extends Page

{
    private static $db = array (
        'EventsPerPage' => 'Int',
        'PhotoThumbnailHeight' => 'Int',
        'PhotoThumbnailWidth' => 'Int',
        'PhotoFullHeight' => 'Int',
        'PhotoFullWidth' => 'Int',
        'ShowExcerpt' => 'Boolean',
    );

    private static $has_many = array (
        'CalendarEntries' => 'CalendarEntry',
    );

    public function singular_name()
    {
        return 'Event Listing Page';
    }

    private static $defaults = array (
        'EventsPerPage' => '20',
        'PhotoThumbnailWidth' => '150',
        'PhotoThumbnailHeight' => '150',
        'PhotoFullWidth' => '700',
        'PhotoFullHeight' => '700',
        'ShowExcerpt' => true,
    );

    private static $icon = 'basiccalendar/images/calendar';

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldToTab('Root.Events',
            GridField::create(
                'CalendarEntries',
                'Events',
                $this->CalendarEntries(),
                GridFieldConfig_RecordEditor::create(50)
            )
        );
        $fields->addFieldsToTab('Root.Config', array(
            CheckboxField::create('ShowExcerpt')
                ->setTitle('Show Excerpts on Holder Page'),
            SliderField::create('EventsPerPage', 'Number of Events Per Page', 1, 50),
            SliderField::create('PhotoThumbnailWidth', 'Photo Thumbnail Width', 50, 400),
            SliderField::create('PhotoThumbnailHeight', 'Photo Thumbnail Height', 50, 400),
            SliderField::create('PhotoFullWidth', 'Photo Fullsize Width', 400, 1200),
            SliderField::create('PhotoFullHeight', 'Photo Fullsize Height', 400, 1200)
        ));
        return $fields;
    }

    public function getUpcomingEvents()
    {
        $calendarentries = $this->getComponents('CalendarEntries')->sort('StartDate', 'ASC');
        $calendarentrylist = new ArrayList();
        if ($calendarentries) {
            foreach ($calendarentries as $calendarentry) {
                if ($calendarentry->EndDate) {
                    if (strtotime($calendarentry->EndDate) > strtotime('yesterday')) {
                        $calendarentrylist->push($calendarentry);
                    }
                } elseif (strtotime($calendarentry->StartDate) > strtotime('yesterday')) {
                    $calendarentrylist->push($calendarentry);
                }
            }

            return $calendarentrylist;
        }
    }

    public function UpcomingEvents($limit = 5)
    {
        return $this->getUpcomingEvents()->limit($limit);
    }

}

class Calendar_Controller extends Page_Controller

{

    private static $allowed_actions = array(
        'show',
    );

    public function getCalendarEntry()
    {
        $Params = $this->getURLParams();
        if (is_numeric($Params['ID']) && $CalendarEntry = CalendarEntry::get()->byID((int) $Params['ID'])) {
            return $CalendarEntry;
        }
    }

    public function show()
    {
        if ($CalendarEntry = $this->getCalendarEntry()) {
            $Data = array(
                'CalendarEntry' => $CalendarEntry,
            );
            return $this->Customise($Data);
        } else {
            return $this->httpError(404, 'Sorry that calendar entry could not be found');
        }
    }

    public function init()
    {
        parent::init();
        Requirements::CSS('basiccalendar/css/calendar.css');
    }

    public function PaginatedUpcomingEvents()
    {
        $PaginatedUpcomingEvents = new PaginatedList($this->getUpcomingEvents(), $this->request);
        $PaginatedUpcomingEvents->setPageLength($this->EventsPerPage ? $this->EventsPerPage : '20');
        return $PaginatedUpcomingEvents;
    }

}
