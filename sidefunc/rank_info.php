<?php
require_once '../conf/config.php'; // Include your config file to use the PDO connection

ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error_log.txt'); // Set the log file to your project directory
error_log('PHP Error Logging Started'); // Log initial message

// Define the job ranges and icon mappings
$jobGroups = [
    'Beginner' => [0],
    'Hero' => [112, 111, 110],
    'Paladin' => [122, 121, 120],
    'Dark Knight' => [133, 131, 130],
    'Fire Poison' => [212, 211, 210],
    'Ice Lightning' => [222, 221, 220],
    'Bishop' => [232, 231, 230],
    'Bowmaster' => [312, 311, 310],
    'Marksman' => [322, 321, 320],
    'Night Lord' => [412, 411, 410],
    'Shadower' => [422, 421, 420],
    'Corsair' => [522, 521, 520],
    'Buccaneer' => [512, 511, 510],
    'Dawn Warrior' => [1112, 1111, 1110, 1100],
    'Blaze Wizard' => [1212, 1211, 1210, 1200],
    'Wind Archer' => [1312, 1311, 1310, 1300],
    'Night Walker' => [1412, 1411, 1410, 1400],
    'Thunder Breaker' => [1512, 1511, 1510, 1500],
    'Aran' => [2112, 2111, 2110, 2100, 2000],
    'Pathfinder' => [332, 331, 330, 301],
    'Blade Master' => [434, 433, 432, 431, 430],
    'Cannon Master' => [532, 531, 530, 501],
    'Jett' => [572, 571, 570, 508],
    'Evan' => [2218, 2217, 2216, 2215, 2214, 2213, 2212, 2211, 2210, 2200, 2001],
    'Mercedes' => [2312, 2311, 2310, 2300, 2002],
    'Phantom' => [2412, 2411, 2410, 2003],
    'Shade' => [2512, 2511, 2510, 2005],
    'Luminous' => [2712, 2711, 2710, 2004],
    'Demon Slayer' => [3112, 3111, 3110, 3100, 3001],
    'Demon Avenger' => [3122, 3121, 3120, 3101],
    'Battle Mage' => [3212, 3211, 3210, 3200],
    'Wild Hunter' => [3312, 3311, 3310, 3300],
    'Mechanic' => [3512, 3511, 3510, 3500],
    'Xenon' => [3612, 3611, 3610, 3600, 3002],
    'Blaster' => [3712, 3711, 3710, 3700],
    'Hayato' => [4112, 4111, 4110, 4100, 4001],
    'Kanna' => [4212, 4211, 4210, 4200, 4002],
    'Mihile' => [5112, 5111, 5110, 5100, 5000],
    'Kaiser' => [6112, 6111, 6110, 6100, 6000],
    'Angelic Buster' => [6512, 6511, 6510, 6500, 6001],
    'Cadena' => [6412, 6411, 6410, 6400, 6002],
    'Zero' => [10112, 10111, 10110, 10100, 10000],
    'Beast Tamer' => [11212, 11211, 11210, 11000],
    'Kinesis' => [14212, 14211, 14210, 14200, 14000],
    'Illium' => [15212, 15211, 15210, 15200, 15000],
    'Ark' => [15512, 15511, 15510, 15500, 15001],
];

// Job icon mapping

$jobIcons = [
    'Warrior' => 'Warrior.png',
    'Magician' => 'Magician.png',
    'Illium' => 'illium.png',
    'Luminous' => 'Luminous.png',
    'Dawn Warrior' => 'DawnWarrior.png',
    'Bowman' => 'Bowman.png',
    'Marksman' => 'Bowman.png',
    'Wind Archer' => 'WindArcher.png',
    'Night Walker' => 'NightWalker.png',
    'Bowmaster' => 'Bowman.png',
    'Thief' => 'Thief.png',
    'Jett' => 'Jett.png',
    'Pirate' => 'Pirate.png',
    'Aran' => 'Aran.png',
    'Evan' => 'Evan.png',
    'Demon Slayer' => 'DemonSlayer.png',
    'Demon Avenger' => 'DemonAvenger.png',
    'Battle Mage' => 'BattleMage.png',
    'Wild Hunter' => 'WildHunter.png',
    'Mechanic' => 'Mechanic.png',
    'Dual Blade' => 'DualBlade.png',
    'Blade Master' => 'DualBlade.png',
    'Xenon' => 'Xenon.png',
    'Hayato' => 'Hayato.png',
    'Kanna' => 'Kanna.png',
    'Angelic Buster' => 'AngelicBuster.png',
    'Kaiser' => 'Kaiser.png',
    'Zero' => 'Zero.png',
    'Beast Tamer' => 'BeastTamer.png',
    'Beginner' => 'Beginner.png',
    'Pathfinder' => 'Pathfinder.png',
    'Cadena' => 'Cadena.png',
    'Shade' => 'Shade.png',
    'Ark' => 'Ark.png',
    'Mihile' => 'Mihile.png',
    'Blaster' => 'Blaster.png',
    'Bishop' => 'Bishop.png',
    'Hero' => 'Hero.png',
    'Buccaneer' => 'Buccaneer.png',
    'Corsair' => 'Corsair.png',
    'Dark Knight' => 'DarkKnight.png',
    'Dragon Knight' => 'DragonKnight.png',
    'Fighter' => 'Fighter.png',
    'Legend' => 'Legend.png',
    'Marauder' => 'Marauder.png',
    'Mercedes' => 'Mercedes.png',
    'Noblesse' => 'Noblesse.png',
    'Outlaw' => 'Outlaw.png',
    'Paladin' => 'Paladin.png',
    'Phantom' => 'Phantom.png',
    'Thunder Breaker' => 'ThunderBreaker.png',
    'White Knight' => 'WhiteKnight.png',
    'Ark' => 'Ark.png',
    'Blaster' => 'Blaster.png',
    'Kinesis' => 'Kinesis.png',
    'Pathfinder' => 'Pathfinder.png',
    'Shade' => 'Shade.png',
];



