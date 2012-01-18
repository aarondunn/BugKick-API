<?php
require_once('BugKickException.php');
require_once('BugKickApi.php');
require_once('TicketType.php');
require_once('UserAgent.php');
/**
 * BugKick
 *
 * @author Evgeniy `f0t0n` Naydenov
 * @copyright BugKick
 */
class BugKick implements BugKickApi {
	
	protected static $_instance=null;
	protected $apiKey;
	protected $projectID;
	protected $requestError;
	protected $curlOptions;
	
	protected function __construct() {
		$this->init();
	}
	
	protected function init() {
		$this->apiKey=null;
		$this->projectID=null;
		$this->requestError='';
		$this->curlOptions=array(
			CURLOPT_URL=>self::API_URL,
			CURLOPT_POST=>true,
			CURLOPT_USERAGENT=>UserAgent::get(),
			CURLOPT_RETURNTRANSFER=>true,
		);
	}
	
	/**
	 * Returns a singleton instance of BugKick class.
	 * @return BugKick
	 */
	public static function api() {
		if(self::$_instance===null) {
			self::$_instance=new BugKick();
		}
		return self::$_instance;
	}
	
	public function setApiKey($apiKey) {
		$this->apiKey=$apiKey;
	}
	
	public function selectProject($projectID) {
		$this->projectID=$projectID;
	}
	
	public function resetProject() {
		$this->projectID=null;
	}
	
	public function getRequestError() {
		return $this->requestError;
	}
	
	/**
	 *
	 * @param string $ticketText
	 * @param string $ticketType Use the TicketType interface's constants <br />
	 * to set the valid type of ticket.
	 * @return string json formatted response object <br />
	 * with properties "error" and "success". <br />
	 * If the success property is equal to TRUE, <br />
	 * check the text from "error" property for more information.
	 */
	public function createTicket($ticketText, $ticketType) {
		return $this->makeCall(
			array(
				'ticketText'=>$ticketText,
				'ticketType'=>$ticketType,
				'method'=>'createTicket',
			)
		);
	}
	
	protected function prepareRequestData(array $data) {
		$credentials=array('apiKey'=>$this->apiKey);
		if(!empty($this->projectID)) {
			$credentials['projectID']=$this->projectID;
		}
		return array_merge($data, $credentials);
	}
	
	protected function makeCall(array $data) {
		$reqData=array('apiCall'=>$this->prepareRequestData($data));
		$ch=curl_init(self::API_URL);
		$this->curlOptions[CURLOPT_POSTFIELDS]=http_build_query($reqData, null, '&');
		$isSet=curl_setopt_array($ch, $this->curlOptions);
		$this->requestError=curl_error($ch);
		$response=curl_exec($ch);
		curl_close($ch);
		return $response;
	}
}