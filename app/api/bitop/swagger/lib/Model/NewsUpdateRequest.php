<?php
/**
 * NewsUpdateRequest
 *
 * PHP version 5
 *
 * @category Class
 * @package  Swagger\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * BITOP
 *
 * Bmstu Open IT Platform
 *
 * OpenAPI spec version: 1.0
 * Contact: i@spatecon.ru
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 * Swagger Codegen version: 2.4.21
 */

/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace Swagger\Client\Model;

use \ArrayAccess;
use \Swagger\Client\ObjectSerializer;

/**
 * NewsUpdateRequest Class Doc Comment
 *
 * @category Class
 * @package  Swagger\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class NewsUpdateRequest implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'news.updateRequest';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'action_type' => 'string',
        'action_value' => 'string',
        'author' => 'string',
        'detail_description' => 'string',
        'detail_picture_url' => 'string',
        'preview_description' => 'string',
        'preview_picture_url' => 'string',
        'published' => 'string',
        'title' => 'string'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'action_type' => null,
        'action_value' => null,
        'author' => null,
        'detail_description' => null,
        'detail_picture_url' => null,
        'preview_description' => null,
        'preview_picture_url' => null,
        'published' => null,
        'title' => null
    ];

    /**
     * Array of property to type mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerTypes()
    {
        return self::$swaggerTypes;
    }

    /**
     * Array of property to format mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerFormats()
    {
        return self::$swaggerFormats;
    }

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @var string[]
     */
    protected static $attributeMap = [
        'action_type' => 'action_type',
        'action_value' => 'action_value',
        'author' => 'author',
        'detail_description' => 'detail_description',
        'detail_picture_url' => 'detail_picture_url',
        'preview_description' => 'preview_description',
        'preview_picture_url' => 'preview_picture_url',
        'published' => 'published',
        'title' => 'title'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'action_type' => 'setActionType',
        'action_value' => 'setActionValue',
        'author' => 'setAuthor',
        'detail_description' => 'setDetailDescription',
        'detail_picture_url' => 'setDetailPictureUrl',
        'preview_description' => 'setPreviewDescription',
        'preview_picture_url' => 'setPreviewPictureUrl',
        'published' => 'setPublished',
        'title' => 'setTitle'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'action_type' => 'getActionType',
        'action_value' => 'getActionValue',
        'author' => 'getAuthor',
        'detail_description' => 'getDetailDescription',
        'detail_picture_url' => 'getDetailPictureUrl',
        'preview_description' => 'getPreviewDescription',
        'preview_picture_url' => 'getPreviewPictureUrl',
        'published' => 'getPublished',
        'title' => 'getTitle'
    ];

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @return array
     */
    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @return array
     */
    public static function setters()
    {
        return self::$setters;
    }

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @return array
     */
    public static function getters()
    {
        return self::$getters;
    }

    /**
     * The original name of the model.
     *
     * @return string
     */
    public function getModelName()
    {
        return self::$swaggerModelName;
    }

    

    

    /**
     * Associative array for storing property values
     *
     * @var mixed[]
     */
    protected $container = [];

    /**
     * Constructor
     *
     * @param mixed[] $data Associated array of property values
     *                      initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->container['action_type'] = isset($data['action_type']) ? $data['action_type'] : 'None';
        $this->container['action_value'] = isset($data['action_value']) ? $data['action_value'] : null;
        $this->container['author'] = isset($data['author']) ? $data['author'] : null;
        $this->container['detail_description'] = isset($data['detail_description']) ? $data['detail_description'] : null;
        $this->container['detail_picture_url'] = isset($data['detail_picture_url']) ? $data['detail_picture_url'] : null;
        $this->container['preview_description'] = isset($data['preview_description']) ? $data['preview_description'] : null;
        $this->container['preview_picture_url'] = isset($data['preview_picture_url']) ? $data['preview_picture_url'] : null;
        $this->container['published'] = isset($data['published']) ? $data['published'] : null;
        $this->container['title'] = isset($data['title']) ? $data['title'] : null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        if ($this->container['preview_description'] === null) {
            $invalidProperties[] = "'preview_description' can't be null";
        }
        if ($this->container['title'] === null) {
            $invalidProperties[] = "'title' can't be null";
        }
        return $invalidProperties;
    }

    /**
     * Validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properties are valid
     */
    public function valid()
    {
        return count($this->listInvalidProperties()) === 0;
    }


    /**
     * Gets action_type
     *
     * @return string
     */
    public function getActionType()
    {
        return $this->container['action_type'];
    }

    /**
     * Sets action_type
     *
     * @param string $action_type ???????????? ????????????????????????????????????????????????????????????? ?????????????????????????????????? ?????????????????????????????. None - ?????????????????????????. Url - ????????????????????????? ???????????? ???????????????????????????????????. Schedule - ???????????????????????????????????????? ????????????????????????? ???????????? ?????????????????????????????????????.
     *
     * @return $this
     */
    public function setActionType($action_type)
    {
        $this->container['action_type'] = $action_type;

        return $this;
    }

    /**
     * Gets action_value
     *
     * @return string
     */
    public function getActionValue()
    {
        return $this->container['action_value'];
    }

    /**
     * Sets action_value
     *
     * @param string $action_value Payload ???????????? ???????????? ??????????????????????????????????.
     *
     * @return $this
     */
    public function setActionValue($action_value)
    {
        $this->container['action_value'] = $action_value;

        return $this;
    }

    /**
     * Gets author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->container['author'];
    }

    /**
     * Sets author
     *
     * @param string $author ????????????????????? ?????????????????????????????, ???????????????????????????????? ????????????.
     *
     * @return $this
     */
    public function setAuthor($author)
    {
        $this->container['author'] = $author;

        return $this;
    }

    /**
     * Gets detail_description
     *
     * @return string
     */
    public function getDetailDescription()
    {
        return $this->container['detail_description'];
    }

    /**
     * Sets detail_description
     *
     * @param string $detail_description ?????????????????????????????????????? ???????????????????????????????? ?????????????????????????????.
     *
     * @return $this
     */
    public function setDetailDescription($detail_description)
    {
        $this->container['detail_description'] = $detail_description;

        return $this;
    }

    /**
     * Gets detail_picture_url
     *
     * @return string
     */
    public function getDetailPictureUrl()
    {
        return $this->container['detail_picture_url'];
    }

    /**
     * Sets detail_picture_url
     *
     * @param string $detail_picture_url URL ????????????????????????????????? ???????????? ????????????????????????? ???? ????????????????????????? ???????????????????????????????????? ?????????????????????????????.
     *
     * @return $this
     */
    public function setDetailPictureUrl($detail_picture_url)
    {
        $this->container['detail_picture_url'] = $detail_picture_url;

        return $this;
    }

    /**
     * Gets preview_description
     *
     * @return string
     */
    public function getPreviewDescription()
    {
        return $this->container['preview_description'];
    }

    /**
     * Sets preview_description
     *
     * @param string $preview_description ????????????????????????????? ???????????????????????????????? ?????????????????????????????.
     *
     * @return $this
     */
    public function setPreviewDescription($preview_description)
    {
        $this->container['preview_description'] = $preview_description;

        return $this;
    }

    /**
     * Gets preview_picture_url
     *
     * @return string
     */
    public function getPreviewPictureUrl()
    {
        return $this->container['preview_picture_url'];
    }

    /**
     * Sets preview_picture_url
     *
     * @param string $preview_picture_url URL ????????????????????????????????? ???????????? ????????????????????????? ???? ????????????????????????????? ???????????????????????????????????? ?????????????????????????????.
     *
     * @return $this
     */
    public function setPreviewPictureUrl($preview_picture_url)
    {
        $this->container['preview_picture_url'] = $preview_picture_url;

        return $this;
    }

    /**
     * Gets published
     *
     * @return string
     */
    public function getPublished()
    {
        return $this->container['published'];
    }

    /**
     * Sets published
     *
     * @param string $published ?????????????????? ???? ???????????????????? ????????????????????????????????????????? ?????????????????????????????. ???????????????????? ????????????????????? ???????????????????????????? ????????????????????????????? ????????????????????? ????????????????????????????????? ???????? ???????????? ??????????????????????????????????????????????? ?????????????????????????????. ????????????????????????? ????????????????????????? RFC3339.
     *
     * @return $this
     */
    public function setPublished($published)
    {
        $this->container['published'] = $published;

        return $this;
    }

    /**
     * Gets title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->container['title'];
    }

    /**
     * Sets title
     *
     * @param string $title ????????????????????????????????????? ?????????????????????????????.
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->container['title'] = $title;

        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     *
     * @param integer $offset Offset
     *
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     *
     * @param integer $offset Offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    /**
     * Sets value based on offset.
     *
     * @param integer $offset Offset
     * @param mixed   $value  Value to be set
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     *
     * @param integer $offset Offset
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * Gets the string presentation of the object
     *
     * @return string
     */
    public function __toString()
    {
        if (defined('JSON_PRETTY_PRINT')) { // use JSON pretty print
            return json_encode(
                ObjectSerializer::sanitizeForSerialization($this),
                JSON_PRETTY_PRINT
            );
        }

        return json_encode(ObjectSerializer::sanitizeForSerialization($this));
    }
}


