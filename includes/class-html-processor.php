<?php

/**
 * HTML_Processor class
 * 
 * @since 0.1.0
 */

namespace cla_blocks\includes;

class HTML_Processor {
	/**
     * processor
     * 
     * @since 0.1.0
     * @access protected
     * @var \WP_HTML_Tag_Processor  The WP_HTML_Tag_Processor
     */
    protected $processor = null;

    /**
     * HTML_Processor constructor
     * 
     * @since 0.1.0
     * 
     * @return void
     */
    public function __construct($html) {
		$this->processor = new \WP_HTML_Tag_Processor($html);
    }



	public function __call($method, $args) {
		if (method_exists($this->processor, $method)) {
			return call_user_func_array(array($this->processor, $method), $args);
		}
	}



	/**
	 * Get a specific style property from the current tag in the WP_HTML_Tag_Processor
	 * 
	 * @since 0.1.0
	 * 
	 * @param string	$name	The name of the style property to get
	 * @return string
	 */
	public function get_style_property($name): string {
		$style = $this->processor->get_attribute('style');
		$value = '';

		if ($style) {
			$styles = $this->parse_styles($style, array());

			if (isset($styles[$name])) {
				$value = $styles[$name];
			}
		}

		return $value;
	}



	/**
	 * Parses a css properties string
	 * 
	 * @since 0.1.0
	 * 
	 * @param string	$styles		The properties string to parse
	 * @param array		$default	The default values
	 * @return array
	 */
	protected function parse_styles($styles = '', $defaults = array()): array {
		$parsed_styles = array();

		if (!empty($styles)) {
			$styles_parts = explode(';', trim($styles, ';'));

			foreach ($styles_parts as $parts) {
				$styles_property_values = explode(':', $parts);

				$parsed_styles[$styles_property_values[0]] = $styles_property_values[1];
			}
		}

		return wp_parse_args($parsed_styles, $defaults);
	}



	/**
	 * Remove a specific style property on the current tag in the WP_HTML_Tag_Processor
	 * 
	 * @since 0.1.0
	 * 
	 * @param string	$name	The name of the style property to remove
	 * @return bool
	 */
	public function remove_style_property($name) {
		$style = $this->processor->get_attribute('style');
		$new_style = '';

		if ($style) {
			$styles = $this->parse_styles($style, array());

			if (isset($styles[$name])) {
				unset($styles[$name]);
			}

			foreach ($styles as $property => $property_value) {
				$new_style .= $property . ':' . $property_value . ';';
			}

			return $this->processor->set_attribute('style', trim($new_style));
		}

		return false;
	}



	/**
	 * Set a specific style property on the current tag in the WP_HTML_Tag_Processor
	 * 
	 * @since 0.1.0
	 * 
	 * @param string	$name	The name of the style property to set
	 * @param string	$value	The value of the property to set
	 * @return bool
	 */
	public function set_style_property($name, $value): bool {
		$style = $this->processor->get_attribute('style');
		$new_style = '';

		if ($style) {
			$styles = $this->parse_styles($style, array());

			$styles[$name] = $value;

			foreach ($styles as $property => $property_value) {
				$new_style .= $property . ':' . $property_value . ';';
			}
		} else {
			$new_style = $name . ':' . $value . ';';
		}

		return $this->processor->set_attribute('style', trim($new_style));
	}
}