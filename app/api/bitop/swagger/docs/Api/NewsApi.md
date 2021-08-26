# Swagger\Client\NewsApi

All URIs are relative to *https://api.bitop.bmstu.ru*

Method | HTTP request | Description
------------- | ------------- | -------------
[**newsCreatePost**](NewsApi.md#newsCreatePost) | **POST** /news/create | Create news item
[**newsDeleteUuidGet**](NewsApi.md#newsDeleteUuidGet) | **GET** /news/delete/{uuid} | Delete news item
[**newsListPost**](NewsApi.md#newsListPost) | **POST** /news/list | Get news list
[**newsUpdateUuidPost**](NewsApi.md#newsUpdateUuidPost) | **POST** /news/update/{uuid} | Update news item
[**newsUuidGet**](NewsApi.md#newsUuidGet) | **GET** /news/{uuid} | Get a news


# **newsCreatePost**
> \Swagger\Client\Model\ModelNewsCreated newsCreatePost($payload)

Create news item

Create news item

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: BitopToken
$config = Swagger\Client\Configuration::getDefaultConfiguration()->setApiKey('x-bb-token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Swagger\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('x-bb-token', 'Bearer');

$apiInstance = new Swagger\Client\Api\NewsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$payload = new \Swagger\Client\Model\NewsCreateRequest(); // \Swagger\Client\Model\NewsCreateRequest | Р”Р°РЅРЅС‹Рµ Р·Р°РїСЂРѕСЃР°

try {
    $result = $apiInstance->newsCreatePost($payload);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling NewsApi->newsCreatePost: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **payload** | [**\Swagger\Client\Model\NewsCreateRequest**](../Model/NewsCreateRequest.md)| Р”Р°РЅРЅС‹Рµ Р·Р°РїСЂРѕСЃР° |

### Return type

[**\Swagger\Client\Model\ModelNewsCreated**](../Model/ModelNewsCreated.md)

### Authorization

[BitopToken](../../README.md#BitopToken)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **newsDeleteUuidGet**
> \Swagger\Client\Model\ModelNewsDeleted newsDeleteUuidGet($uuid)

Delete news item

by news uuid

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: BitopToken
$config = Swagger\Client\Configuration::getDefaultConfiguration()->setApiKey('x-bb-token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Swagger\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('x-bb-token', 'Bearer');

$apiInstance = new Swagger\Client\Api\NewsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$uuid = "uuid_example"; // string | UUID РЅРѕРІРѕСЃС‚Рё

try {
    $result = $apiInstance->newsDeleteUuidGet($uuid);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling NewsApi->newsDeleteUuidGet: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **uuid** | **string**| UUID РЅРѕРІРѕСЃС‚Рё |

### Return type

[**\Swagger\Client\Model\ModelNewsDeleted**](../Model/ModelNewsDeleted.md)

### Authorization

[BitopToken](../../README.md#BitopToken)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **newsListPost**
> \Swagger\Client\Model\ModelNewsList newsListPost($payload)

Get news list

List of university news

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: BitopToken
$config = Swagger\Client\Configuration::getDefaultConfiguration()->setApiKey('x-bb-token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Swagger\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('x-bb-token', 'Bearer');

$apiInstance = new Swagger\Client\Api\NewsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$payload = new \Swagger\Client\Model\NewsListRequest(); // \Swagger\Client\Model\NewsListRequest | Р”Р°РЅРЅС‹Рµ Р·Р°РїСЂРѕСЃР°

try {
    $result = $apiInstance->newsListPost($payload);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling NewsApi->newsListPost: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **payload** | [**\Swagger\Client\Model\NewsListRequest**](../Model/NewsListRequest.md)| Р”Р°РЅРЅС‹Рµ Р·Р°РїСЂРѕСЃР° |

### Return type

[**\Swagger\Client\Model\ModelNewsList**](../Model/ModelNewsList.md)

### Authorization

[BitopToken](../../README.md#BitopToken)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **newsUpdateUuidPost**
> \Swagger\Client\Model\ModelNewsUpdated newsUpdateUuidPost($uuid, $payload)

Update news item

Update news item

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: BitopToken
$config = Swagger\Client\Configuration::getDefaultConfiguration()->setApiKey('x-bb-token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Swagger\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('x-bb-token', 'Bearer');

$apiInstance = new Swagger\Client\Api\NewsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$uuid = "uuid_example"; // string | UUID РЅРѕРІРѕСЃС‚Рё
$payload = new \Swagger\Client\Model\NewsUpdateRequest(); // \Swagger\Client\Model\NewsUpdateRequest | Р”Р°РЅРЅС‹Рµ Р·Р°РїСЂРѕСЃР°

try {
    $result = $apiInstance->newsUpdateUuidPost($uuid, $payload);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling NewsApi->newsUpdateUuidPost: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **uuid** | **string**| UUID РЅРѕРІРѕСЃС‚Рё |
 **payload** | [**\Swagger\Client\Model\NewsUpdateRequest**](../Model/NewsUpdateRequest.md)| Р”Р°РЅРЅС‹Рµ Р·Р°РїСЂРѕСЃР° |

### Return type

[**\Swagger\Client\Model\ModelNewsUpdated**](../Model/ModelNewsUpdated.md)

### Authorization

[BitopToken](../../README.md#BitopToken)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **newsUuidGet**
> \Swagger\Client\Model\ModelNews newsUuidGet($uuid, $ignore_deferring)

Get a news

by news uuid

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: BitopToken
$config = Swagger\Client\Configuration::getDefaultConfiguration()->setApiKey('x-bb-token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Swagger\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('x-bb-token', 'Bearer');

$apiInstance = new Swagger\Client\Api\NewsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$uuid = "uuid_example"; // string | UUID РЅРѕРІРѕСЃС‚Рё
$ignore_deferring = true; // bool | Р•СЃР»Рё true - РІ РІС‹Р±РѕСЂРєСѓ РґРѕРїРѕР»РЅРёС‚РµР»СЊРЅРѕ РїРѕРїР°РґСѓС‚ РѕС‚Р»РѕР¶РµРЅРЅС‹Рµ РЅРѕРІРѕСЃС‚Рё

try {
    $result = $apiInstance->newsUuidGet($uuid, $ignore_deferring);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling NewsApi->newsUuidGet: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **uuid** | **string**| UUID РЅРѕРІРѕСЃС‚Рё |
 **ignore_deferring** | **bool**| Р•СЃР»Рё true - РІ РІС‹Р±РѕСЂРєСѓ РґРѕРїРѕР»РЅРёС‚РµР»СЊРЅРѕ РїРѕРїР°РґСѓС‚ РѕС‚Р»РѕР¶РµРЅРЅС‹Рµ РЅРѕРІРѕСЃС‚Рё | [optional]

### Return type

[**\Swagger\Client\Model\ModelNews**](../Model/ModelNews.md)

### Authorization

[BitopToken](../../README.md#BitopToken)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

