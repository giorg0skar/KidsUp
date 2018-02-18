<?php 
    require '/opt/lampp/vendor/autoload.php';
    use Elasticsearch\ClientBuilder;
    //DEFINE ('DB_USER', 'root');
    //DEFINE ('DB_PASSWORD', '...');
    //DEFINE ('DB_HOST', 'localhost:3306');
    //DEFINE ('DB_NAME', 'KidsUp');

//this function does full-text search in ElasticSearch
//and returns the matching activities    
function do_search($search)
{
    $client = ClientBuilder::create()->build();

    $search_phrase = $search['search'];
    $area = $search['area'];
    $distance = $search['distance'];
    $act_kind = $search['act_kind'];
    $age = $search['age'];
    if($age != NULL){
        $age_val = explode(',',$age);
        $minage = intval($age_val[0]);
        $maxage = intval($age_val[1]);
    }else{
        $minage = NULL;
        $maxage = NULL;        
    }
    $interval = $search['interval'];

    $params = [
        'index' => 'kidsup_new',
        'type' => 'activity',
        'body' => [
            'query' => [
                'bool' => [
                    'must' => [
                        'multi_match' => [
                            'query' => $search_phrase,
                            'fields' => ["actname", "acttype", "actdescription"]
                        ]
                    ]
                ]
            ]
        ]
    ];

    $index = 0;
    if($area != NULL){
        $location_coord = get_coordinates($area);
        if($distance != NULL){
            $params['body']['query']['bool']['filter']['bool']['must'][$index]['geo_distance']['distance'] = $distance.'km';
        }else{
            $params['body']['query']['bool']['filter']['bool']['must'][$index]['geo_distance']['distance'] = '10km';            
        }
        $params['body']['query']['bool']['filter']['bool']['must'][$index]['geo_distance']['location']['lat'] = $location_coord[0];
        $params['body']['query']['bool']['filter']['bool']['must'][$index]['geo_distance']['location']['lon'] = $location_coord[1];
        $index++;
    }
    if($act_kind != NULL){
        $params['body']['query']['bool']['filter']['bool']['must'][$index]['match']['acttype'] = $act_kind;
        $index++;
    }
    if($interval != NULL){
        $params['body']['query']['bool']['filter']['bool']['must'][$index]['range']['actdate']['gte'] = 'now';
        $params['body']['query']['bool']['filter']['bool']['must'][$index+1]['range']['actdate']['lte'] = 'now+'.$interval.'/d';
        $index+=2;
    }
    if($minage != NULL && $maxage != NULL){
        $params['body']['query']['bool']['filter']['bool']['must'][$index]['range']['minage']['lte'] = $minage;
        $params['body']['query']['bool']['filter']['bool']['must'][$index+1]['range']['maxage']['gte'] = $maxage;
        $index+=2;
    }

    $results = $client->search($params);
    // take results (collect actids in an array)  
    $hits = $results['hits']['total'];
    $result_ids = array();
    for ($i=0; $i<$hits; $i++){
        $result_ids[] = $results['hits']['hits'][$i]['_id'];
    }
    //convert actids to comma-separated string for the select statement
    $string_ids = implode(',', $result_ids);
    
    // submit select query to mySQL
    require_once('./mysqli_connect.php');
    /*
    $dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
    OR die('Could not connect to MySQL: ' .mysqli_connect_error());
    mysqli_set_charset($dbc, "utf8");
    */
    mb_internal_encoding('UTF-8');
    mb_http_input("utf-8");
      
    $sql = "SELECT * FROM Activity WHERE ActID IN ($string_ids)";
    $result = mysqli_query($dbc,$sql);

    //$dbc->close();

    $activities = array();
    for($i=0; $i<$hits; $i++){
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
        $activities[] = $row;        
    }
    return array($activities, $hits);
}    

//this function inserts a given activity to ElasticSearch
function insert_activity($activity){
    $client = ClientBuilder::create()->build();
    $actid = $activity['ActID'];
    $actname = $activity['actName'];
    $act_kind = $activity['actType'];
    $actdate = $activity['actDate'];
    $minage = $activity['MinAge'];
    $maxage = $activity['MaxAge'];
    $availabletickets = $activity['availableTickets'];
    $latitude = $activity['latitude'];
    $longitude = $activity['longitude'];
    $actdescription = $activity['actDescription'];
    if($availabletickets == 0)
        $availabletickets = false;
    else   
        $availabletickets = true;    

    $params = [
        'index' => 'kidsup_new',
        'type' => 'activity',
        'id' => $actid,
        'body' => [ 'actname' => $actname,
                    'acttype' => $act_kind,
                    'actdate' => $actdate,
                    'minage' => $minage,
                    'maxage' => $maxage,
                    'availabletickets' => $availabletickets,
                    'location' => [
                        'lat' => $latitude,
                        'lon' => $longitude
                    ],
                    'actdescription' => $actdescription
                ]
    ];

    $response = $client->index($params);
}

//this is called in the first search after deployment -> it creates 
//an index in ElasticSearch and transfers the necessary attributes
//from the activities in mySQL (one activity per document)
function create_index(){
    $client = ClientBuilder::create()->build();
    
    //check if index already exists
    $indexParams['index']  = 'kidsup_new';   
    if($client->indices()->exists($indexParams)){
        return;
    }
    //if it does not exist then create the index

    $params = [
        'index' => 'kidsup_new',
        'body' => [
            'mappings' => [ 
                'activity' => [    
                    'properties' => [
                        'actname' => [
                            'type' => 'text',
                            'analyzer' => 'greek'
                        ],
                        'acttype' => [
                            'type' => 'text',
                            'analyzer' => 'greek'
                        ],
                        'actdate' => [
                            'type' => 'date',
                            'format' => 'yyyy-MM-dd HH:mm:ss'
                        ],
                        'minage' => [
                            'type' => 'integer'
                        ],
                        'maxage' => [
                            'type' => 'integer'
                        ],
                        'availabletickets' => [
                            'type' => 'boolean'
                        ],
                        'location' => [
                            'type' => 'geo_point'
                        ],
                        'actdescription' => [
                            'type' => 'text',
                            'analyzer' => 'greek'
                        ]
                    ]
                ]
            ]
        ]
    ];
    $client->indices()->create($params);  
    //transfer all activities to ElasticSearch
    insert_activities();  
}

function insert_activities(){
    //read activities from mysql
    require_once("./mysqli_connect.php");
    /*
    $dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
    OR die('Could not connect to MySQL: ' .mysqli_connect_error());
    mysqli_set_charset($dbc, "utf8");
    */
    mb_internal_encoding('UTF-8');
    mb_http_input("utf-8");
      
    $sql = "SELECT * FROM Activity";
    $result = mysqli_query($dbc,$sql);
    
    //$dbc->close();
    for($i=0; $i< mysqli_num_rows($result); $i++){
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
        insert_activity($row);
    }
}

function get_coordinates($area){
    $url='https://maps.google.com/maps/api/geocode/json?address='.urlencode($area).'&key=AIzaSyBsLUCKMjlmcDrvL6IXYlaHez6AUb01O8U&sensor=false';
    $geocode = file_get_contents($url);
    $output= json_decode($geocode , true);
    $latitude = $output['results'][0]['geometry']['location']['lat'];
    $longitude = $output['results'][0]['geometry']['location']['lng'];
    return array($latitude, $longitude);
}

?>