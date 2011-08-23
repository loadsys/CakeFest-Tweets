<?php

/**
 * Loadsys_Social_Twitter_Search class.
 * 
 */
class TwitterSearch {
	
	/**
	 * The base url for the Twitter search api.
	 * 
	 * (default value: 'http://search.twitter.com/search')
	 * 
	 * @var string
	 * @access public
	 */
	public $baseUrl = 'http://search.twitter.com/search';
	
	/**
	 * The data type for the response from the Twitter search api.
	 * Defaults to 'json', but can also be 'atom'.
	 * 
	 * (default value: 'json')
	 * 
	 * @var string
	 * @access public
	 */
	public $type = 'json';
	
	/**
	 * This is a boolean value that is used in the search method to
	 * determine how the returned Twitter data (if it is json) will 
	 * be decoded. If set to true (default), the data will be decoded
	 * to an associative array. If false, data will be decoded to 
	 * a std object.
	 * 
	 * (default value: true)
	 * 
	 * @var bool
	 * @access public
	 */
	public $decodeType = true;
	
	/**
	 * An array list of available search options that can be set. Other options
	 * that do not exist in this array will not be set to the search options
	 * property.
	 * 
	 * @var array
	 * @access public
	 */
	public $__options = array(
		'callback',
		'lang',
		'locale',
		'max_id',
		'q',
		'rpp',
		'page',
		'since',
		'since_id',
		'geocode',
		'show_user',
		'until',
		'result_type'
	);
	
	/**
	 * Array of valid options that will be used to create the final url
	 * sent to Twitter.
	 * 
	 * (default value: array())
	 * 
	 * @var array
	 * @access public
	 */
	public $searchOptions = array();
	
	/**
	 * Constructor method that allows the overwritting of the data type returned
	 * from Twitter, the search term used in the url, and the decode type used
	 * when decoding the response.
	 * 
	 * @access public
	 * @param mixed $type. (default: null)
	 * @param mixed $term. (default: null)
	 * @param bool $decodeType. (default: true)
	 * @return void
	 */
	public function __construct($type = null, $term = null, $decodeType = true) {
		if ($type) {
			$this->type = $type;
		}
		if ($term) {
			$this->searchOptions['q'] = $term;
		}
		$this->decodeType = $decodeType;
	}
	
	/**
	 * Set a single option to the searchOptions property.
	 * 
	 * @access public
	 * @param string $option
	 * @param string $value
	 * @return boolean
	 */
	public function setOption($option, $value) {
		if ($option && $value) {
			if (in_array($option, $this->__options)) {
				$this->searchOptions[$option] = $value;
			}
		} else {
			return false;
		}
		return true;
	}
	
	/**
	 * Set multiple options to the searchOptions property.
	 * 
	 * @access public
	 * @param array $options
	 * @return true
	 */
	public function setOptions($options) {
		if (is_array($options)) {
			foreach ($options as $option => $value) {
				$this->setOption($option, $value);
			}
		} else {
			return false;
		}
		return true;
	}
	
	/**
	 * getOption function.
	 * 
	 * @access public
	 * @param string $option
	 * @return mixed
	 */
	public function getOption($option) {
		if(array_key_exists($option, $this->searchOptions)) {
			return $this->searchOptions[$option];
		}
		return false;
	}
	
	/**
	 * search function.
	 * 
	 * @access public
	 * @param array $options
	 * @return mixed
	 */
	public function search($options = array()) {
		if (!empty($options)) {
			$this->setOptions($options);
		}
		
		$search = $this->baseUrl;
		$search = $search.'.'.$this->type;
		
		if (!empty($this->searchOptions)) {
			$search = $search.'?';
			foreach ($this->searchOptions as $option => $value) {
				$search = $search.$option.'='.$value.'&';
			}
			$search = substr($search, 0, strlen($search) - 1);
		}
		
		$data = file_get_contents($search);
		$data = json_decode($data, $this->decodeType);
		
		return $data;
	}
}

?>