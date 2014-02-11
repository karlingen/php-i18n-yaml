<?php
/**
 * php-i18n-yaml
 *
 * I18N class for translating text to any language
 * Uses YAML files
 *
 * 	Usage: I18N::t("user.name")  # =>  "Karl Metum"
 *	In the above example "name" is nested under "user"
 *
 * Make sure that the following constants are set in
 * your environment somehow:
 *
 *	- DEFAULT_LOCALE = ""
 *	- DIR_LOCALE = "" 	# full path to your locales
 *
 * @author Karl Metum <karlo.m@gmail.com>
 * @link https://github.com/karlingen/php-i18n-yaml
 */
class I18N
{
	/**
	 * Holds the current locale
	 */
	private $locale;

	/**
	 * Holds the character which terms are seperated by
	 */
	private $term_separator = ".";

	/**
	 * Main construct
	 * @param locale
	 */
	public function __construct($locale=null)
	{
		$this->set_locale($locale);
	}

	/**
	 * Sets the current locale
	 */
	private function set_locale($locale=null)
	{
		$locale=is_null($locale) ? DEFAULT_LOCALE : $locale;
		$this->locale = $locale;
	}

	/**
	 * Gets current locale
	 */
	private function get_locale()
	{
		return $this->locale;
	}

	/**
	 * Translates given term
	 */
	public function _translate($term)
	{
		$path=$this->build_file_path();
		$yaml_parsed=yaml_parse_file($path);

		return $this->find($term, $yaml_parsed);
	}

	/**
	 * Finds given term inside given yaml-parsed array
	 * @param string, the text to examine and look for
	 * @param array, yaml parsed data
	 */
	private function find($term, Array $yaml_data)
	{
		$locale=$this->get_locale();
		if(!empty($yaml_data[$locale]))
		{
			$yaml_data_last=$yaml_data[$locale];
			$terms=explode($this->term_separator, $term);
			foreach($terms as $keyword)
			{
				if(empty($yaml_data_last[$keyword]))
					return "Translation missing for {$locale}#{$term}";

				$yaml_data_last=$yaml_data_last[$keyword];
			}

			return $yaml_data_last;
		}

		return "Translation missing for {$locale}";
	}

	private function build_file_path()
	{
		return DIR_LOCALE.$this->get_locale().".yml";
	}

	/**
	 * Translates given term
	 * @param string, the translation term
	 * @param string, (optional) the language which the term
	 *	 should be translated into.
	 */
	public static function translate($term,$locale=null)
	{
		$i18n = new self($locale);
		return $i18n->_translate($term);
	}

	/**
	 * Alias for @translate
	 */
	public static function t($term,$locale=null)
	{
		return self::translate($term,$locale);
	}
}