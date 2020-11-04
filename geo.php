<?php

$fh = fopen('hamRecCenter.csv.txt','r');

$recArray = array();
echo "<pre>";
while (!feof($fh))
{
  $name = fgets($fh);
  $addrData = fgetcsv($fh);
  print_r( $addrData);// . "\n";
  $addrToCheck = urlencode(trim($addrData[0]) . ",Hamilton,Ontario,Canada");
  echo $name . "\n";
  
  echo $addrToCheck . "\n";
  
  // Note: you will need to get your own Bing Maps API key at the following URL...
  // https://www.bingmapsportal.com/
  // You'll need to Sign In with a Microsoft Account (or create one and then sign in),
  // and then you need to make an application to get an API key to include.
  $xmlFile = file_get_contents("http://dev.virtualearth.net/REST/v1/Locations?o=xml&q=$addrToCheck&key=AiJe5h9_WGxaZZgmLmr1QU31ZFnvracrMwt7eT3x3J0NE91pP_tGBwzIBuPNYHu9");
  $data = new SimpleXMLElement($xmlFile);

  $long = (string) $data->ResourceSets->ResourceSet->Resources->Location->Point->Longitude;
  $lat = (string) $data->ResourceSets->ResourceSet->Resources->Location->Point->Latitude;
  echo "Lat is " . $lat;
  
  
  
  $recArray[] = 
    array('name' => trim($name),
  	      'address' => trim($addrData[0]),
  	      'city' => trim($addrData[1]),
  	      'phone' => trim($addrData[3]),
  	      'latitude' => $lat,
  	      'longtitude' => $long
  	     );
 
}
print_r($recArray);
//echo 'var listRecs = ' . json_encode($recArray) . ';';
//$jsPropertyMap = json_encode($recArray); 
//$jsPropertyMap = "recCenters = " . $jsPropertyMap ;
file_put_contents('geo03_propertyMap.js','var listRecs = ' . json_encode($recArray) . ';');
?>