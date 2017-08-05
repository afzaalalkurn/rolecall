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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'auth_key', 'password_hash', 'password_reset_token', 'email'], 'safe'],
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

    public function importData(){

        $inchesArray = ['15 in.' => 38.1,
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
            '32 in. '=> 81.28,
            '32½ in.' => 82.55,
            '33 in. '=> 83.82,
            '33½ in.' => 85.09,
            '34 in. '=> 86.36,
            '34½ in.' => 87.63,
            '35 in. '=> 88.9,
            '35½ in.' => 90.17,
            '36 in. '=> 91.44,
            '36½ in.' => 92.71,
            '37 in. '=> 93.98,
            '37½ in.' => 95.25,
            '38 in. '=> 96.52,
            '38½ in.' => 97.79,
            '39 in. '=> 99.06,
            '39½ in.' => 100.33,
            '40 in. '=> 101.6,
            '40½ in.' => 102.87,
            '41 in. '=> 104.14,
            '41½ in.' => 105.41,
            '42 in. '=> 106.68,
            '42½ in.' => 107.95,
            '43 in. '=> 109.22,
            '43½ in.' => 110.49,
            '44 in. '=> 111.76,
            '44½ in.' => 113.03,
            '45 in. '=> 114.3,
            '45½ in.' => 115.57,
            '46 in. '=> 116.84,
            '46½ in.' => 118.11,
            '47 in. '=> 119.38,
            '47½ in.' => 120.65,
            '48 in. '=> 121.92,
            '48½ in.' => 123.19,
            '49 in.' => 124.46,
            '49½ in.' => 125.73,
            '50 in.' => 127];

        $allAttrib = [
            '32' => 'bust',
            '34' => 'chest',
            '29' => 'hips',
            '31' => 'inseam',
            '33' => 'neck',
            '35' => 'shoulders',
            '30' => 'sleeve',
            '28' => 'waist'];


        foreach($allAttrib as $field_id => $title){

            foreach($inchesArray as $name => $value){
                $userFieldOption = new UserFieldOption();
                $userFieldOption->field_id = $field_id;
                $userFieldOption->name = $name;
                $userFieldOption->value =  $value;
                if(!$userFieldOption->save(false)){
                    pr($userFieldOption->getErrors());
                }

            }
        }

        $heightArray = [
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

        foreach($heightArray as $name => $value){
            $userFieldOption = new UserFieldOption();
            $userFieldOption->field_id = 13;
            $userFieldOption->name = $name;
            $userFieldOption->value =  $value;
            if(!$userFieldOption->save(false)){
                pr($userFieldOption->getErrors());
            }
        }
        $weightArray = [];
        foreach(range(20, 250) as $e){
            $weightArray[$e . ' lbs.'] = $e ;
        }

        foreach($weightArray as $name => $value){
            $userFieldOption = new UserFieldOption();
            $userFieldOption->field_id = 27;
            $userFieldOption->name = $name;
            $userFieldOption->value =  $value;
            if(!$userFieldOption->save(false)){
                pr($userFieldOption->getErrors());
            }
        }

        $otherArray =
            [
                /*US shoe size*/
                '14' => [
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
                '16' => ['A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'DD' => 'DD', 'E' => 'E', 'Above E' => 'Above E'],

                /* Role Type */
                '6'=> [
                    'On Camera/Stage – Speaking' => 'On Camera/Stage – Speaking',
                    'On Camera/Stage - Non-Speaking' => 'On Camera/Stage - Non-Speaking',
                    'Stunts' => 'Stunts',
                    'Voice Over' => 'Voice Over',
                    'Stand-In' => 'Stand-In',
                ],

                /* Set Experience */
                '9' => ['None' => 'None', '1-3 Days' => '1-3 Days', '4-9 Days' => '4-9 Days', '10 Days or More' => '10 Days or More'],

                /* Real World Experience */
                '10' => [  'Police'=>  'Police','Firefighter' => 'Firefighter', 'Doctor' => 'Doctor', 'Lawyer' => 'Lawyer', 'Military' => 'Military', 'Bartender' => 'Bartender', 'Nurse' => 'Nurse', 'Other' => 'Other',],

                /*  Spoken Languages*/
                '11' => ['English' => 'English', 'Spanish' => 'Spanish', 'French' => 'French', 'German' => 'German', 'Italian' => 'Italian', 'Russian' => 'Russian', 'Mandarin' => 'Mandarin', 'Arabic' => 'Arabic', 'Other' => 'Other'],
                /* Special Skills */
                '12' => ['Ballet' => 'Ballet', 'Guitar' => 'Guitar', 'Singing' => 'Singing', 'Horseback Riding' => 'Horseback Riding', 'Other'=> 'Other'],

                /* Union Status */
                '8' => ['SAG/AFTRA' => 'SAG/AFTRA', 'Non-Union' => 'Non-Union'],

                /* Ethnicity */
                '1' => ['Caucasian' =>'Caucasian', 'Black' => 'Black', 'Hispanic' => 'Hispanic', 'Asian' => 'Asian', 'South Asian' => 'South Asian', 'Native' => 'Native', 'American' => 'American', 'Middle Easter' => 'Middle Easter', 'Pacific Islander' => 'Pacific Islander'],

                /* Hair Color */
                '17' => [ 'Light Blonde' => 'Light Blonde', 'Medium Blonde' => 'Medium Blonde', 'Dark Blonde' => 'Dark Blonde', 'Light Brown' => 'Light Brown', 'Dark Brown' => 'Dark Brown', 'Red' => 'Red', 'Black' => 'Black', 'Gray' => 'Gray', 'White' => 'White', 'Salt and Pepper' => 'Salt and Pepper', 'Unique Color' => 'Unique Color'],

                /* Hair Length */
                '18' => [ 'Short' => 'Short', 'Medium' => 'Medium', 'Long' => 'Long', 'Military Cut' => 'Military Cut', 'Shaved/Bald' => 'Shaved/Bald' ],

                /* Does Talent Need a Picture Car? */
                '19' => ['Yes' => 'Yes', 'No' => 'No'],

                /* Project Type */
                '5' => [ 'Feature Film' => 'Feature Film', 'Television' => 'Television', 'Modeling' => 'Modeling', 'Theater' => 'Theater', 'Short Film' => 'Short Film', 'Commercial' => 'Commercial', 'Online' => 'Online', 'Reality TV' => 'Reality TV', 'Game Show' => 'Game Show', 'Brand Ambassador' => 'Brand Ambassador'],

                /* Compensation Type*/
                '7' => ['Paid' => 'Paid', 'Unpaid' => 'Unpaid' ],
            ];

        foreach ($otherArray as $field_id => $options) {

            foreach ($options as $name => $value) {
                $userFieldOption = new UserFieldOption();
                $userFieldOption->field_id = $field_id;
                $userFieldOption->name = $name;
                $userFieldOption->value = $value;

                if ( !$userFieldOption->save(false) ) {
                    pr( $userFieldOption->getErrors() );
                }
            }
        }

        echo "Done";
        exit;
    }

    public function arrayRand($dArr){
        $a = array_rand($dArr);
        return $dArr[$a];
    }

    public function updateUserData()
    {
        $userIds = [288,289,290,291,292,293,294];

        $allFldArray =  [
                            'us-shoe-size' => [ '14' => '6.5' ],
                            'role-type' => [ '6' => 'On Camera/Stage – Speaking'],
                            'set-experience' => [ '9' => $this->arrayRand(['1-3 Days', '4-9 Days']) ],
                            'real-world-experience'=> [ '10' => $this->arrayRand(['Lawyer', 'Other']) ],
                            'spoken-languages' =>  [ '11' => $this->arrayRand(['English','German','Italian','Other']) ],
                            'special-skills' => [ '12' => $this->arrayRand(['Singing','Horseback Riding','Other']) ],
                            'union-status' => [ '8' => $this->arrayRand(['SAG/AFTRA', 'Non-Union'])],
                            'ethnicity' => [ '1' => $this->arrayRand(['Caucasian', 'Hispanic'])],
                            'hair-color' => [ '17' => $this->arrayRand(['Medium Blonde', 'Dark Blonde'])],
                            'hair-length' => [ '18' => 'Medium'],
                            'bust' => ['32' => '78.74'],
                            'chest' => ['34' => '63.5'],
                            'height' => ['13' => '152.4'],
                            'hips' => ['29' => '83.82'],
                            'inseam' => ['31' => '63.5'],
                            'neck' => ['33' => '76.2'],
                            'shoulders' => ['35' => '60.96'],
                            'sleeve' => ['30' => '71.12'],
                            'waist' => ['28' => '52.07'],
                            'weight' =>     ['27' => '50'],
                        ];





        $fldIds = [];
        foreach($allFldArray as $fld => $data){

            foreach($data  as $field_id => $value){
                $fldIds[$field_id] =  $field_id;
            }
        }

        foreach ($userIds as $user_id) {

            $userFields = UserProfile::findOne($user_id);

            if($userFields->gender == 'Female'){
                unset($allFldArray['chest']);
            }

            if($userFields->gender == 'Male'){
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

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = User::find();
        $query = User::find()->join('inner join', '`auth_assignment`', '`auth_assignment`.`user_id` = `id`')
            ->where(['`auth_assignment`.`item_name`' => self::ROLE_USER,
                '`user`.`status`' => '10']);
        $query->join('INNER JOIN', '`user_profile`', '`user_profile`.`user_id` = `user`.`id`'); 
        $sql = "SELECT uf.field_id,  uf.`field`, uf.`name`  FROM `user_field` as `uf`";
        $userFields = Yii::$app->db->createCommand($sql)->queryAll();

        if(!empty($this->job_id)){
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

           if($jobFieldArray['gender'] == 'Female'){
                $matchArray['bust'] = ['bust-from', 'bust-to'];                
                $matchArray['hips'] = ['hips-from', 'hips-to'];
                $matchArray['cup-size'] = 'cup-size';
            }

           if($jobFieldArray['gender'] == 'Male'){
                $matchArray['chest'] =  ['chest-from', 'chest-to'];
                $matchArray['shoulders'] = ['shoulders-from', 'shoulders-to'];
                $matchArray['neck'] = ['neck-from', 'neck-to'];
            }

            if(!empty($jobFieldArray['gender'])){
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

                if(is_array($ids) && count($ids) > 0){

                    $query = User::find();
                    $query->addSelect(['`user`.*']);

                    if (is_array($data) && count($data) == 2) {

                        list($from, $to) = $data;

                        $from = $jobFieldArray[$from] ?? null;
                        $to   = $jobFieldArray[$to] ?? null;

                        if(!empty($from) && !empty($to) ){

                            $query->join('LEFT JOIN', '`user_field_value` as `a' . $fieldIdx . '`', '`a' . $fieldIdx . '`.`user_id` = `user`.`id`');
                            $query->andFilterWhere([ ' `a' . $fieldIdx . '`.`field_id` ' => $fldArray[$fieldIdx] ]);


                            if ($fieldIdx == 'birthday') {
                                $query->andFilterWhere(['between', 'SELECT TIMESTAMPDIFF( YEAR, STR_TO_DATE(REPLACE(`a' . $fieldIdx . '`.`value`,","," "), "%M %d %Y %h:%i%p") , CURDATE())', (int)$from, (int)$to]);
                            } else {
                                $query->andFilterWhere(['between', '`a' . $fieldIdx . '`.`value`', (int)$from, (int)$to]);
                            }
                        }

                    } elseif (!empty($jobFieldArray[$data])) {

                        $query->join('LEFT JOIN', '`user_field_value` as `a' . $fieldIdx . '`', '`a' . $fieldIdx . '`.`user_id` = `user`.`id`');
                        $query->andFilterWhere([ ' `a' . $fieldIdx . '`.`field_id` ' => $fldArray[$fieldIdx] ]);

                        $jobFieldValue = $jobFieldArray[$data];
                        ($jobFieldValue = @unserialize($jobFieldValue)) ? $jobFieldValue : $jobFieldValue;

                        if(is_array($jobFieldValue) && count($jobFieldValue) > 0){

                            $elements = [];                        
                            if(count($jobFieldValue)){

                                foreach($jobFieldValue as $jv){
                                    $elements[] =  $jv;
                                }

                                if(count($elements) > 1){
                                    $query->andFilterWhere(['IN', '`a' . $fieldIdx . '`.`value`', $elements]);
                                }else{
                                    $query->andFilterWhere(['LIKE', '`a' . $fieldIdx . '`.`value`', current($elements)]);
                                }
                            }

                        }else{
                            $query->andFilterWhere(['like', '`a' . $fieldIdx . '`.`value`', $jobFieldArray[$data]]);
                        }

                    }

                    $query->andFilterWhere(['IN', '`user`.`id`', $ids]);
                    $ids = $this->getUserIds($query); 
                } 
            } 
        }
        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([ 'query' => $query, ]);
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

        //echo $query->createCommand()->rawSql;
        //exit;

        //pr($this->radius);
        if (!empty($this->radius)) {
            $query->having(['<', 'distance', $this->radius]);
            $query->orderBy('distance');
        }

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

         //echo $query->createCommand()->rawSql;
         //exit;
         //pr( $query->createCommand()->rawSql );
        return $dataProvider;
    }

    public function getUserIds($query)
    {
        $users = $query->all(); 
        $ids = [];

        if(is_array($users) && count($users) > 0){

            foreach($users as $user ){
                $ids[$user->id] = $user->id;  
            }  
        }                    
        return $ids;
    }
}
