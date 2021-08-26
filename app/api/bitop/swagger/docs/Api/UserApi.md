# Swagger\Client\UserApi

All URIs are relative to *https://api.bitop.bmstu.ru*

Method | HTTP request | Description
------------- | ------------- | -------------
[**userInfoByTicketTicketGet**](UserApi.md#userInfoByTicketTicketGet) | **GET** /user/info/by-ticket/{ticket} | User info by Ticket
[**userInfoByUuidUuidGet**](UserApi.md#userInfoByUuidUuidGet) | **GET** /user/info/by-uuid/{uuid} | User info by UUID
[**userLoginGet**](UserApi.md#userLoginGet) | **GET** /user/login | Redirect user to bmstu CAS auth form


# **userInfoByTicketTicketGet**
> \Swagger\Client\Model\ModelUser userInfoByTicketTicketGet($ticket)

User info by Ticket

Retrieve user info using disposable ticket received after /user/login

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: BitopToken
$config = Swagger\Client\Configuration::getDefaultConfiguration()->setApiKey('x-bb-token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Swagger\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('x-bb-token', 'Bearer');

$apiInstance = new Swagger\Client\Api\UserApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$ticket = "ticket_example"; // string | ticket in spec format, e.g. 'bb-us-123456-ff99bb11'

try {
    $result = $apiInstance->userInfoByTicketTicketGet($ticket);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling UserApi->userInfoByTicketTicketGet: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **ticket** | **string**| ticket in spec format, e.g. &#39;bb-us-123456-ff99bb11&#39; |

### Return type

[**\Swagger\Client\Model\ModelUser**](../Model/ModelUser.md)

### Authorization

[BitopToken](../../README.md#BitopToken)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **userInfoByUuidUuidGet**
> \Swagger\Client\Model\ModelUser userInfoByUuidUuidGet($uuid)

User info by UUID

Retrieve user info using cas UUID

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: BitopToken
$config = Swagger\Client\Configuration::getDefaultConfiguration()->setApiKey('x-bb-token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Swagger\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('x-bb-token', 'Bearer');

$apiInstance = new Swagger\Client\Api\UserApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$uuid = "uuid_example"; // string | uuid, e.g 00000000-0000-0000-0000-000000000000

try {
    $result = $apiInstance->userInfoByUuidUuidGet($uuid);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling UserApi->userInfoByUuidUuidGet: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **uuid** | **string**| uuid, e.g 00000000-0000-0000-0000-000000000000 |

### Return type

[**\Swagger\Client\Model\ModelUser**](../Model/ModelUser.md)

### Authorization

[BitopToken](../../README.md#BitopToken)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **userLoginGet**
> userLoginGet($redirect_uri, $bb_app_id)

Redirect user to bmstu CAS auth form

Open this url with parameters

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$apiInstance = new Swagger\Client\Api\UserApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$redirect_uri = "redirect_uri_example"; // string | Callback URI
$bb_app_id = 56; // int | BITOP App ID

try {
    $apiInstance->userLoginGet($redirect_uri, $bb_app_id);
} catch (Exception $e) {
    echo 'Exception when calling UserApi->userLoginGet: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **redirect_uri** | **string**| Callback URI |
 **bb_app_id** | **int**| BITOP App ID |

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