// Function to get job group by job ID
function getJobGroup($job) {
    global $jobGroups;
    foreach ($jobGroups as $group => $range) {
        if (in_array($job, $range)) {
            return $group;
        }
    }
    return 'Beginner'; // Default if no group is found
}

// Function to get the job icon URL
function getJobIcon($jobId) {
    global $jobIcons;
    $jobGroup = getJobGroup($jobId);
    $iconPath = 'assets/class/'; // Path where job icons are stored
    return isset($jobIcons[$jobGroup]) ? $iconPath . $jobIcons[$jobGroup] : $iconPath . 'default.png';
}

// Function to get job name
function getJobName($jobId) {
    return getJobGroup($jobId);
}

// Get the current page or set default to 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 5;
$offset = ($page - 1) * $limit;

// Handle job filter and search
$job = isset($_GET['job']) ? (int)$_GET['job'] : null;
$search = isset($_GET['search']) ? $_GET['search'] : null;

// Prepare the base query to fetch character details from characterstats table
$query = "
    SELECT cs.id AS character_id, cs.name, cs.level, cs.job, cs.skin, cs.face, cs.hair, cs.gm
    FROM characterstats cs
    WHERE cs.gm <= 1
";

// Add job filter to the query if provided
if ($job !== null) {
    $jobGroup = getJobGroup($job);
    $query .= " AND cs.job IN (" . implode(',', $jobGroups[$jobGroup]) . ")";
}

// Add search filter to the query if provided
if ($search !== null) {
    $query .= " AND cs.name LIKE :search";
}

// Order by level descending and limit the results
$query .= " ORDER BY cs.level DESC LIMIT :offset, :limit";

$stmt = $pdo->prepare($query);

if ($search !== null) {
    $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
}
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->execute();

$characters = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Prepare the result array with character data
$results = [];
foreach ($characters as $character) {
    // Fetch active items from the items table
    $itemQuery = "SELECT itemid FROM items WHERE characterid = :characterId AND invtype = -1";
    $itemStmt = $pdo->prepare($itemQuery);
    $itemStmt->execute(['characterId' => $character['character_id']]);
    $items = $itemStmt->fetchAll(PDO::FETCH_COLUMN);

    // Validate and construct the avatar URL
    $skin = (!empty($character['skin']) && $character['skin'] != 0) ? $character['skin'] : 10; // Default skin to 10
    $hair = $character['hair'] ?? 0;
    $face = $character['face'] ?? 0;
    $itemString = !empty($items) ? implode(',', array_slice($items, 0, 35)) : '';
    $avatarUrl = "https://maplestory.io/api/GMS/252/Character/animated/{$skin}/{$hair},{$face},{$itemString}/stand1/animated?showEars=False&showLefEars=False&showHighLefEars=False&padding=0&name=&renderMode=Full&bgColor=0,0,0,0";

    // Get the job icon and name
    $jobIcon = getJobIcon($character['job']);
    $jobName = getJobName($character['job']);

    // Add character data to results
    $results[] = [
        'name' => $character['name'] ?? 'Unknown',
        'level' => $character['level'] ?? 0,
        'job' => $jobName,
        'skin' => $skin,
        'face' => $face,
        'hair' => $hair,
        'avatarUrl' => $avatarUrl,
        'jobIcon' => $jobIcon,
    ];
}

// Calculate total pages for pagination
$countQuery = "SELECT COUNT(*) AS total FROM characterstats cs WHERE cs.gm <= 1";
$countStmt = $pdo->prepare($countQuery);
$countStmt->execute();
$totalCount = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
$totalPages = ceil($totalCount / $limit);

header('Content-Type: application/json');
echo json_encode(['status' => 'success', 'characters' => $results, 'totalPages' => $totalPages], JSON_UNESCAPED_SLASHES);
?>
