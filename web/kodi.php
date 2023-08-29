<?php

class KodiComm {

  private $url = null;  // kodi url
  private $debug = False;

  public function __construct($debug=False){
    include('config.php');
    $this->url = "http://" . $KODI_ADDRESS . ":" . $KODI_PORT . "/jsonrpc";
    $this->debug = $debug;
  }

  public function getMovies(){
    $result = $this->callMethod("VideoLibrary.GetMovies", array("properties"=>array("title", "year"),'sort'=>array('ignorearticle'=>true, 'order'=>'ascending', 'method'=>'title')));

    if($result['result']['limits']['total'] > 0)
    {
      return $result['result']['movies'];
    }
    else {
      return array();
    }
  }

  public function isPlaying(){
    $result = $this->callMethod("Player.GetActivePlayers");

    return count($result['result']) > 0;
  }

  public function callMethod($method, $params=array()){

    // create the JSON-RPC call
    $json_obj = array('jsonrpc'=>'2.0', 'id'=>'1', 'method'=>$method, 'params'=>$params);

    if($this->debug)
    {
      echo "<h3>JSON-RPC request:</h3>";
      echo json_encode($json_obj);
      echo "<br />";
    }

    $data_string = json_encode($json_obj);

    $ch_options = array(
      CURLOPT_VERBOSE => 0,
      CURLOPT_RETURNTRANSFER        => true,     // return web page
      CURLOPT_HEADER                => 0,    // don't return headers
      CURLOPT_HTTPHEADER            => array(
      'Content-Type: application/json',
      'Content-Length: ' . strlen($data_string)),

      CURLOPT_ENCODING            => "",       // handle all encodings
      CURLOPT_USERAGENT            => "curl/7.65.1", // who am i
      CURLOPT_POSTFIELDS            => $data_string,

    );

    $ch = curl_init( $this->url );
    curl_setopt_array( $ch, $ch_options );
    $info = curl_getinfo($ch);
    $content = curl_exec( $ch );
    $error_msg = curl_error($ch);
    curl_close($ch);

    if($this->debug)
    {
      echo "<h3>JSON-RPC response:</h3>";
      echo $content;
      echo "<br />";
    }

    return json_decode($content, true);
  }
}

?>
