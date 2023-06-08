# AESO API Client

The AESO API Client is a PHP library that provides convenient methods for interacting with the AESO (Alberta Electric System Operator) API. It allows you to fetch data related to energy pricing, system marginal price, pool participants, and more.

## Usage

1. Include the `AesoApi.php` file in your project:
```php
require_once 'AesoApi.php';
$apiKey = 'your-aeso-api-key';
$aesoApi = new AesoApi($apiKey);
```

2. Make API calls to retrieve the desired data. For example, to fetch the pool price report:
```php
$params = [
    // Specify any required parameters for the report
    'start_date' => '2023-06-01',
    'end_date' => '2023-06-07',
];

try {
    $poolPriceReport = $aesoApi->fetchPoolPriceReport($params);
    // Process the response data as needed
    // ...
} catch (Exception $e) {
    // Handle any exceptions or errors that occurred
    // ...
}
```

3. Explore the available methods in the AesoApi class to access different API endpoints and retrieve specific data.

## Contributing
Contributions are welcome! If you find any issues or have suggestions for improvements, please create a new issue or submit a pull request.