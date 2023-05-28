<?php

define ( "API_KEY" , "YOUR KEY");


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

    [ 'wins' => $wins, 'losses' => $losses, 'rank' => $rank, 'tier' => $tier] = $data[0];

    $selected_data = [
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
            'puuid' => $puuid,
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
        
        ['queueId' => $queueId, 'gameStartTimestamp' => $gameStartTimestamp] = $data['info'];

        $my_info =  [
            'puuid' => $puuid,
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
            'queueId' => $queueId, 'gameStartTimestamp' => $gameStartTimestamp
        ];

    }
    
    return $my_info;
}

function load_data($name){
    $account_data = get_account_data(urlencode($name));

    $account_info = get_account_info($account_data['id']);

    $last_matches =  get_account_matches($account_data['puuid']);

    $all_matches = [];

    foreach($last_matches as $match){
        $all_matches[$match] = get_match_info($match,$account_data['puuid']);
    };

    
    $raw_data = [
        'account_data' => array_merge($account_data,$account_info),
        'all_matches'  => $all_matches
    ];

    return json_encode($raw_data);
}
echo(load_data('FLACKO G'));

$lols_names = ['ABCDEFGHIJ', 'ALASTRAEA', 'ASINUS', 'ASWANG', 'BEBEK', 'BRUTALITYX', 'CALLMEPRINCESS', 'CHLOEGRACEMORETZ', 'CWRU', 'CYBERBEAST', 'DADDYSENPAI', 'DEESNUTS', 'DETECTED', 'EKKKKKO', 'EMOTICON', 'EMPEROROFHELL', 'FUNCTION', 'GENGRULERR', 'HERMIONE', 'IAMANGEL', 'IIK1', 'KAPPUCINO', 'KIDUS', 'LITTLEASIAN', 'LLLLLLLIIIIIII', 'LLOVEHENTAI', 'LORY', 'MAEVA', 'MALZAHÁR', 'MICROMANAGER', 'NIHIL', 'NINJER', 'NOTANOOB', 'NOTTHATTOXIC', 'OOLUCIFEROO', 'PANDARIUS', 'POGGERSFISH', 'PYS', 'QUEENLARA', 'RIPDOMINION', 'SIEGEMINION', 'SINGÊD', 'SPACECROW', 'SSSSSS', 'SUNK', 'SUPERBIA', 'SYN10', 'THEGAMINGEAGLE', 'THEJØKESØNYØU', 'TICHONDRIUS', 'TYSKEREN', 'UNIQX', 'VOXMORTIS', 'WINDYGIRL', 'XXXWEEDLORDXXX', 'YÁS', 'ADEIE', 'BIGGG', 'BLINDQ', 'BOOOOO', 'CALLMEPAPICHULO', 'CATLORD', 'CHIEFDINGO', 'CRYSTALMOON', 'CRYSTALSNOW', 'DARIUS1', 'DATUM', 'DAXES', 'DEINEMUTTA', 'DICH', 'DONOTKILLME', 'DOPPELGAENGER', 'EASYMASTER', 'ELSNORRO', 'EVERDEAD', 'FINALBOSSBARD', 'FINESTRA', 'FRÖST', 'GEFALLENERENGEL', 'GUNFIGHTER', 'IDEALGAMER', 'IHAVOC', 'IMORTALL', 'KAGENOASASHIN', 'KATUM', 'KISEIJUU', 'LILNUGGET', 'LILSEEN', 'MARCOSS', 'MIMES', 'MINESTHRA', 'MOZZARELLASTICK', 'MYTHIUS', 'PALUS', 'PAULMLD', 'PRINCESSLUNAR', 'SATIRIST', 'SOULMASTER', 'SPACEANDTIME', 'SPIDERPUJS'];
