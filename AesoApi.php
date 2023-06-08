<?php
/**
 * AESO API Client
 * 
 * This class provides methods to interact with the AESO (Alberta Electric System Operator) API.
 * It encapsulates API requests and handles HTTP responses.
 *
 * @package 		AESO API Client
 * @version 		1.0.0
 * @date 			2023-06-08
 * @author 		A.P. Rose
 * @link 			https://github.com/ap-rose/aeso-api-client
 * @source 		https://api.aeso.ca/web/api/ets
 *
 */
class AesoApi {
    private static $apiUrl = 'https://api.aeso.ca/report/'; // Base URL for the AESO API
    private $headers; // Holds the API headers

    public function __construct($apiKey) {
        $this->headers = [
            'X-Api-Key: ' . $apiKey, // Set the API key header
        ];
    }
    /**
     * Sends an HTTP GET request to the API.
     * @param string $endpoint The API endpoint to request.
     * @param array $params The query parameters for the request.
     * @return mixed The parsed JSON response.
     * @throws Exception If an error occurs during the request.
     */
    public function get($endpoint, $params) {
        $url = self::$apiUrl . $endpoint . '?' . http_build_query($params);
        $ch = curl_init();

        // Set the cURL options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute the request
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Close the cURL session
        curl_close($ch);

        // Check the HTTP status code and handle the response accordingly
        if ($httpcode >= 200 && $httpcode < 300) {
            return json_decode($response, true); // Decode and return the JSON response
        } else {
            switch ($httpcode) {
                case 400:
                    throw new Exception('Bad Request');
                    break;
                case 401:
                    throw new Exception('Unauthorized');
                    break;
                case 403:
                    throw new Exception('Forbidden');
                    break;
                case 404:
                    throw new Exception('Not Found');
                    break;
                case 405:
                    throw new Exception('Invalid Method');
                    break;
                case 500:
                    throw new Exception('Internal Server Error');
                    break;
                case 503:
                    throw new Exception('Service Unavailable');
                    break;
                default:
                    throw new Exception('Unknown error');
            }
        }
    }
    /**
     * Fetches the pool price report.
     * @param array $params The query parameters for the report.
     * @return mixed The parsed JSON response.
     */
    public function fetchPoolPriceReport($params) {
        return $this->get('/v1.1/price/poolPrice', $params);
    }

    /**
     * Fetches the system marginal price report.
     * @param array $params The query parameters for the report.
     * @return mixed The parsed JSON response.
     */
    public function fetchSystemMarginalPriceReport($params) {
        return $this->get('/v1.1/price/systemMarginalPrice', $params);
    }

    /**
     * Fetches the current active system marginal price.
     * @return mixed The parsed JSON response.
     */
    public function fetchActiveSystemMarginalPrice() {
        return $this->get('/v1.1/price/systemMarginalPrice/current', []);
    }

    /**
     * Fetches the list of pool participants.
     * @return mixed The parsed JSON response.
     */
    public function fetchPoolParticipantsList() {
        return $this->get('/v1/poolparticipantlist', []);
    }

    /**
     * Fetches the operating reserve offer control report.
     * @param array $params The query parameters for the report.
     * @return mixed The parsed JSON response.
     */
    public function fetchOperatingReserveOfferControlReport($params) {
        return $this->get('/v1/operatingReserveOfferControl', $params);
    }

    /**
     * Fetches metered volume data.
     * @param array $params The query parameters for the data.
     * @return mixed The parsed JSON response.
     */
    public function fetchMeteredVolumeData($params) {
        return $this->get('/v1/meteredvolume/details', $params);
    }

    /**
     * Fetches the energy merit order report.
     * @param array $params The query parameters for the report.
     * @return mixed The parsed JSON response.
     */
    public function fetchEnergyMeritOrderReport($params) {
        return $this->get('/v1/meritOrder/energy', $params);
    }

    /**
     * Fetches the actual forecast report.
     * @param array $params The query parameters for the report.
     * @return mixed The parsed JSON response.
     */
    public function fetchActualForecastReport($params) {
        return $this->get('/v1/load/albertaInternalLoad', $params);
    }

    /**
     * Fetches the latest supply-demand summary.
     * @return mixed The parsed JSON response.
     */
    public function fetchLatestSupplyDemandSummary() {
        return $this->get('/v1/csd/summary/current', []);
    }

    /**
     * Fetches the latest generation data.
     * @return mixed The parsed JSON response.
     */
    public function fetchLatestGenerationData() {
        return $this->get('/v1/csd/generation/assets/current', []);
    }

    /**
     * Fetches the asset list.
     * @return mixed The parsed JSON response.
     */
    public function fetchAssetList() {
        return $this->get('/v1/assetlist', []);
    }
}

?>
