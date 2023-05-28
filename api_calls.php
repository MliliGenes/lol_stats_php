<?php

// $url = 'https://euw1.api.riotgames.com/lol/league/v4/entries/by-summoner/d8y05rH0XtaSbAwEeWVyfKT0HtHZIwUdr6VMAL100hyjyl5fN5_9PVIPdw?api_key=RGAPI-2449e28a-a683-4f33-b283-0bfd40519c6d';
// $response = file_get_contents($url);

// if ($response === false) {
//     echo 'Error fetching data.';
// } else {
//     $data = json_decode($response, true);
//     $response = $data[0];
//     ['summonerName' => $summonerName, 'wins' => $wins, 'losses' => $losses, 'rank' => $rank, 'tier' => $tier] = $response;
//     $personal = ['summonerName' => $summonerName, 'wins' => $wins, 'losses' => $losses, 'rank' => $rank, 'tier' => $tier];
//     echo "<pre>";
//     $keys= array_keys($personal);
//     $last_key =  end($keys);
//     foreach($personal as $key => $value){
//         if ($key === $last_key){
//             echo "$key: $value";
//         }else{
//             echo "$key: $value <br>";
//         }
//     }
// }
define ( "API_KEY" , "RGAPI-2449e28a-a683-4f33-b283-0bfd40519c6d");


function get_account_data($name){

    $url = "https://euw1.api.riotgames.com/lol/summoner/v4/summoners/by-name/$name?api_key=" . API_KEY; 
    
    $response = file_get_contents($url);

    if ($response === false) {
        exit;
    }

    $data = json_decode($response, true);

    ['id' => $id, 'puuid' => $puuid, 'name' => $name, 'profileIconId' => $profileIconId, 'summonerLevel' => $summonerLevel] = $data;

    $selected_data = ['id' => $id,
        'puuid' => $puuid,
        'name' => $name,
        'profileIconId' => $profileIconId,
        'summonerLevel' => $summonerLevel
    ];

    return  $selected_data;

}
function get_account_info($id) {

    $url = "https://euw1.api.riotgames.com/lol/league/v4/entries/by-summoner/$id?api_key=" . API_KEY;

    $response = file_get_contents($url);

    if ($response === false) {
        exit;
    }

    $data = json_decode($response, true);

    ['summonerName' => $summonerName, 'wins' => $wins, 'losses' => $losses, 'rank' => $rank, 'tier' => $tier] = $data[0];

    $selected_data = [
        'summonerName' => $summonerName,
        'wins' => $wins,
        'losses' => $losses,
        'rank' => $rank,
        'tier' => $tier
    ];
    
    return $selected_data;

}

function get_account_matches($puuid){

    $url = "https://europe.api.riotgames.com/lol/match/v5/matches/by-puuid/$puuid/ids?start=0&count=20&api_key=" . API_KEY;

    $response = file_get_contents($url);

    if ($response === false) {
        exit;
    }

    $data = json_decode($response, true);

    return $data;
}

function get_match_info($match_id,$puuid){
    $url = "https://europe.api.riotgames.com/lol/match/v5/matches/$match_id?api_key=" . API_KEY ;
    
    $response = file_get_contents($url);

    if ($response === false) {
        exit;
    }

    $data = json_decode($response, true);

    ['participants' => $participants] = $data['info'];

    $selected_data = [
        'participants' => $participants
    ];

    $me = null;
    foreach ($participants as $participant) {
    if ($participant['puuid'] === $puuid) {
        $me = $participant;
        break;
    }
    }
    
    if ($me){
        [
            'championName' => $championName,
            'totalDamageDealtToChampions' => $totalDamageDealtToChampions,
            'totalDamageTaken' => $totalDamageTaken,
            'champLevel' => $champLevel,
            'kills' => $kills,
            'deaths' => $deaths,
            'assists' => $assists,
            'totalMinionsKilled' => $totalMinionsKilled,
            'item0' => $item0,
            'item1' => $item1,
            'item2' => $item2,
            'item3' => $item3,
            'item4' => $item4,
            'item5' => $item5,
            'item6' => $item6,
            'summoner1Id' => $summoner1Id,
            'summoner2Id' => $summoner2Id,
            'win' => $win,
            'teamEarlySurrendered' => $teamEarlySurrendered,
        ] = $me;

        $my_info =  [
            'championName' => $championName,
            'totalDamageDealtToChampions' => $totalDamageDealtToChampions,
            'totalDamageTaken' => $totalDamageTaken,
            'champLevel' => $champLevel,
            'kills' => $kills,
            'deaths' => $deaths,
            'assists' => $assists,
            'totalMinionsKilled' => $totalMinionsKilled,
            'item0' => $item0,
            'item1' => $item1,
            'item2' => $item2,
            'item3' => $item3,
            'item4' => $item4,
            'item5' => $item5,
            'item6' => $item6,
            'summoner1Id' => $summoner1Id,
            'summoner2Id' => $summoner2Id,
            'win' => $win,
            'teamEarlySurrendered' => $teamEarlySurrendered,
        ];

    }
    
    return $my_info;
}

echo "<pre>";
$account_data = get_account_data(urlencode("FLACKO G"));
var_dump($account_data);

$account_info = get_account_info($account_data['id']);
var_dump($account_info);

$last_matches =  get_account_matches($account_data['puuid']);
var_dump($last_matches);

$all_matches = [];

foreach($last_matches as $match){
    $all_matches[$match] = get_match_info($match,$account_data['puuid']);
};

var_dump($all_matches);
