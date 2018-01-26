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

    //$search = trim($_POST["search"]);
    // submit query to ES with PHP API
    $params = [
        'index' => 'kidsup_new',
        'type' => 'activity',
        'body' => [
            'query' => [
                'multi_match' => [
                    'query' => $search,
                    'fields' => ["actname", "acttype", "actdescription"]
                ]
            ]
        ]
    ];

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
    $acttype = $activity['actType'];
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
                    'acttype' => $acttype,
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

    /*--actdate should be type => date to support
    * date filters (there is a bug in compatibility
    * betwwen DATETIME in mySQL and date in ES) 
    * -> bug must be fixed later
    */
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
                            'type' => 'text'
                        ],
                        'minage' => [
                            'type' => 'long'
                        ],
                        'maxage' => [
                            'type' => 'long'
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

?>