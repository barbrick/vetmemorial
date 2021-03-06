<?php
	Class Display {
		//------------------------------------------------------------ private variables
  	private $worker;

		//------------------------------------------------------------ constructor method
		public function __construct() {
			// Include object classes
			include('class.worker.php');

			$this->worker = new Worker();
		}

		//------------------------------------------------------------ public methods
		
		/**
    * Function to display news snippts
		*/
		public function getNews() {
	    $postsPerPage = 5;
    	    
	    if(!isset($_GET['page'])) {
  			$page = 1;
  		} else {
  			$page = (int)$_GET['page'];
  		}
    
  		$bottom = (($page * $postsPerPage) - $postsPerPage);
  		$i = 0;
  		$articles = $this->worker->getNews();
  		foreach ($articles As $article) {
		    if ($i >= $bottom && $i < ($bottom + $postsPerPage)) {
		        echo "<div class='newsItem'><h4>" . $article->title . "</h4>";
            echo "<h6>" . date("l F j<\s\up>S</\s\up>, Y", strtotime($article->post_date)) . "</h6>";
            echo $this->truncate(htmlspecialchars_decode($article->content), 500, "...", false, true);
            echo "<p><a class='btn' href='news.php?id=" . $article->id . "'>View details &raquo;</a></p><hr /></div>";
        }
		    $i++; 
  		}
    		
  		echo "<div class='newsItem'><ul id='pagination-freebie'><li><ul class='pagination dark'>";
    	// Count number of posts to determine how many pages are required
    	$totalPages = ceil(count($articles) / $postsPerPage);
            
      if ($totalPages > 1) {
        if ($page > 1) {
    			$prev = ($page - 1);
    			if ($page > 2) {
      			echo "<li class='prev'><a href=\"index.php?page=1\">&lt;&lt;</a></li>";
    			}
  		    echo "<li class='prev'><a href=\"index.php?page=$prev\">Prev</a></li>";
    		}
        			
    		for($i = 1; $i <= $totalPages; $i++) {
  		    if ($page == $i) {
		        echo "<li><a href='#'>$i</a></li>";
  		    } else {
  			    if ($i > ($page - 2) && $i < ($page + 2)) {
			        echo "<li><a href=\"index.php?page=$i\">$i</a></li>";
  			    }
    			}
    		}
        				
    		if ($page < $totalPages) {
  		    $next = ($page + 1);
  		    echo "<li class='next'><a href=\"index.php?page=$next\">Next</a></li>";
  		    if ($page < ($totalPages - 1)) {
		        echo "<li class='next'><a href=\"index.php?page=$totalPages\">&gt;&gt;</a></li>";
    		  }
    		}
    	}
    	echo "</ul></li></ul></div>";
		}
		
		/** 
    * Truncates text.
    *
    * Cuts a string to the length of $length and replaces the last characters
    * with the ending if the text is longer than length.
    *
    * @param string $text String to truncate.
    * @param integer $length Length of returned string, including ellipsis.
    * @param string $ending Ending to be appended to the trimmed string.
    * @param boolean $exact If false, $text will not be cut mid-word
    * @param boolean $considerHtml If true, HTML tags would be handled correctly
    * @return string Trimmed string.
    */
    function truncate($text, $length = 100, $ending = '...', $exact = true, $considerHtml = false) {
      if ($considerHtml) {
      // if the plain text is shorter than the maximum length, return the whole text
      if (strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
        return $text;
      }
    
      // splits all html-tags to scanable lines
      preg_match_all('/(<.+?>)?([^<>]*)/s', $text, $lines, PREG_SET_ORDER);
    
      $total_length = strlen($ending);
      $open_tags = array();
      $truncate = '';
    
      foreach ($lines as $line_matchings) {
        // if there is any html-tag in this line, handle it and add it (uncounted) to the output
        if (!empty($line_matchings[1])) {
          // if it’s an “empty element” with or without xhtml-conform closing slash (f.e.)
          if (preg_match('/^<(\s*.+?\/\s*|\s*(img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param)(\s.+?)?)>$/is', $line_matchings[1])) {
            // do nothing
            // if tag is a closing tag (f.e.)
          } else if (preg_match('/^<\s*\/([^\s]+?)\s*>$/s', $line_matchings[1], $tag_matchings)) {
            // delete tag from $open_tags list
            $pos = array_search($tag_matchings[1], $open_tags);
            if ($pos !== false) {
              unset($open_tags[$pos]);
            }
            // if tag is an opening tag (f.e. )
          } else if (preg_match('/^<\s*([^\s>!]+).*?>$/s', $line_matchings[1], $tag_matchings)) {
            // add tag to the beginning of $open_tags list
            array_unshift($open_tags, strtolower($tag_matchings[1]));
          }
          // add html-tag to $truncate’d text
          $truncate .= $line_matchings[1];
        }
    
        // calculate the length of the plain text part of the line; handle entities as one character
        $content_length = strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', ' ', $line_matchings[2]));
        if ($total_length+$content_length > $length) {
          // the number of characters which are left
          $left = $length - $total_length;
          $entities_length = 0;
          // search for html entities
          if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', $line_matchings[2], $entities, PREG_OFFSET_CAPTURE)) {
            // calculate the real length of all entities in the legal range
            foreach ($entities[0] as $entity) {
              if ($entity[1]+1-$entities_length <= $left) {
                $left--;
                $entities_length += strlen($entity[0]);
              } else {
                // no more characters left
                break;
              }
            }
          }
          $truncate .= substr($line_matchings[2], 0, $left+$entities_length);
          // maximum lenght is reached, so get off the loop
          break;
        } else {
          $truncate .= $line_matchings[2];
          $total_length += $content_length;
        }
    
        // if the maximum length is reached, get off the loop
        if($total_length >= $length) {
          break;
        }
      }
    } else {
      if (strlen($text) <= $length) {
        return $text;
      } else {
        $truncate = substr($text, 0, $length - strlen($ending));
      }
    }
    
    // if the words shouldn't be cut in the middle...
    if (!$exact) {
      // ...search the last occurance of a space...
      $spacepos = strrpos($truncate, ' ');
      if (isset($spacepos)) {
        // ...and cut the text in this position
        $truncate = substr($truncate, 0, $spacepos);
      }
    }
    // add the defined ending to the text
    $truncate .= $ending;
    
    if($considerHtml) {
      // close all unclosed html-tags
      foreach ($open_tags as $tag) {
        $truncate .= '';
      }
    }
    return $truncate;
    }
      
      
    /**
    * Function to get page object
    * @param $id integer page id
    * @return Page object holding page content
    */
    public function getPage($id) {
        return $this->worker->getPage($id);
    }

	}
?>