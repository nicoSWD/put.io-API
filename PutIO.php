<?php

/**
 *
 * This class enabled easy access to put.io's API (version 1)
 * See the README for detailed instructions.
 * 
 * Copyright (C) 2012  Nicolas Oelgart

 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
**/

class PutIO
{
    
    /**
     * Holds your private API key. Can be found at: https://put.io/user/settings
     *
    **/
    protected $API_KEY     = '';
    
    /**
     * Holds your private API secret. Can also be found at: https://put.io/user/settings
     *
    **/
    protected $API_SECRET  = '';
    
    /**
     * Holds the cURL handle.
     *
    **/
    protected $ch          = null;
    
    /**
     * Holds the current class name, e.g. 'user', 'files', 'messages', etc...
     * This variable is set via the magic __get() method: $putIO->user
     *
    **/
    protected $class       = null;
    
    /**
     * Holds the main URL to the API provider. This should never change.
     *
    **/
    const API_URL          = 'http://api.put.io/v1/';
    
    /**
     * Current version of the class.
     *
    **/
    const CLASS_VERSION    = '1.0';
    
    
    /**
     * Class constructor with optional put.io credentials. 
     *
    **/
    public function __construct($APIKey = null, $APISecret = null)
    {
        if (isset($APIKey, $APISecret))
        {
            $this->API_KEY = $APIKey;
            $this->API_SECRET = $APISecret;
        }
    }
    
    
    /**
     * Magically sets the class name for easy access. E.g.: $putIO->user->info();
     *
    **/
    public function __get($name)
    {
        if (!in_array($name, ['files', 'messages', 'transfers', 'urls', 'user', 'subscriptions'], true))
        {
            throw new PutIOInvalidClassException("Invalid class '{$name}' supplied.");
        }
        
        $this->class = $name;
        return $this;
    }
    
    
    /**
     * Magically sets the class method, makes a request to put.io, and returns the respose, as array.
     *
    **/
    public function __call($name, array $params = [])
    {
        if (!$response = $this->HttpRequest($name, $params))
        {
            throw new PutIONoResponseException('Got no response from server.');    
        }
        
        return $response;
    }
    
    /**
     * Makes HTTP requests to put.io with the supplied parameters and returns the response.
     *
    **/
    protected function HttpRequest($method, array $params)
    {
        if (!isset($this->class))
        {
            throw new PutIOMissingClassException('No class specified.');
        }
        
        if (!isset($this->ch))
        {
            $this->ch = curl_init();
        
            curl_setopt_array($this->ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_USERAGENT      => 'nicoswd-putIO/' . static::CLASS_VERSION,
                CURLOPT_HTTPHEADER     => ['Accept: application/json']
            ]);
        }
        
        $params = $params ? $params[0] : [];
        $URL  = static::API_URL . $this->class . '?method=' . $method;
        $data = json_encode(['api_key' => $this->API_KEY, 'api_secret' => $this->API_SECRET, 'params' => $params], JSON_FORCE_OBJECT);
        
        curl_setopt_array($this->ch, [
            CURLOPT_URL        => $URL,
            CURLOPT_POSTFIELDS => "request={$data}"
        ]);
        
        if ($response = curl_exec($this->ch) AND ($response = json_decode($response, true)) !== null)
        {
            if (!empty($response['error']))
            {
                throw new PutIOErrorException($response['error_message']);
            }
            
            return $response;
        }
        
        return '';
    }
    
    
    /**
     * Sets the API key, in case you don't want to do it in the constructor.
     *
    **/
    public function setAPIKey($key)
    {
        $this->API_KEY = $key;
    }
    
    
    /**
     * Sets the API secret, for the same reason as above.
     *
    **/
    public function setAPISecret($secret)
    {
        $this->API_SECRET = $secret;
    }
}


class PutIOInvalidClassException extends \Exception {}
class PutIOMissingClassException extends \Exception {}
class PutIONoResponseException extends \Exception {}
class PutIOErrorException extends \Exception {}

?>