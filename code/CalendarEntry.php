<?php

class CalendarEntry extends DataObject

{
    private static $db = array (
        'StartDate' => 'Date',
        'EndDate' => 'Date',
        'StartTime' => 'Time',
        'EndTime' => 'Time',
        'Title' => 'Varchar(255)',
        'Location' => 'Text',
        'Content' => 'HTMLText',
    );

    private static $has_one = array (
        'Resource' => 'File',
        'Photo' => 'Image',
        'Calendar' => 'Calendar',
    );

    private static $summary_fields = array (
        'Thumbnail' => 'Photo',
        'StartDate' => 'Start Date',
        'EndDate' => 'End Date',
        'Title' => 'Title'
    );

    public function singular_name()
    {
        return 'Event';
    }

    public function canCreate($Member = null)
    {
        return true;
    }

    public function canEdit($Member = null)
    {
        return true;
    }

    public function canView($Member = null)
    {
        return true;
    }

    public function canDelete($Member = null)
    {
        return true;
    }

    public function getCMSFields()
    {
        $imageField = UploadField::create('Photo')
            ->setDescription('jpg, gif and png filetypes allowed. Max file size of 2MB')
            ->setFolderName('Calendar')
            ->setAllowedExtensions(array (
                'jpg',
                'jpeg',
                'png',
                'gif'
            ));
        $imageField
            ->getValidator()->setAllowedMaxFileSize(2097152);
        $resourceField = UploadField::create('Resource')
            ->setDescription('Flyer/Brochure (PDF or Doc). Max file size of 2MB')
            ->setFolderName('Calendar')
            ->setAllowedExtensions(array (
                'pdf',
                'doc',
                'docx'
            ));
        $resourceField
            ->getValidator()->setAllowedMaxFileSize(2097152);
        return new FieldList(
            TextField::create('Title'),
            DateField::create('StartDate')
                ->setTitle('Start Date')
                ->setConfig('showcalendar', true)
                ->setConfig('dateformat', 'MM/dd/yyyy'),
            DateField::create('EndDate')
                ->setTitle('End Date')
                ->setConfig('showcalendar', true)
                ->setConfig('dateformat', 'MM/dd/yyyy'),
            TimeField::create('StartTime')
                ->setTitle('Start Time'),
            TimeField::create('EndTime')
                ->setTitle('End Time'),
            TextField::create('Location'),
            $imageField,
            $resourceField,
            HTMLEditorField::create('Content')
                ->setTitle('Event Description')
        );
    }

    public function Link()
    {
        return Controller::join_links(
            $this->Calendar()->Link('show'),
            $this->ID
        );
    }

    public function ContentExcerpt($length = 200)
    {
        $text = strip_tags($this->Content);
        $length = abs((int) $length);
        if (strlen($text) > $length) {
            $text = preg_replace("/^(.{1,$length})(\s.*|$)/s", '\\1...', $text);
        }
        return $text;
    }

    public function NiceStartDate()
    {
        return $this->obj('StartDate')
            ->Format('F j, Y');
    }

    public function NiceEndDate()
    {
        return $this->obj('EndDate')
            ->Format('F j, Y');
    }

    public function NiceDates()
    {
        if ($this->StartDate and $this->EndDate) {
            if ($this->StartDate == $this->EndDate) {
                return $this->NiceStartDate();
            } else {
                return $this->NiceStartDate().' – '.$this->NiceEndDate();
            }
        } elseif ($this->StartDate) {
            return $this->NiceStartDate();
        } else {
            return false;
        }
    }

    public function NiceStartTime()
    {
        return $this->obj('StartTime')->Nice();
    }

    public function NiceEndTime()
    {
        return $this->obj('EndTime')->Nice();
    }

    public function NiceTimes()
    {
        if ($this->StartTime and $this->EndTime) {
            return $this->NiceStartTime().' – '.$this->NiceEndTime();
        } elseif ($this->StartTime) {
            return $this->NiceStartTime();
        } else {
            return false;
        }
    }

    public function CalendarLink()
    {
        return $this->getComponent('Calendar')->Link();
    }

    public function PhotoCropped($x = 120, $y = 120)
    {
        $width = $this->Calendar()->PhotoThumbnailWidth;
        $height = $this->Calendar()->PhotoThumbnailHeight;
        if ($width != 0) {
            $x = $width;
        }
        if ($height != 0) {
            $y = $height;
        }
        return $this->Photo()->CroppedImage($x, $y);
    }

    public function PhotoSized($x = 700, $y = 700)
    {
        $width = $this->Calendar()->PhotoFullWidth;
        $height = $this->Calendar()->PhotoFullHeight;
        if ($width != 0) {
            $x = $width;
        }
        if ($height != 0) {
            $y = $height;
        }
        return $this->Photo()->SetRatioSize($x, $y);
    }

    public function Thumbnail()
    {
        $Image = $this->Photo();
        if ($Image) {
            return $Image->CMSThumbnail();
        } else {
            return;
        }
    }

}
