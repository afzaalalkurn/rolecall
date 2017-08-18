<?php

namespace backend\modules\job\models\search;

use backend\modules\job\models\JobFieldOption;
use backend\modules\job\models\JobFieldValue;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\job\models\JobItem as JobItemModel;

/**
 * JobItem represents the model behind the search form about `backend\modules\job\models\JobItem`.
 */
class JobItem extends JobItemModel
{

    public $category_id;
    public $school_name;
    public $zipcode;

    public static function getRolecallPostedCount($user_id)
    {
        $query = JobItemModel::find()
            ->select(['COUNT(*) AS cnt'])
            ->where(['user_id' => $user_id])
            ->count();
        return $query;
    }

    public static function getRolecall($job_id)
    {
        $query = JobItemModel::find()
            ->select(['*'])
            ->where(['job_id' => $job_id])
            ->all();
        return $query;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['job_id', 'user_id', 'status'], 'integer'],
            [['name', 'logo', 'description', 'ref_url', 'expire_date', 'create_dated', 'modified_dated',], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function updateJobData()
    {
        $jobIds = [29, 31, 32, 33, 34, 35, 36];

        $allFldArray = [
            'age' => ['56' => '25', '63' => '35'],
            'bust' => ['32' => '78.74', '33' => '101.6'],
            'chest' => ['19' => '63.5', '20' => '114.3'],
            'height' => ['14' => '152.4', '15' => '210.82'],
            'hips' => ['30' => '83.82', '31' => '110.49'],
            'inseam' => ['28' => '63.5', '29' => '91.44'],
            'neck' => ['17' => '76.2', '18' => '119.38'],
            'shoulders' => ['21' => '60.96', '22' => '105.41'],
            'sleeve' => ['24' => '71.12', '25' => '116.84'],
            'waist' => ['26' => '52.07', '27' => '86.36'],
            'weight' => ['16' => '50', '23' => '60'],
        ];
        $fldIds = [];
        foreach ($allFldArray as $fld => $data) {
            foreach ($data as $field_id => $value) {
                $fldIds[$field_id] = $field_id;
            }

        }
        pr(implode(",", $fldIds));

        foreach ($jobIds as $job_id) {

            foreach ($allFldArray as $field => $data) {

                foreach ($data as $field_id => $value) {

                    $jobFieldValue = new JobFieldValue();
                    $jobFieldValue->job_id = $job_id;
                    $jobFieldValue->field_id = $field_id;
                    $jobFieldValue->value = $value;

                    /*
                    if (!$jobFieldValue->save(false)) {
                        pr($jobFieldValue->getErrors());
                    }
                    */
                }
            }

        }
    }

    public function importData()
    {
        $ageArray = [];
        foreach (range(0, 100) as $e) {
            $ageArray[$e . ' year'] = $e;
        }

        $heightArray = [
            '0 ft.' => 0,
            '1 ft. 0 in.' => 30.5,
            '1 ft. 1 in.' => 33,
            '1 ft. 2 in.' => 35.6,
            '1 ft. 3 in.' => 38.1,
            '1 ft. 4 in.' => 40.6,
            '1 ft. 5 in.' => 43.2,
            '1 ft. 6 in.' => 45.7,
            '1 ft. 7 in.' => 48.3,
            '1 ft. 8 in.' => 50.8,
            '1 ft. 9 in.' => 53.3,
            '1 ft. 10 in.' => 55.9,
            '1 ft. 11 in.' => 58.4,
            '2 ft. 0 in.' => 61,
            '2 ft. 1 in.' => 63.5,
            '2 ft. 2 in.' => 66,
            '2 ft. 3 in.' => 68.6,
            '2 ft. 4 in.' => 71.1,
            '2 ft. 5 in.' => 73.7,
            '2 ft. 6 in.' => 76.2,
            '2 ft. 7 in.' => 78.7,
            '2 ft. 8 in.' => 81.3,
            '2 ft. 9 in.' => 83.8,
            '2 ft. 10 in.' => 86.4,
            '2 ft. 11 in.' => 88.9,
            '3 ft. 0 in.' => 91.44,
            '3 ft. 1 in.' => 93.98,
            '3 ft. 2 in.' => 96.52,
            '3 ft. 3 in.' => 99.06,
            '3 ft. 4 in.' => 101.6,
            '3 ft. 5 in.' => 104.14,
            '3 ft. 6 in.' => 106.68,
            '3 ft. 7 in.' => 109.22,
            '3 ft. 8 in.' => 111.76,
            '3 ft. 9 in.' => 114.3,
            '3 ft. 10 in.' => 116.84,
            '3 ft. 11 in.' => 119.38,
            '4 ft. 0 in.' => 121.92,
            '4 ft. 1 in.' => 124.46,
            '4 ft. 2 in.' => 127.0,
            '4 ft. 3 in.' => 129.54,
            '4 ft. 4 in.' => 132.08,
            '4 ft. 5 in.' => 134.62,
            '4 ft. 6 in.' => 137.16,
            '4 ft. 7 in.' => 139.7,
            '4 ft. 8 in.' => 142.24,
            '4 ft. 9 in.' => 144.78,
            '4 ft. 10 in.' => 147.32,
            '4 ft. 11 in.' => 149.86,
            '5 ft. 0 in.' => 152.4,
            '5 ft. 1 in.' => 154.94,
            '5 ft. 2 in.' => 157.48,
            '5 ft. 3 in.' => 160.02,
            '5 ft. 4 in.' => 162.56,
            '5 ft. 5 in.' => 165.1,
            '5 ft. 6 in.' => 167.64,
            '5 ft. 7 in.' => 170.18,
            '5 ft. 8 in.' => 172.72,
            '5 ft. 9 in.' => 175.26,
            '5 ft. 10 in.' => 177.8,
            '5 ft. 11 in.' => 180.34,
            '6 ft. 0 in.' => 182.88,
            '6 ft. 1 in.' => 185.42,
            '6 ft. 2 in.' => 187.96,
            '6 ft. 3 in.' => 190.5,
            '6 ft. 4 in.' => 193.04,
            '6 ft. 5 in.' => 195.58,
            '6 ft. 6 in.' => 198.12,
            '6 ft. 7 in.' => 200.66,
            '6 ft. 8 in.' => 203.2,
            '6 ft. 9 in.' => 205.74,
            '6 ft. 10 in.' => 208.28,
            '6 ft. 11 in.' => 210.82,
            '7 ft. 0 in.' => 213.36,
            '7 ft. 1 in.' => 215.99,
            '7 ft. 2 in.' => 218.44,
            '7 ft. 3 in.' => 220.98,
            '7 ft. 4 in.' => 223.52,
            '7 ft. 5 in.' => 226.06,
            '7 ft. 6 in.' => 228.6,
            '7 ft. 7 in.' => 231.14,
            '7 ft. 8 in.' => 233.68,
            '7 ft. 9 in.' => 236.22,
            '7 ft. 10 in.' => 238.76,
            '7 ft. 11 in.' => 241.3,
        ];

        $inchesArray = [
            '0 in.' => 0,
            '½ in.' => 1.27,
            '1 in.' => 2.54,
            '1½ in.' => 3.81,
            '2 in.' => 5.08,
            '2½ in.' => 6.35,
            '3 in.' => 7.62,
            '3½ in.' => 8.89,
            '4 in.' => 10.16,
            '4½ in.' => 11.43,
            '5 in.' => 12.7,
            '5½ in.' => 13.97,
            '6 in.' => 15.24,
            '6½ in.' => 16.51,
            '7 in.' => 17.78,
            '7½ in.' => 19.05,
            '8 in.' => 20.32,
            '8½ in.' => 21.59,
            '9 in.' => 22.86,
            '9½ in.' => 24.13,
            '10 in.' => 25.4,
            '10½ in.' => 26.67,
            '11 in.' => 27.94,
            '11½ in.' => 29.21,
            '12 in.' => 30.48,
            '12½ in.' => 31.75,
            '13 in.' => 33.02,
            '13½ in.' => 34.29,
            '14 in.' => 35.56,
            '14½ in.' => 36.83,
            '15 in.' => 38.1,
            '15½ in.' => 39.37,
            '16 in.' => 40.64,
            '16½ in.' => 41.91,
            '17 in.' => 43.18,
            '17½ in.' => 44.45,
            '18 in.' => 45.72,
            '18½ in.' => 46.99,
            '19 in.' => 48.26,
            '19½ in.' => 49.53,
            '20 in.' => 50.8,
            '20½ in.' => 52.07,
            '21 in.' => 53.34,
            '21½ in.' => 54.61,
            '22 in.' => 55.88,
            '22½ in.' => 57.15,
            '23 in.' => 58.42,
            '23½ in.' => 59.69,
            '24 in.' => 60.96,
            '24½ in.' => 62.23,
            '25 in.' => 63.5,
            '25½ in.' => 64.77,
            '26 in.' => 66.04,
            '26½ in.' => 67.31,
            '27 in.' => 68.58,
            '27½ in.' => 69.85,
            '28 in.' => 71.12,
            '28½ in.' => 72.39,
            '29 in.' => 73.66,
            '29½ in.' => 74.93,
            '30 in.' => 76.2,
            '30½ in.' => 77.47,
            '31 in.' => 78.74,
            '31½ in.' => 80.01,
            '32 in. ' => 81.28,
            '32½ in.' => 82.55,
            '33 in. ' => 83.82,
            '33½ in.' => 85.09,
            '34 in. ' => 86.36,
            '34½ in.' => 87.63,
            '35 in. ' => 88.9,
            '35½ in.' => 90.17,
            '36 in. ' => 91.44,
            '36½ in.' => 92.71,
            '37 in. ' => 93.98,
            '37½ in.' => 95.25,
            '38 in. ' => 96.52,
            '38½ in.' => 97.79,
            '39 in. ' => 99.06,
            '39½ in.' => 100.33,
            '40 in. ' => 101.6,
            '40½ in.' => 102.87,
            '41 in. ' => 104.14,
            '41½ in.' => 105.41,
            '42 in. ' => 106.68,
            '42½ in.' => 107.95,
            '43 in. ' => 109.22,
            '43½ in.' => 110.49,
            '44 in. ' => 111.76,
            '44½ in.' => 113.03,
            '45 in. ' => 114.3,
            '45½ in.' => 115.57,
            '46 in. ' => 116.84,
            '46½ in.' => 118.11,
            '47 in. ' => 119.38,
            '47½ in.' => 120.65,
            '48 in. ' => 121.92,
            '48½ in.' => 123.19,
            '49 in.' => 124.46,
            '49½ in.' => 125.73,
            '50 in.' => 127];

        $weightArray = [];
        foreach (range(0, 250) as $e) {
            $weightArray[$e . ' lbs.'] = $e;
        }

        $uSShoeSizeArray = [
            '0' => '0',
            '1' => '1',
            '2' => '2',
            '2.5' => '2.5',
            '3' => '3',
            '3.5' => '3.5',
            '4' => '4',
            '4.5' => '4.5',
            '5' => '5',
            '5.5' => '5.5',
            '6' => '6',
            '6.5' => '6.5',
            '7' => '7',
            '7.5' => '7.5',
            '8' => '8',
            '8.5' => '8.5',
            '9' => '9',
            '9.5' => '9.5',
            '10' => '10',
            '10.5' => '10.5',
            '11' => '11',
            '11.5' => '11.5',
            '12' => '12',
            '12.5' => '12.5',
            '13' => '13',
            '13.5' => '13.5',
            '14' => '14',
            '14.5' => '14.5',
            '15' => '15',
            '15.5' => '15.5',
            '16' => '16',
            '16.5' => '16.5',
            '17' => '17',
            '17.5' => '17.5',
            '18' => '18',
            '18.5' => '18.5',
            '19' => '19',
            '19.5' => '19.5',
            '20' => '20'
        ];
        $cupSizeArray = ['A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'DD' => 'DD', 'E' => 'E', 'Above E' => 'Above E'];
        $roleTypeArray = [
            'On Camera/Stage – Speaking' => 'On Camera/Stage – Speaking',
            'On Camera/Stage - Non-Speaking' => 'On Camera/Stage - Non-Speaking',
            'Stunts' => 'Stunts',
            'Voice Over' => 'Voice Over',
            'Stand-In' => 'Stand-In',
        ];
        $experienceArray = ['None' => 'None', '1-3 Days' => '1-3 Days', '4-9 Days' => '4-9 Days', '10 Days or More' => '10 Days or More'];
        $realWorldExperienceArray = ['Police' => 'Police', 'Firefighter' => 'Firefighter', 'Doctor' => 'Doctor', 'Lawyer' => 'Lawyer', 'Military' => 'Military', 'Bartender' => 'Bartender', 'Nurse' => 'Nurse', 'Other' => 'Other',];

        $spokenLanguagesArray = ['English' => 'English', 'Spanish' => 'Spanish', 'French' => 'French', 'German' => 'German', 'Italian' => 'Italian', 'Russian' => 'Russian', 'Mandarin' => 'Mandarin', 'Arabic' => 'Arabic', 'Other' => 'Other'];

        $specialSkillsArray = ['Ballet' => 'Ballet', 'Guitar' => 'Guitar', 'Singing' => 'Singing', 'Horseback Riding' => 'Horseback Riding', 'Other' => 'Other'];

        $unionStatusArray = ['SAG/AFTRA' => 'SAG/AFTRA', 'Non-Union' => 'Non-Union'];

        $ethnicityArray = ['Caucasian' => 'Caucasian', 'Black' => 'Black', 'Hispanic' => 'Hispanic', 'Asian' => 'Asian', 'South Asian' => 'South Asian', 'Native' => 'Native', 'American' => 'American', 'Middle Easter' => 'Middle Easter', 'Pacific Islander' => 'Pacific Islander'];

        $hairColorArray = ['Light Blonde' => 'Light Blonde', 'Medium Blonde' => 'Medium Blonde', 'Dark Blonde' => 'Dark Blonde', 'Light Brown' => 'Light Brown', 'Dark Brown' => 'Dark Brown', 'Red' => 'Red', 'Black' => 'Black', 'Gray' => 'Gray', 'White' => 'White', 'Salt and Pepper' => 'Salt and Pepper', 'Unique Color' => 'Unique Color'];

        $hairLengthArray = ['Short' => 'Short', 'Medium' => 'Medium', 'Long' => 'Long', 'Military Cut' => 'Military Cut', 'Shaved/Bald' => 'Shaved/Bald'];

        $needPictureCarArray = ['Yes' => 'Yes', 'No' => 'No'];

        $projectTypeArray = ['Feature Film' => 'Feature Film', 'Television' => 'Television', 'Modeling' => 'Modeling', 'Theater' => 'Theater', 'Short Film' => 'Short Film', 'Commercial' => 'Commercial', 'Online' => 'Online', 'Reality TV' => 'Reality TV', 'Game Show' => 'Game Show', 'Brand Ambassador' => 'Brand Ambassador'];

        $compensationType = ['Paid' => 'Paid', 'Unpaid' => 'Unpaid'];

        $genderArray = ['Male' => 'Male', 'Female' => 'Female'];

        $yearArray = [
            '1920' => '1920s',
            '1930' => '1930s',
            '1940' => '1940s',
            '1950' => '1950s',
            '1960' => '1960s',
            '1970' => '1970s',
            '1980' => '1980s',
            '1990' => '1990s',
            '2000' => '2000s',
            '2010' => '2010',
            '2011' => '2011',
            '2012' => '2012',
            '2013' => '2013',
            '2014' => '2014',
            '2015' => '2015',
            '2016' => '2016',
            '2017' => '2017',
        ];


        $makeArray = [
            'Acura' => 'Acura',
            'Alfa Romeo' => 'Alfa Romeo',
            'AMC' => 'AMC',
            'Aston Martin' => 'Aston Martin',
            'Audi' => 'Audi',
            'Bentley' => 'Bentley',
            'BMW' => 'BMW',
            'Bugatti' => 'Bugatti',
            'Buick' => 'Buick',
            'Cadillac' => 'Cadillac',
            'Chevrolet' => 'Chevrolet',
            'Chrysler' => 'Chrysler',
            'Daewoo' => 'Daewoo',
            'Datsun' => 'Datsun',
            'DeLorean' => 'DeLorean',
            'Dodge' => 'Dodge',
            'Eagle' => 'Eagle',
            'Ferrari' => 'Ferrari',
            'FIAT' => 'FIAT',
            'Fisker' => 'Fisker',
            'Ford' => 'Ford',
            'Freightliner' => 'Freightliner',
            'Genesis' => 'Genesis',
            'Geo' => 'Geo',
            'GMC' => 'GMC',
            'Honda' => 'Honda',
            'HUMMER' => 'HUMMER',
            'Hyundai' => 'Hyundai',
            'INFINITI' => 'INFINITI',
            'Isuzu' => 'Isuzu',
            'Jaguar' => 'Jaguar',
            'Jeep' => 'Jeep',
            'Kia' => 'Kia',
            'Lamborghini' => 'Lamborghini',
            'Land Rover' => 'Land Rover',
            'Lexus' => 'Lexus',
            'Lincoln' => 'Lincoln',
            'Lotus' => 'Lotus',
            'Maserati' => 'Maserati',
            'Maybach' => 'Maybach',
            'Mazda' => 'Mazda',
            'McLaren' => 'McLaren',
            'Mercedes-Benz' => 'Mercedes-Benz',
            'Mercury' => 'Mercury',
            'MINI' => 'MINI',
            'Mitsubishi' => 'Mitsubishi',
            'Nissan' => 'Nissan',
            'Oldsmobile' => 'Oldsmobile',
            'Plymouth' => 'Plymouth',
            'Pontiac' => 'Pontiac',
            'Porsche' => 'Porsche',
            'RAM' => 'RAM',
            'Rolls-Royce' => 'Rolls-Royce',
            'Saab' => 'Saab',
            'Saturn' => 'Saturn',
            'Scion' => 'Scion',
            'smart' => 'smart',
            'SRT' => 'SRT',
            'Subaru' => 'Subaru',
            'Suzuki' => 'Suzuki',
            'Tesla' => 'Tesla',
            'Toyota' => 'Toyota',
            'Volkswagen' => 'Volkswagen',
            'Volvo' => 'Volvo',
            'Yugo' => 'Yugo',
        ];


        /*$modelArray = [
            'Acura' => ['CL', 'ILX', 'Integra', 'Legend', 'MDX', 'NSX', 'RDX', 'RL', 'RLX', 'RSX', 'SLX', 'TL', 'TLX', 'TSX', 'Vigor', 'ZDX'],
            'Alfa Romeo' => ["164", "4C", "8C Competizione", "Giulia", "GTV-6", "Milano", "Spider", "Stelvio", "Other Alfa Romeo Models",],
            "AMC" => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'Aston Martin' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'Audi' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'Bentley' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'BMW' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'Bugatti' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'Buick' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'Cadillac' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'Chevrolet' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'Chrysler' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'Daewoo' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'Datsun' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'DeLorean' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'Dodge' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'Eagle' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'Ferrari' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'FIAT' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'Fisker' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'Ford' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'Freightliner' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'Genesis' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'Geo' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'GMC' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'Honda' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'HUMMER' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'Hyundai' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'INFINITI' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'Isuzu' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'Jaguar' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'Jeep' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'Kia' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'Lamborghini' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'Land Rover' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'Lexus' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'Lincoln' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'Lotus' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'Maserati' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'Maybach' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'Mazda' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'McLaren' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'Mercedes-Benz' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'Mercury' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'MINI' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'Mitsubishi' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'Nissan' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'Oldsmobile' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'Plymouth' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'Pontiac' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'Porsche' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'RAM' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'Rolls-Royce' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'Saab' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'Saturn' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'Scion' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'smart' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'SRT' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'Subaru' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'Suzuki' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'Tesla' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'Toyota' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'Volkswagen' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'Volvo' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
            'Yugo' => ["Alliance", "Concord", "Eagle", "Encore", "Spirit",],
        ];*/

        $modelTypeArray = [
            'Car-compact' => 'Car-compact',
            'Car-midsize/sedam' => 'Car-midsize/sedam',
            'Car-full-size' => 'Car-full-size',
            'Minivan' => 'Minivan',
            'Van' => 'Van',
            'SUV' => 'SUV',
            'SUV-smailler' => 'SUV-smailler',
            'Motorcycle' => 'Motorcycle',
            'Pick-up Truck' => 'Pick-up Truck',
            'Motorhome' => 'Motorhome',
            'Other' => 'Other',
        ];

        $colorArray = [
            'Gray' => 'Gray',
            'Silver' => 'Silver',
            'Gold' => 'Gold',
            'Beige' => 'Beige',
            'Champagne' => 'Champagne',
            'Tan' => 'Tan',
            'Blue' => 'Blue',
            'Green' => 'Green',
            'Brown' => 'Brown',
            'Marppm' => 'Marppm',
            'Burgundy' => 'Burgundy',
            'Red' => 'Red',
            'Black' => 'Black',
            'White' => 'White',
            'Yellow' => 'Yellow',
            'Orange' => 'Orange',
            'Purple' => 'Purple',
            'Other' => 'Other',
            ];


        $attributes = [

            '14' => ['title' => 'height-from', 'data' => $heightArray],
            '15' => ['title' => 'height-to', 'data' => $heightArray],
            '16' => ['title' => 'weight-from', 'data' => $weightArray],
            '17' => ['title' => 'neck-from', 'data' => $inchesArray],
            '18' => ['title' => 'neck-to', 'data' => $inchesArray],
            '19' => ['title' => 'chest-from', 'data' => $inchesArray],
            '20' => ['title' => 'chest-to', 'data' => $inchesArray],
            '21' => ['title' => 'shoulders-from', 'data' => $inchesArray],
            '22' => ['title' => 'shoulders-to', 'data' => $inchesArray],
            '23' => ['title' => 'weight-to', 'data' => $weightArray],
            '24' => ['title' => 'sleeve-from', 'data' => $inchesArray],
            '25' => ['title' => 'sleeve-to', 'data' => $inchesArray],
            '26' => ['title' => 'waist-from', 'data' => $inchesArray],
            '27' => ['title' => 'waist-to', 'data' => $inchesArray],
            '28' => ['title' => 'inseam-from', 'data' => $inchesArray],
            '29' => ['title' => 'inseam-to', 'data' => $inchesArray],
            '30' => ['title' => 'hips-from', 'data' => $inchesArray],
            '31' => ['title' => 'hips-to', 'data' => $inchesArray],
            '32' => ['title' => 'bust-from', 'data' => $inchesArray],
            '33' => ['title' => 'bust-to', 'data' => $inchesArray],

            /* Cup Size */
            '34' => ['title' => 'Cup Size', 'data' => $cupSizeArray],
            /* US shoe size */
            '35' => ['title' => 'US shoe size', 'data' => $uSShoeSizeArray],

            /* Ethnicity */
            '36' => ['title' => 'Ethnicity', 'data' => $ethnicityArray],
            /* Project Type */
            '37' => ['title' => 'Project Type', 'data' => $projectTypeArray],


            /* Role Type */
            '38' => ['title' => 'Role Type', 'data' => $roleTypeArray],
            /* Compensation Type*/
            '39' => ['title' => 'Compensation Type', 'data' => $compensationType],
            /* Union Status */
            '40' => ['title' => 'Union Status', 'data' => $unionStatusArray],

            /* Set Experience */
            '41' => ['title' => 'Set Experience', 'data' => $experienceArray],

            /* Real World Experience */
            '42' => ['title' => 'Real World Experience', 'data' => $realWorldExperienceArray],
            /*  Spoken Languages*/
            '43' => ['title' => 'Real World Experience', 'data' => $spokenLanguagesArray],
            /* Special Skills */
            '44' => ['title' => 'Special Skills', 'data' => $specialSkillsArray],


            /* Hair Color */
            '45' => ['title' => 'Hair Color', 'data' => $hairColorArray],

            /* Hair Length */
            '46' => ['title' => ' Hair Length ', 'data' => $hairLengthArray],

            /* Gender */
            '51' => ['title' => 'Gender', 'data' => $genderArray],

            '56' => ['title' => 'age-from', 'data' => $ageArray],

            /* Does Talent Need a Picture Car? */
            '58' => ['title' => 'Does Talent Need a Picture Car?', 'data' => $needPictureCarArray],

            /* Car Year */
            '59' => ['title' => 'Year', 'data' => $yearArray],

            /* Car Make */
            '60' => ['title' => 'Make', 'data' => $makeArray],

            /* Car Model Type */
            '61' => ['title' => 'Model Type', 'data' => $modelTypeArray],

            /* Car Color */
            '62' => ['title' => 'Color ', 'data' => $colorArray],

            /* Age */
            '63' => ['title' => 'age-to', 'data' => $ageArray],
        ];

        foreach ($attributes as $field_id => $info) {
            $data = $info['data'];

            JobFieldOption::deleteAll(['field_id' => $field_id]);

            if (isset($info['is_parent']) && $info['is_parent'] == 1) {

                foreach ($data as $parentName => $items) {

                    $parent = JobFieldOption::findOne(['value' => $parentName]);
                    if ($parent) {
                        $parent_id = $parent->option_id;
                        $this->importDb($items, $field_id, $parent_id);
                    }
                }
            } else {
                $this->importDb($data, $field_id);
            }
        }
    }

    function importDb($data, $field_id, $parent_id = null)
    {

        foreach ($data as $name => $value) {

            $fieldOption = new JobFieldOption();
            if (isset($parent_id) && !is_null($parent_id)) {
                $fieldOption->parent_id = $parent_id;
            }

            $fieldOption->field_id = $field_id;
            $fieldOption->name = (isset($parent_id) && !is_null($parent_id)) ? $value : $name;
            $fieldOption->value = $value;

            if (!$fieldOption->save(false)) {
                pr($fieldOption->getErrors());
            }
        }
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = JobItemModel::find();

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (isset($params['JobFieldValue'])) {

            foreach ($params['JobFieldValue'] as $fieldIdx => $data) {

                if ($fieldIdx > 0 && !empty($data['value'])) {

                    $query->join('INNER JOIN', 'job_field_value as a' . $fieldIdx, 'a' . $fieldIdx . '.job_id = job_item.job_id');
                    $query->andFilterWhere(['a' . $fieldIdx . '.`field_id`' => $fieldIdx]);
                    if (is_array($data['value'])) {
                        foreach ($data['value'] as $eachValue) {
                            $query->andFilterWhere(['like', 'a' . $fieldIdx . '.`value`', $eachValue]);
                        }
                    } else {
                        $query->andFilterWhere(['a' . $fieldIdx . '.`value`' => $data['value']]);
                    }
                }
            }
        }

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'job_item.job_id' => $this->job_id,
            'job_item.user_id' => $this->user_id,
            'job_item.status' => $this->status,
            'expire_date' => $this->expire_date,
            'create_dated' => $this->create_dated,
            'modified_dated' => $this->modified_dated,
        ]);


        $query->andFilterWhere(['like', 'ref_url', $this->ref_url])
            ->andFilterWhere(['like', 'logo', $this->logo]);

        $query->andFilterWhere(['like', 'job_item.name', $this->name])
            ->andFilterWhere(['like', 'job_item.description', $this->description]);

        return $dataProvider;
    }
}
