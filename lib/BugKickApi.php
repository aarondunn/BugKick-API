<?php
/**
 * @author Evgeniy `f0t0n` Naydenov
 * @copyright BugKick
 */
interface BugKickApi {
	const API_URL='https://bugkick.com/api';
	public static function api();
	public function setApiKey($apiKey);
	public function selectProject($projectID);
	public function resetProject();
	public function getRequestError();
	public function createTicket($ticketText, $ticketType);
}