# Swagger\Client\ScheduleApi

All URIs are relative to *https://api.bitop.bmstu.ru*

Method | HTTP request | Description
------------- | ------------- | -------------
[**scheduleUuidGet**](ScheduleApi.md#scheduleUuidGet) | **GET** /schedule/{uuid} | Get a schedule


# **scheduleUuidGet**
> \Swagger\Client\Model\ModelSchedule scheduleUuidGet($uuid)

Get a schedule

by schedule uuid

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: BitopToken
$config = Swagger\Client\Configuration::getDefaultConfiguration()->setApiKey('x-bb-token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Swagger\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('x-bb-token', 'Bearer');

$apiInstance = new Swagger\Client\Api\ScheduleApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$uuid = "uuid_example"; // string | Schedule UUID

try {
    $result = $apiInstance->scheduleUuidGet($uuid);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ScheduleApi->scheduleUuidGet: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **uuid** | **string**| Schedule UUID |

### Return type

[**\Swagger\Client\Model\ModelSchedule**](../Model/ModelSchedule.md)

### Authorization

[BitopToken](../../README.md#BitopToken)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

