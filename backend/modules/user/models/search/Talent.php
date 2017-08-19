<?php

namespace backend\modules\user\models\search;

use backend\modules\job\models\search\JobUserMapper;
use backend\modules\user\models\UserFieldOption;
use backend\modules\user\models\UserFieldValue;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * School represents the model behind the search form about `backend\modules\user\models\User`.
 */
class Talent extends User
{

    public $mapper_status;
    public $job_id;
    public $latitude;
    public $longitude;
    public $radius;
    public $is_deleted;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'auth_key', 'password_hash', 'password_reset_token', 'email', 'is_deleted'], 'safe'],
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


    public function importData()
    {

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

        $modelArray = [

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
        ];

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
            'Other' => 'Other',];


        $attributes = [

            /* Car Make */
            '50' => ['title' => 'Make', 'data' => $makeArray],

            /* Car Year */
            '20' => ['title' => 'Year', 'data' => $yearArray],

            //'21' => ['title' => 'Model', 'is_parent' => 1, 'data' => $modelArray],

            /* Car Model Type */
            '21' => ['title' => 'Model Type', 'data' => $modelTypeArray],

            /* Car Color */
            '22' => ['title' => 'Color ', 'data' => $colorArray],

            '13' => ['title' => 'height', 'data' => $heightArray],
            '27' => ['title' => 'weight', 'data' => $weightArray],
            '32' => ['title' => 'bust', 'data' => $inchesArray],
            '34' => ['title' => 'chest', 'data' => $inchesArray],
            '29' => ['title' => 'hips', 'data' => $inchesArray],
            '31' => ['title' => 'inseam', 'data' => $inchesArray],
            '33' => ['title' => 'neck', 'data' => $inchesArray],
            '35' => ['title' => 'shoulders', 'data' => $inchesArray],
            '30' => ['title' => 'sleeve', 'data' => $inchesArray],
            '28' => ['title' => 'waist', 'data' => $inchesArray],

            /* US shoe size */
            '14' => ['title' => 'US shoe size', 'data' => $uSShoeSizeArray],

            /* Cup Size */
            '16' => ['title' => 'Cup Size', 'data' => $cupSizeArray],

            /* Role Type */
            '6' => ['title' => 'Role Type', 'data' => $roleTypeArray],

            /* Set Experience */
            '9' => ['title' => 'Set Experience', 'data' => $experienceArray],

            /* Real World Experience */
            '10' => ['title' => 'Real World Experience', 'data' => $realWorldExperienceArray],

            /*  Spoken Languages*/
            '11' => ['title' => 'Real World Experience', 'data' => $spokenLanguagesArray],

            /* Special Skills */
            '12' => ['title' => 'Special Skills', 'data' => $specialSkillsArray],

            /* Union Status */
            '8' => ['title' => 'Union Status', 'data' => $unionStatusArray],

            /* Ethnicity */
            '1' => ['title' => 'Ethnicity', 'data' => $ethnicityArray],

            /* Hair Color */
            '17' => ['title' => 'Hair Color', 'data' => $hairColorArray],

            /* Hair Length */
            '18' => ['title' => ' Hair Length ', 'data' => $hairLengthArray],

            /* Does Talent Need a Picture Car? */
            '19' => ['title' => 'Does Talent Need a Picture Car?', 'data' => $needPictureCarArray],

            /* Project Type */
            '5' => ['title' => 'Project Type', 'data' => $projectTypeArray],

            /* Compensation Type*/
            '7' => ['title' => 'Project Type', 'data' => $compensationType],
        ];

        foreach ($attributes as $field_id => $info) {
            $data = $info['data'];

            UserFieldOption::deleteAll(['field_id' => $field_id]);

            if (isset($info['is_parent']) && $info['is_parent'] == 1) {

                foreach ($data as $parentName => $items) {

                    $parent = UserFieldOption::findOne(['value' => $parentName]);
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

            $fieldOption = new UserFieldOption();
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

    public function updateUserData()
    {
        $userIds = [288, 289, 290, 291, 292, 293, 294];

        $allFldArray = [
            'us-shoe-size' => ['14' => '6.5'],
            'role-type' => ['6' => 'On Camera/Stage – Speaking'],
            'set-experience' => ['9' => $this->arrayRand(['1-3 Days', '4-9 Days'])],
            'real-world-experience' => ['10' => $this->arrayRand(['Lawyer', 'Other'])],
            'spoken-languages' => ['11' => $this->arrayRand(['English', 'German', 'Italian', 'Other'])],
            'special-skills' => ['12' => $this->arrayRand(['Singing', 'Horseback Riding', 'Other'])],
            'union-status' => ['8' => $this->arrayRand(['SAG/AFTRA', 'Non-Union'])],
            'ethnicity' => ['1' => $this->arrayRand(['Caucasian', 'Hispanic'])],
            'hair-color' => ['17' => $this->arrayRand(['Medium Blonde', 'Dark Blonde'])],
            'hair-length' => ['18' => 'Medium'],
            'bust' => ['32' => '78.74'],
            'chest' => ['34' => '63.5'],
            'height' => ['13' => '152.4'],
            'hips' => ['29' => '83.82'],
            'inseam' => ['31' => '63.5'],
            'neck' => ['33' => '76.2'],
            'shoulders' => ['35' => '60.96'],
            'sleeve' => ['30' => '71.12'],
            'waist' => ['28' => '52.07'],
            'weight' => ['27' => '50'],
        ];

        $fldIds = [];
        foreach ($allFldArray as $fld => $data) {

            foreach ($data as $field_id => $value) {
                $fldIds[$field_id] = $field_id;
            }
        }

        foreach ($userIds as $user_id) {

            $userFields = UserProfile::findOne($user_id);

            if ($userFields->gender == 'Female') {
                unset($allFldArray['chest']);
            }

            if ($userFields->gender == 'Male') {
                unset($allFldArray['bust']);
            }

            foreach ($allFldArray as $field => $data) {

                foreach ($data as $field_id => $value) {

                    $userFieldValue = new UserFieldValue();
                    $userFieldValue->user_id = $user_id;
                    $userFieldValue->field_id = $field_id;
                    $userFieldValue->value = $value;

                    if (!$userFieldValue->save(false)) {
                        pr($userFieldValue->getErrors());
                    }
                }
            }
        }
    }

    public function arrayRand($dArr)
    {
        $a = array_rand($dArr);
        return $dArr[$a];
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
        $query = User::find()->join('inner join', '`auth_assignment`', '`auth_assignment`.`user_id` = `id`')
            ->where(['`auth_assignment`.`item_name`' => self::ROLE_USER,
                '`user`.`status`' => '10']);
        $query->join('INNER JOIN', '`user_profile`', '`user_profile`.`user_id` = `user`.`id`');
        $sql = "SELECT uf.field_id,  uf.`field`, uf.`name`  FROM `user_field` as `uf`";
        $userFields = Yii::$app->db->createCommand($sql)->queryAll();

        if (!empty($this->job_id)) {
            $sql = "SELECT jfv .job_id,  jf.`field`, jfv.`value`  FROM `job_field`  jf INNER JOIN `job_field_value`  jfv ON  `jf`.`field_id` = jfv .`field_id` WHERE jfv.`job_id` = " . $this->job_id;
            $jobFields = Yii::$app->db->createCommand($sql)->queryAll();

            $jobFieldArray = [];
            foreach ($jobFields as $item) {
                $jobFieldArray[$item['field']] = $item['value'];
            }
        }

        if (!empty($this->job_id) && count($jobFieldArray) > 0) {

            $matchArray = [
                'height' => ['height-from', 'height-to'],
                'weight' => ['weight-from', 'weight-to'],
                'waist' => ['waist-from', 'waist-to'],

                'sleeve' => ['sleeve-from', 'sleeve-to'],
                'inseam' => ['inseam-from', 'inseam-to'],
                'birthday' => ['age-from', 'age-to'],

                'us-shoe-size' => 'us-shoe-size',
                'role-type' => 'role-type',
                'set-experience' => 'set-experience',

                'real-world-experience' => 'real-world-experience',
                'spoken-languages' => 'spoken-languages',
                'special-skills' => 'special-skills',

                'union-status' => 'union-status',
                'ethnicity' => 'ethnicity',
                'hair-color' => 'hair-color',
                'hair-length' => 'hair-length',
            ];

            if ($jobFieldArray['gender'] == 'Female') {
                $matchArray['bust'] = ['bust-from', 'bust-to'];
                $matchArray['hips'] = ['hips-from', 'hips-to'];
                $matchArray['cup-size'] = 'cup-size';
            }

            if ($jobFieldArray['gender'] == 'Male') {
                $matchArray['chest'] = ['chest-from', 'chest-to'];
                $matchArray['shoulders'] = ['shoulders-from', 'shoulders-to'];
                $matchArray['neck'] = ['neck-from', 'neck-to'];
            }

            if (!empty($jobFieldArray['gender'])) {
                $query->andFilterWhere(['`user_profile`.`gender`' => $jobFieldArray['gender']]);
            }

            $fldArray = [];

            foreach ($userFields as $fld) {
                if (in_array($fld['field'], array_keys($matchArray))) {
                    $fldArray[$fld['field']] = $fld['field_id'];
                }
            }

            $ids = $this->getUserIds($query);

            foreach ($matchArray as $fieldIdx => $data) {

                if (is_array($ids) && count($ids) > 0) {

                    $query = User::find();
                    $query->addSelect(['`user`.*']);

                    if (is_array($data) && count($data) == 2) {

                        list($from, $to) = $data;

                        $from = $jobFieldArray[$from] ?? null;
                        $to = $jobFieldArray[$to] ?? null;

                        if (!empty($from) && !empty($to)) {

                            $query->join('LEFT JOIN', '`user_field_value` as `a' . $fieldIdx . '`', '`a' . $fieldIdx . '`.`user_id` = `user`.`id`');
                            $query->andFilterWhere([' `a' . $fieldIdx . '`.`field_id` ' => $fldArray[$fieldIdx]]);
                            if ($fieldIdx == 'birthday') {
                                $query->andFilterWhere(['between', 'SELECT TIMESTAMPDIFF( YEAR, STR_TO_DATE(REPLACE(`a' . $fieldIdx . '`.`value`,","," "), "%M %d %Y %h:%i%p") , CURDATE())', (int)$from, (int)$to]);
                            } else {
                                $query->andFilterWhere(['between', '`a' . $fieldIdx . '`.`value`', (int)$from, (int)$to]);
                            }
                        }

                    } elseif (!empty($jobFieldArray[$data])) {

                        $query->join('LEFT JOIN', '`user_field_value` as `a' . $fieldIdx . '`', '`a' . $fieldIdx . '`.`user_id` = `user`.`id`');
                        $query->andFilterWhere([' `a' . $fieldIdx . '`.`field_id` ' => $fldArray[$fieldIdx]]);

                        $jobFieldValue = $jobFieldArray[$data];
                        ($jobFieldValue = @unserialize($jobFieldValue)) ? $jobFieldValue : $jobFieldValue;

                        if (is_array($jobFieldValue) && count($jobFieldValue) > 0) {

                            $elements = [];

                            if (count($jobFieldValue)) {

                                foreach ($jobFieldValue as $jv) {
                                    $elements[] = $jv;
                                }

                                if ( count($elements) > 1 ) {

                                    $is_multiple = ['real-world-experience', 'spoken-languages', 'special-skills',];
                                    if(in_array($fieldIdx, $is_multiple)){
                                        foreach($elements as $element){
                                            $query->orFilterWhere(['LIKE', '`a' . $fieldIdx . '`.`value`', $element]);
                                        }
                                    }else{
                                        $query->andFilterWhere(['IN', '`a' . $fieldIdx . '`.`value`', $elements]);
                                    }

                                } else {
                                    $query->andFilterWhere(['LIKE', '`a' . $fieldIdx . '`.`value`', current($elements)]);
                                }
                            }

                        } else {
                            $query->andFilterWhere(['like', '`a' . $fieldIdx . '`.`value`', $jobFieldArray[$data]]);
                        }
                    }

                    $query->andFilterWhere(['IN', '`user`.`id`', $ids]);
                    $ids = $this->getUserIds($query);
                }
            }
        }

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider(['query' => $query,]);
        $this->load($params);

        if (!empty($this->latitude) && !empty($this->longitude)) {

            $query->join('INNER JOIN', '`user_address`', '`user_address`.`user_id` = `user`.`id`');
            $query->addSelect(['(
              3959 * ACOS(
                  COS( RADIANS(' . $this->latitude . ')) * COS(RADIANS(latitude)) * COS(
                      RADIANS(longitude) - RADIANS(' . $this->longitude . ')
                  ) + SIN(RADIANS(' . $this->latitude . ')) * SIN(RADIANS(latitude))
              )
            ) AS distance ']);

            //for miles - 3959
            //for km - 6371
        }



        //pr($this->radius);
        if (!empty($this->radius)) {
            $query->having(['<', 'distance', $this->radius]);
            $query->orderBy('distance');
        }

        /*
        echo $query->createCommand()->rawSql;
        exit;
        */

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $subQuery = JobUserMapper::find()->select('user_id')
            ->where(['`job_id`' => $this->job_id])
            ->andWhere(['NOT IN', '`status`', ['Pending']]);

        $query->andFilterWhere(['NOT IN', '`user`.`id`', $subQuery]);
        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'email', $this->email]);

        /*echo $query->createCommand()->rawSql;
        exit;*/

        return $dataProvider;
    }

    public function getUserIds($query)
    {
        $users = $query->all();
        $ids = [];

        if (is_array($users) && count($users) > 0) {

            foreach ($users as $user) {
                $ids[$user->id] = $user->id;
            }
        }
        return $ids;
    }

    public function getCount()
    {
        $query = User::find();
        $query->join('inner join', 'auth_assignment', 'auth_assignment.user_id = id')->where(['auth_assignment.item_name' => self::ROLE_USER]);

        return $query->count();
    }

    public function searchDeletedRequest($params)
    {
        $query = User::find();
        $query->join('inner join', 'user_profile', 'user_profile.user_id = id');
        $query->join('inner join', 'auth_assignment', 'auth_assignment.user_id = id')->where(['auth_assignment.item_name' => self::ROLE_USER]);


        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            '`user_profile`.`is_deleted`' => $this->is_deleted,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}
