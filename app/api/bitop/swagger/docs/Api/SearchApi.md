# Swagger\Client\SearchApi

All URIs are relative to *https://api.bitop.bmstu.ru*

Method | HTTP request | Description
------------- | ------------- | -------------
[**searchUnitPost**](SearchApi.md#searchUnitPost) | **POST** /search/unit | Search within units


# **searchUnitPost**
> \Swagger\Client\Model\ModelSearchUnitList searchUnitPost($payload)

Search within units

search in parts of university (units and subdivisions)

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: BitopToken
$config = Swagger\Client\Configuration::getDefaultConfiguration()->setApiKey('x-bb-token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Swagger\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('x-bb-token', 'Bearer');

$apiInstance = new Swagger\Client\Api\SearchApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$payload = new \Swagger\Client\Model\SearchUnitRequest(); // \Swagger\Client\Model\SearchUnitRequest | Search Units

try {
    $result = $apiInstance->searchUnitPost($payload);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling SearchApi->searchUnitPost: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **payload** | [**\Swagger\Client\Model\SearchUnitRequest**](../Model/SearchUnitRequest.md)| Search Units |

### Return type

[**\Swagger\Client\Model\ModelSearchUnitList**](../Model/ModelSearchUnitList.md)

### Authorization

[BitopToken](../../README.md#BitopToken)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

