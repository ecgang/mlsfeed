<?php

/**
 *
 * This singleton class is used to filter the content of mls VirtualPages.
 * We use the mlsVirtualPageFactory class to retrieve the
 * proper VirtualPage implementation.
 *
 * @author mls
 */
class mlsVirtualPageDispatcher {
	
	private static $instance;
	
	private $virtualPage = null;
	private $content = null;
	private $excerpt = null;
	private $title = null;
	private $initialized = false;
	private $enqueueResource;
	
	private function __construct() {
		#$this->enqueueResource = mlsEnqueueResource::getInstance();
	}
	
	public static function getInstance() {
		if(!isset(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	private function initialize() {
		global $wp_query;
		$postsCount = $wp_query->post_count;
		$type = get_query_var(mlsConstants::MLS_TYPE_URL_VAR);
		//we only try to initialize, if we are accessing a virtual page
		//which does not have any true posts in the global posts array	
		/*if( !file_exists(get_template_directory().'/page-mls.php') ){
			if( !copy(ADVMLS_DIR_URI.'/page-mls.php', get_template_directory().'/page-mls.php' ) ) {  
				wp_die( __( 'Failed to move template to '.wp_get_theme().' Theme, make sure you have permissions to copy to path '.get_template_directory() ) );
			}
		}

		if( !file_exists(get_template_directory().'/content-mls.php') ){
			if( !copy(ADVMLS_DIR_URI.'/content-mls.php', get_template_directory().'/content-mls.php' ) ) {  
				wp_die( __( 'Failed to move template to '.wp_get_theme().' Theme, make sure you have permissions to copy to path '.get_template_directory() ) );
			}
		}*/
		
		if(!$this->initialized && $postsCount === 0 && !empty($type)) {

			$this->initialized = true;
			$wp_query->is_page = true;
			
			$wp_query->is_singular = true;
			$wp_query->is_home = false;
			$wp_query->is_archive = false;
			$wp_query->is_category = false;
			
			$wp_query->is_single = true; // remove sidebar
			$wp_query->is_posts_page = true;
			$wp_query->posts = $this->postCleanUp(null);
			$wp_query->post_count = 1;
			$wp_query->found_posts = 1;
			$wp_query->is_search = $type == mlsVirtualPageFactory::LISTING_SEARCH_RESULTS ? true : false;
			$this->virtualPage = mlsVirtualPageFactory::getInstance()->getVirtualPage($type);
			$this->virtualPage->getContent();
			$body = $this->virtualPage->getBody();
			$this->content = (string) $body;
			$this->excerpt = (string) $body;
			$this->title = (string) $this->virtualPage->getTitle();
			#$this->enqueueResource->addToHeader($this->virtualPage->getHead());
			#$this->enqueueResource->addToMetaTags($this->virtualPage->getMetaTags());
			//turn off some filters on ihf pages
			$this->removeFilters();
			$this->removeCaching();
	  		#get_template_part('page', 'mls');
	    	#die();
		}
	}

	/**
	 * removes filters that can cause issues on virtual pages
	 */
	private function removeFilters() {
		$tags = array(
			"the_content",
			"the_excerpt"
		);
		$functionNames = array(
			"wpautop",
			"wptexturize",
			"convert_chars"
		);
		foreach($tags as $tag) {
			foreach($functionNames as $functionName) {
				remove_filter($tag, $functionName);
			}
		}
	}
	
	/**
	 * disables caching plugins on virtual pages
	 */
	private function removeCaching() {
		$constants = array(
			"DONOTCACHEPAGE",
			"DONOTCACHEDB",
			"DONOTMINIFY",
			"DONOTCDN",
			"DONOTCACHCEOBJECT"
		);
		foreach($constants as $constant) {
			if(!defined($constant)) {
				define($constant, true);
			}
		}
	}
	
	/**
	 * Cleanup state after filtering. This fixes an issue
	 * where widgets display different loop content, such
	 * as featured posts.
	 */
	private function afterFilter() {
		$this->initialized = false;
	}

	public function advmls_change_document_title_parts ( $title_parts ) {

	    $title_parts['title'] = !empty($this->title) ? $this->title : '' ;
	    $title_parts['site'] = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES ); // When not on home page

	    return $title_parts;

	}

	public function advmls_change_document_meta_parts( $title_parts ) {
		if ($this->virtualPage) {
			
			if( !empty( $metaTags = $this->virtualPage->getMetaTags() ) ){
				echo $metaTags;
			}
			return true;

		}

	    #echo $metaTags;
	    return true;
	}
	
	/**
	 * We identify mls requests based on the query_var
	 * mlsConstants::MLS_TYPE_URL_VAR.
	 * Set the proper title and update the posts array to contain only
	 * a single posts. This will get updated in another action later
	 * during processing. We cannot set the post content here, because
	 * Wordpress does some odd formatting of the post_content, if we
	 * add it here (see the getContent method below, where content is properly set)
	 *
	 * @param $posts
	 */
	public function postCleanUp($posts) {
		$this->initialize();
		if($this->initialized) {
			
			$post = new stdClass();
			$post->post_author = 0;
			$post->post_name = "";
			$post->post_type = "page";
			$post->post_title = $this->title;
			$post->post_date = current_time("mysql");
			$post->post_date_gmt = current_time("mysql", 1);
			$post->post_content = $this->content;
			$post->post_excerpt = $this->excerpt;
			$post->post_status = "publish";
			$post->comment_status = "closed";
			$post->ping_status = "closed";
			$post->post_password = "";
			$post->post_parent = 0;
			$post->post_modified = current_time("mysql");
			$post->post_modified_gmt = current_time("mysql", 1);
			$post->comment_count = 0;
			$post->menu_order = 0;
			$post->post_category = array(1); // the default "Uncategorized"
			$post->ID = -1;
			$posts = array($post);

			add_action( 'wp_head', array($this, 'advmls_change_document_meta_parts'), 5, 1 );
			add_filter( 'document_title_parts', array($this,'advmls_change_document_title_parts'), 20, 1 );

		}
		return $posts;
	}
	
	/**
	 * Sets the page template used for our virtual pages
	 * The page templates are set in Wordpress admin.
	 * 
	 * @param $pageTemplate
	 */
	public function getPageTemplate($pageTemplate) {
		$this->initialize();
		if($this->initialized) {
			$virtualPageTemplate = $this->virtualPage->getPageTemplate();
			if(empty($virtualPageTemplate)) {
				$defaultVirtualPage = mlsVirtualPageFactory::getInstance()->getVirtualPage(mlsVirtualPageFactory::DEFAULT_PAGE);
				$virtualPageTemplate = $defaultVirtualPage->getPageTemplate();
			}
			//If the $virtualPageTemplate is NOT empty, then reset $pageTemplate
			if(!empty($virtualPageTemplate)) {
				$templates = array($virtualPageTemplate);
				//gets the disk location of the template
				$pageTemplate = locate_template($templates); 
			}				
		}
		return $pageTemplate;
	}
	
	/**
	 * For the ihf plugin page, we replace the content, with data retrieved from the mls servers.
	 *
	 * @param $content
	 */
	public function getContent($content) {
		$this->initialize();
		if($this->initialized) {
			$content = $this->content;
		}
		//reset init params
		$this->afterFilter();
		return $content;
	}
	
	/**
	 * For the ihf plugin page, we replace the excerpt, with data retrieved from the mls servers.
	 *
	 * @param $content
	 */
	public function getExcerpt($excerpt) {
		$this->initialize();
		if($this->initialized) {
			$excerpt = $this->excerpt;
		}
		//reset init params
		$this->afterFilter();
		return $excerpt;
	}
	
	/**
	 * If this is a virtual page, clear out any comments
	 */
	public function clearComments($comments) {
		if(get_query_var(mlsConstants::MLS_TYPE_URL_VAR)) {
			$comments = array();
		}
		return $comments;
	}
	
}