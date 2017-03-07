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
            'age' =>        ['56' => '25', '63' => '35'],
            'bust' =>       ['32' => '78.74', '33' => '101.6'],
            'chest' =>      ['19' => '63.5', '20' => '114.3'],
            'height' =>     ['14' => '152.4', '15' => '210.82'],
            'hips' =>       ['30' => '83.82', '31' => '110.49'],
            'inseam' =>     ['28' => '63.5', '29' => '91.44'],
            'neck' =>       ['17' => '76.2', '18' => '119.38'],
            'shoulders' =>  ['21' => '60.96', '22' => '105.41'],
            'sleeve' =>     ['24' => '71.12', '25' => '116.84'],
            'waist' =>      ['26' => '52.07', '27' => '86.36'],
            'weight' =>     ['16' => '50', '23' => '60'],
        ];
        $fldIds = [];
        foreach($allFldArray as $fld => $data){
            foreach($data  as $field_id => $value){
                $fldIds[$field_id] =  $field_id;
            }

        }
        pr(implode(",",$fldIds));

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
        $ageFldArray = ['56' => 'age-from', '63' => 'age-to'];

        $ageArray = [];
        foreach (range(10, 100) as $e) {
            $ageArray[$e . ' year'] = $e;
        }

        foreach ($ageFldArray as $field_id => $title) {

            foreach ($ageArray as $name => $value) {
                $jobFieldOption = new JobFieldOption();
                $jobFieldOption->field_id = $field_id;
                $jobFieldOption->name = $name;
                $jobFieldOption->value = $value;

                if (!$jobFieldOption->save(false)) {
                    pr($jobFieldOption->getErrors());
                }
            }
        }

        $heightFldArray = ['14' => 'height-from', '15' => 'height-to',];

        $heightArray = ['3 ft. 0 in.' => 91.44,
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

        foreach ($heightFldArray as $field_id => $title) {

            foreach ($heightArray as $name => $value) {
                $jobFieldOption = new JobFieldOption();
                $jobFieldOption->field_id = $field_id;
                $jobFieldOption->name = $name;
                $jobFieldOption->value = $value;

                if (!$jobFieldOption->save(false)) {
                    pr($jobFieldOption->getErrors());
                }
            }
        }

        $inchesArray = [
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

        $allAttrib = [
            '32' => 'bust-from', '33' => 'bust-to',
            '19' => 'chest-from', '20' => 'chest-to',
            '30' => 'hips-from', '31' => 'hips-to',
            '28' => 'inseam-from', '29' => 'inseam-to',
            '17' => 'neck-from', '18' => 'neck-to',
            '21' => 'shoulders-from', '22' => 'shoulders-to',
            '24' => 'sleeve-from', '25' => 'sleeve-to',
            '26' => 'waist-from', '27' => 'waist-to'
        ];

        foreach ($allAttrib as $field_id => $title) {

            foreach ($inchesArray as $name => $value) {
                $jobFieldOption = new JobFieldOption();
                $jobFieldOption->field_id = $field_id;
                $jobFieldOption->name = $name;
                $jobFieldOption->value = $value;

                if (!$jobFieldOption->save(false)) {
                    pr($jobFieldOption->getErrors());
                }
            }
        }

        $weightFldArray = ['16' => 'weight-from', '23' => 'weight-to'];
        $weightArray = [];
        foreach (range(10, 250) as $e) {
            $weightArray[$e . ' lbs.'] = $e;
        }

        foreach ($weightFldArray as $field_id => $title) {

            foreach ($weightArray as $name => $value) {
                $jobFieldOption = new JobFieldOption();
                $jobFieldOption->field_id = $field_id;
                $jobFieldOption->name = $name;
                $jobFieldOption->value = $value;
                if (!$jobFieldOption->save(false)) {
                    pr($jobFieldOption->getErrors());
                }
            }
        }


        $otherArray =
            [
                /*US shoe size*/
                '35' => [
                    '2' => '2',
                    '2.5' => '2.5',
                    '3' =>  '3',
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
                    '16'=>'16',
                    '16.5'=>'16.5',
                    '17' => '17',
                    '17.5' => '17.5',
                    '18' => '18',
                    '18.5' => '18.5',
                    '19' => '19',
                    '19.5' => '19.5',
                    '20' => '20'
                ],
                /* Cup Size */
                '34' => ['A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'DD' => 'DD', 'E' => 'E', 'Above E' => 'Above E'],

                /* Role Type */
                '38'=> [
                    'On Camera/Stage – Speaking' => 'On Camera/Stage – Speaking',
                    'On Camera/Stage - Non-Speaking' => 'On Camera/Stage - Non-Speaking',
                    'Stunts' => 'Stunts',
                    'Voice Over' => 'Voice Over',
                    'Stand-In' => 'Stand-In',
                ],

                /* Set Experience */
                '41' => ['None' => 'None', '1-3 Days' => '1-3 Days', '4-9 Days' => '4-9 Days', '10 Days or More' => '10 Days or More'],

                /* Real World Experience */
                '42' => [  'Police'=>  'Police','Firefighter' => 'Firefighter', 'Doctor' => 'Doctor', 'Lawyer' => 'Lawyer', 'Military' => 'Military', 'Bartender' => 'Bartender', 'Nurse' => 'Nurse', 'Other' => 'Other',],
                /*  Spoken Languages*/
                '43' => ['English' => 'English', 'Spanish' => 'Spanish', 'French' => 'French', 'German' => 'German', 'Italian' => 'Italian', 'Russian' => 'Russian', 'Mandarin' => 'Mandarin', 'Arabic' => 'Arabic', 'Other' => 'Other'],
                /* Special Skills */
                '44' => ['Ballet' => 'Ballet', 'Guitar' => 'Guitar', 'Singing' => 'Singing', 'Horseback Riding' => 'Horseback Riding', 'Other'=> 'Other'],

                /* Union Status */
                '40' => ['SAG/AFTRA' => 'SAG/AFTRA', 'Non-Union' => 'Non-Union'],

                /* Ethnicity */
                '36' => ['Caucasian' =>'Caucasian', 'Black' => 'Black', 'Hispanic' => 'Hispanic', 'Asian' => 'Asian', 'South Asian' => 'South Asian', 'Native' => 'Native', 'American' => 'American', 'Middle Easter' => 'Middle Easter', 'Pacific Islander' => 'Pacific Islander'],

                /* Hair Color */
                '45' => [ 'Light Blonde' => 'Light Blonde', 'Medium Blonde' => 'Medium Blonde', 'Dark Blonde' => 'Dark Blonde', 'Light Brown' => 'Light Brown', 'Dark Brown' => 'Dark Brown', 'Red' => 'Red', 'Black' => 'Black', 'Gray' => 'Gray', 'White' => 'White', 'Salt and Pepper' => 'Salt and Pepper', 'Unique Color' => 'Unique Color'],

                /* Hair Length */
                '46' => [ 'Short' => 'Short', 'Medium' => 'Medium', 'Long' => 'Long', 'Military Cut' => 'Military Cut', 'Shaved/Bald' => 'Shaved/Bald' ],

                /* Does Talent Need a Picture Car? */
                '58' => ['Yes' => 'Yes', 'No' => 'No'],

                /* Project Type */
                '37' => [ 'Feature Film' => 'Feature Film', 'Television' => 'Television', 'Modeling' => 'Modeling', 'Theater' => 'Theater', 'Short Film' => 'Short Film', 'Commercial' => 'Commercial', 'Online' => 'Online', 'Reality TV' => 'Reality TV', 'Game Show' => 'Game Show', 'Brand Ambassador' => 'Brand Ambassador'],


                /* Compensation Type*/
                '39' => ['Paid' => 'Paid', 'Unpaid' => 'Unpaid' ],

                /* Gender */
                '51' => ['Male' => 'Male', 'Female' => 'Female'],
            ];

        foreach ($otherArray as $field_id => $options) {

            foreach ($options as $name => $value) {
                $jobFieldOption = new JobFieldOption();
                $jobFieldOption->field_id = $field_id;
                $jobFieldOption->name = $name;
                $jobFieldOption->value = $value;
                if (!$jobFieldOption->save(false)) {
                    pr($jobFieldOption->getErrors());
                }
            }
        }

        echo "done";
        exit;
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

    public static function getRolecallPostedCount($user_id)
    {
        $query = JobItemModel::find()
            ->select(['COUNT(*) AS cnt'])
            ->where(['user_id' => $user_id])
            ->count();
        return $query;
    }
}
