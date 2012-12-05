<?php
namespace Mouf\Utils\Network\Http\CurlHtmlBrowser;

/**
 * This class represents a web page loaded via the CurlHTMLBrowser.
 * Using this class, you can easily query the content of the page, using XPath.
 * 
 * @Component
 */
class CurlHTMLPage {
	
	/**
	 * The content of the page, as a string.
	 * 
	 * @var string
	 */
	private $text;
	
	/**
	 * The infos relative to the response headers.
	 * 
	 * @var array
	 */
	private $info;
	
	/**
	 * The page as a XML node.
	 * 
	 * @var DOMDocument
	 */
	private $htmlDoc;
	
	/**
	 * The object to perform XPath queries on the DOM
	 * 
	 * @var DOMXPath
	 */
	private $domXPath;
	
	/**
	 * The URL that was accessed to generate this page.
	 * 
	 * @var string
	 */
	private $url;
	
	public function __construct($text, $info, $url) {
		$this->text = $text;
		$this->info = $info;
		$this->url = $url;
	}
	
	/**
	 * Returns the HTML of the page, as a string.
	 * 
	 * @return string
	 */
	public function getHTML() {
		return $this->text;
	}
	
	/**
	 * Returns the info of the page, as an array.
	 * 
	 * @param string $key
	 * @return array or string
	 */
	public function getInfo($key = null) {
		if($key && isset($this->info[$key]))
			return $this->info[$key];
		else
			return $this->info;
	}
	
	/**
	 * Returns the HTML of the page as a DOM Document.
	 * @return DOMDocument
	 */
	public function getHTMLDocObject() {
		if ($this->htmlDoc == null) {
			$this->htmlDoc = new DOMDocument();
			// TODO: sauvegarder les warning et les afficher quelque part (dans les logs?)
			@$this->htmlDoc->loadHTML($this->text);
		}
		return $this->htmlDoc;
	}
	
	/**
	 * Returns the HTML of the page as a DOM Document.
	 * @return DOMXPath
	 */
	protected function getHTMLDOMXPath() {
		if ($this->domXPath == null) {
			$this->domXPath = new DOMXpath($this->getHTMLDocObject());
		}
		return $this->domXPath;
	}
	
	/**
	 * Peforms an XPath query on the page and returns a node list.
	 * @param string $query
	 * @return DOMNodeList
	 */
	public function xpathQuery($query) {
		return $this->getHTMLDOMXPath()->query($query);
	}
	
	/**
	 * Returns the page's URL.
	 * 
	 * @return string
	 */
	public function getPageUrl() {
		return $this->url;
	}
}