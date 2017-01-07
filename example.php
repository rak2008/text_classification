<?php
 
// ---------- Data ----------------
// data is taken from http://archive.ics.uci.edu/ml/datasets/SMS+Spam+Collection
// we use a part for training

$categories=[
  'سياسة' => ['وزارة', 'أمارة', 'ولى', 'ملك', 'دولى'],
  'رياضة' => ['كرة', 'كأس','دورى'],
  'علوم' => ['تقنية', 'علم', 'تكنولوجيا'],
  'اقتصاد' => ['قرض', 'بنك', 'مال'],
  'طرائف' => ['غرائب', 'نادر', 'طريف'],
  'شريعة' => ['دين', 'اسلام', 'حرم']
];

echo '<pre>';

$cat_names = array_keys($categories);

$filename = '2015-08-11.json';
$training = [];
$testing = [];

$count = 0;
$rows = json_decode(file_get_contents($filename));

$categorized = [];

foreach($rows as $row){
  $count++;

  if($count > 2){
    break;
  }	
$sum = [];
  foreach($categories as $key => $category_words){
  	$category_words [] = $key;
    $sum[$key] = 0;
  	
  	foreach($category_words as $category_word){
  	  if(substr_count($row->content, $category_word)){
  	  	$sum[$key] +=1; 
  	  }
  } 
}
//print_r($sum);
$max = max($sum);
if($max){
  $key = array_search($max, $sum);
}else{
	$key = 'أخرى';
}

  $row->categorey = $key;
  $categorized[] = $row;
}

$encoding = mb_detect_encoding($filename);

$file_name = 'categorized';
$file_name = iconv($encoding, "UTF-8", $file_name.".json");

file_put_contents($file_name, json_encode($categorized));
 print_r($categorized); exit;
