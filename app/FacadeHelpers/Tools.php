<?php

namespace App\FacadeHelpers;

class Tools {


    const INACTIVE = 0;
    const ACTIVE = 1;
    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;
    const GENDER_BOTH = 3;
    const DATE_FORMAT_MONTH_NAME = 'j M Y';
    const PENDING = 0;
    const DELIVERD = 1;
    const REJESTED = 2;
    
   

    public function getActiveStatus() {
        return self::ACTIVE;
    }

    public function getInActiveStatus() {
        return self::INACTIVE;
    }

    public function getStatusesText($key = false) {
        $arr = array(
            $this->getActiveStatus() => 'Enabled',
            $this->getInActiveStatus() => 'Disabled'
        );

        if ($key !== false) {
            if (isset($arr[$key])) {
                return $arr[$key];
            } else {
                return 'Unknown';
            }
        }
        return $arr;
    }

    public function getStatusesYN($key = false) {
        $arr = array(
            $this->getActiveStatus() => 'Yes',
            $this->getInActiveStatus() => 'No'
        );

        if ($key !== false) {
            if (isset($arr[$key])) {
                return $arr[$key];
            } else {
                return 'Unknown';
            }
        }
        return $arr;
    }

    public function isActive($value) {
        if ($value == self::ACTIVE) {
            return true;
        }
        return false;
    }

    public function getMaleGenderId() {
        return self::GENDER_MALE;
    }

    public function getFemaleGenderId() {
        return self::GENDER_FEMALE;
    }

    public function getGenders($key = false) {
        $arr = array(
            $this->getMaleGenderId() => 'Male',
            $this->getFemaleGenderId() => 'Female'
        );

        if ($key !== false) {
            if (isset($arr[$key])) {
                return $arr[$key];
            } else {
                return 'Unknown';
            }
        }
        return $arr;
    }

  
 public function getFormattedDateMonthName($date = '') {
        if (empty($date)) {
            $date = time();
        }
        return date(self::DATE_FORMAT_MONTH_NAME, strtotime($date));
    }

   

    public function createdAdminEndUrl($absolute_url) {
        return url('admin/' . $absolute_url);
    }

    public function getFrontUserUrl($absolute_url) {
        return url('account/' . $absolute_url);
    }

    public function getItemPerPage() {
        return 25;
    }

  


    public function changeStatus($object) {
        if ($object) {
            if ($object->status == $this->getActiveStatus()) {
                $object->update(['status' => $this->getInActiveStatus()]);
                $result = \App\Facades\Tools::getInActiveStatus();
                return response()->json(array('status' => true, 'data' => $result), 200);
            } else if ($object->status == $this->getInActiveStatus()) {
                $object->update(['status' => $this->getActiveStatus()]);
                $result = $this->getActiveStatus();
                return response()->json(array('status' => true, 'data' => $result), 200);
            }
        } else {
            return response()->json(array('status' => false, 'data' => 'This id not product found'), 200);
        }
    }

  
    public function getStorageDirectoryPath($subfolder = '') {
        return public_path('storage/' . $subfolder) . '/';
    }
    
        public function getStorageUrl($subfolder = '') {
        return asset('storage/' . $subfolder) . '/';
    }

       public function getPendingStatus() {
        return self::PENDING;
    }

    public function getDeliverdStatus() {
        return self::DELIVERD;
    }

    public function getRejectedStatus() {
        return self::REJESTED;
    }


 public function getStatusChangeText($key = false) {
        $arr = array(
            $this->getPendingStatus() => 'Pending',
            $this->getDeliverdStatus() => 'Deliverd',
            $this->getRejectedStatus() => 'Rejected',
        );

        if ($key !== false) {
            if (isset($arr[$key])) {
                return $arr[$key];
            } else {
                return 'Unknown';
            }
        }
        return $arr;
    } 
}
