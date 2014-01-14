<?php

class CalendarEntry extends DataObject {

   	private static $db = array(
   		'StartDate' => 'Date',
  		'EndDate' => 'Date',
  		'StartTime' => 'Time',
  		'EndTime' => 'Time',
  		'Title' => 'Varchar(255)',
  		'Location' => 'Text',
  		'Content' => 'Text',
   	);

   	private static $has_one = array(
   		'Resource' => 'File',
        'Photo' => 'Image',
   		'Calendar' => 'Calendar'
   	);

   	private static $summary_fields = array( 
        'Thumbnail' => 'Photo',
   		'NiceDates' => 'Date',
		'Title' => 'Title',
      	'ContentExcerpt' => 'Content'
   	);

   	function canCreate($Member = null) { return true; }
	function canEdit($Member = null) { return true; }
	function canView($Member = null) { return true; }
	function canDelete($Member = null) { return true; }

	public function getCMSFields() {
		$startdatefield = new DateField('StartDate','Start Date');
      	$startdatefield->setConfig('showcalendar', true);
      	$startdatefield->setConfig('dateformat','MM/dd/yyyy'); 
      	$enddatefield = new DateField('EndDate','End Date');
      	$enddatefield->setConfig('showcalendar', true);
      	$enddatefield->setConfig('dateformat','MM/dd/yyyy');
        $imagefield = UploadField::create('Photo');
        $imagefield->folderName = "Calendar"; 
        $imagefield->getValidator()->allowedExtensions = array('jpg','jpeg','gif','png');
      	$resourcefield = UploadField::create("Resource")->setTitle("Flyer/Brochure (PDF or Doc)");
		$resourcefield->folderName = "Calendar"; 
      	$resourcefield->getValidator()->allowedExtensions = array("pdf","doc","docx");
		return new FieldList(
			TextField::create("Title"),
			$startdatefield,
			$enddatefield,
			TimeField::create("StartTime")->setTitle("Start Time"),
			TimeField::create("EndTime")->setTitle("End Time"),
			TextField::create("Location"),
			$imagefield,
            $resourcefield,
			TextareaField::create("Content")->setTitle("Event Description")
		);
	}

	public function Link() {
		return $this->Calendar()->Link("show")."/".$this->ID;
	}

   	public function ContentExcerpt($length = 200) {
	   	$text = strip_tags($this->Content);
		$length = abs((int)$length);
		if(strlen($text) > $length) {
			$text = preg_replace("/^(.{1,$length})(\s.*|$)/s", '\\1...', $text);
		}
		return $text;
	}

	public function NiceStartDate() {
  		return $this->obj('StartDate')->Format("F j, Y");
  	}
  	
  	public function NiceEndDate() {
  		return $this->obj('EndDate')->Format("F j, Y");
  	}

  	public function NiceDates() {
  		if($this->StartDate AND $this->EndDate)
  			return $this->NiceStartDate() . " – " . $this->NiceEndDate();
  		elseif($this->StartDate)
  			return $this->NiceStartDate();
  		else
  			return false;
  	}

  	public function NiceStartTime() {
  		return $this->obj('StartTime')->Nice(); 
  	}

  	public function NiceEndTime() {
  		return $this->obj('EndTime')->Nice(); 
  	}

  	public function NiceTimes() {
  		if($this->StartTime AND $this->EndTime)
  			return $this->NiceStartTime() . " – " . $this->NiceEndTime();
  		elseif($this->StartTime)
  			return $this->NiceStartTime();
  		else 
  			return false;
  	}

  	public function CalendarLink() {
  		return $this->getComponent('Calendar')->Link();
  	}

    public function PhotoCropped($x=100,$y=100) {
         return $this->Photo()->CroppedImage($x,$y);
    }

    public function PhotoSized($x=400) {
         return $this->Photo()->setWidth($x);
    }

    public function Thumbnail() {
        $Image = $this->Photo();
        if ($Image) 
            return $Image->CMSThumbnail();
        else 
            return null;
    }

}

?>