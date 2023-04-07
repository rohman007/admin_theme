<?php

define('POST_ACTIVE', true);

class Post
{
	public $id = null;
	public $created_date = null;
	public $slug = null;
	public $thumbnail_url = null;
	public $title = null;
	public $content = null;
	public $fields = '';
	public function __construct( $data=array() ) {
		if ( isset( $data['id'] ) ) $this->id = (int) $data['id'];
		if ( isset( $data['created_date'] ) ) $this->created_date = (int) $data['created_date'];
		if ( isset( $data['thumbnail_url'] ) ) $this->thumbnail_url = $data['thumbnail_url'];
		if ( isset( $data['title'] ) ) $this->title = htmlspecialchars($data['title']);
		if ( isset( $data['content'] ) ) $this->content = $data['content'];
		if ( isset( $data['fields']) ) $this->fields = $data['fields'];
		if ( isset( $data['slug'] ) ) $this->slug = htmlspecialchars(strtolower(str_replace(' ', '-', basename($data["slug"]))));
	}

	public function storeFormValues ( $params ) {

		// Store all the parameters
		$this->__construct( $params );

		// Parse and store the publication date
		if ( isset($params['created_date']) ) {
			$created_date = explode ( '-', $params['created_date'] );

			if ( count($created_date) == 3 ) {
				list ( $y, $m, $d ) = $created_date;
				$this->created_date = mktime ( 0, 0, 0, $m, $d, $y );
			}
		}
	}

	public static function getById( $id ) {
		$conn = open_connection();
		$sql = "SELECT *, UNIX_TIMESTAMP(created_date) AS created_date FROM posts WHERE id = :id";
		$st = $conn->prepare( $sql );
		$st->bindValue( ":id", $id, PDO::PARAM_INT );
		$st->execute();
		$row = $st->fetch();
		if ( $row ) return new Post( $row );
	}

	public static function getBySlug( $slug ) {
		$conn = open_connection();
		$sql = "SELECT *, UNIX_TIMESTAMP(created_date) AS created_date FROM posts WHERE slug = :slug LIMIT 1";
		$st = $conn->prepare( $sql );
		$st->bindValue( ":slug", $slug, PDO::PARAM_STR );
		$st->execute();
		$row = $st->fetch();
		if ( $row ) return new Post( $row );
	}

	public static function getList($amount = 1000, $sort = 'id DESC', $page = 0, $count = true)
	{
		$conn = open_connection();
		$sql = "SELECT *, UNIX_TIMESTAMP(created_date) AS created_date FROM posts
			ORDER BY " . $sort . " LIMIT :amount OFFSET :page";

		$st = $conn->prepare($sql);
		$st->bindValue(":amount", $amount, PDO::PARAM_INT);
		$st->bindValue(":page", $page, PDO::PARAM_INT);
		$st->execute();
		$list = array();

		while ( $row = $st->fetch() ) {
			$post = new Post( $row );
			$list[] = $post;
		}
		$totalRows = 0;
		if($count){
			$totalRows = $conn->query('SELECT count(*) FROM posts')->fetchColumn();
		} else {
			$totalRows = count($list);
		}
		$totalPages = 0;
		if (count($list)){
			$totalPages = ceil($totalRows / $amount);
		}
		return (array(
			"results" => $list,
			"totalRows" => $totalRows,
			"totalPages" => $totalPages
		));
	}

	public function get_fields()
	{
		if($this->fields != ''){
			return json_decode($this->fields, true);
		} else {
			return null;
		}
	}

	public function get_field($key)
	{
		if($this->fields != ''){
			$fields = json_decode($this->fields, true);
			if(isset($fields[$key])){
				return $fields[$key];
			} else {
				return null;
			}
		} else {
			return null;
		}
	}

	public function insert() {
		if ( !is_null( $this->id ) ) trigger_error ( "Post::insert(): Attempt to insert an Post object that already has its ID property set (to $this->id).", E_USER_ERROR );

		$conn = open_connection();
		$sql = "INSERT INTO posts ( created_date, title, content, slug, thumbnail_url ) VALUES ( FROM_UNIXTIME(:created_date), :title, :content, :slug, :thumbnail_url )";
		$st = $conn->prepare ( $sql );
		$st->bindValue( ":created_date", $this->created_date, PDO::PARAM_INT );
		$st->bindValue( ":title", $this->title, PDO::PARAM_STR );
		$st->bindValue( ":content", $this->content, PDO::PARAM_STR );
		$st->bindValue( ":slug", $this->slug, PDO::PARAM_STR );
		$st->bindValue( ":thumbnail_url", $this->thumbnail_url, PDO::PARAM_STR );
		$st->execute();
		$this->id = $conn->lastInsertId();
	}

	public function update() {
		if ( is_null( $this->id ) ) trigger_error ( "Post::update(): Attempt to update an Post object that does not have its ID property set.", E_USER_ERROR );
	 
		$conn = open_connection();
		$sql = "UPDATE posts SET title=:title, content=:content, slug=:slug, thumbnail_url=:thumbnail_url, fields=:fields WHERE id = :id";
		$st = $conn->prepare ( $sql );
		$st->bindValue( ":title", $this->title, PDO::PARAM_STR );
		$st->bindValue( ":content", $this->content, PDO::PARAM_STR );
		$st->bindValue( ":slug", $this->slug, PDO::PARAM_STR );
		$st->bindValue( ":id", $this->id, PDO::PARAM_INT );
		$st->bindValue( ":thumbnail_url", $this->thumbnail_url, PDO::PARAM_STR );
		$st->bindValue( ":fields", $this->fields, PDO::PARAM_STR );
		$st->execute();
	}

	public function delete() {
		if ( is_null( $this->id ) ) trigger_error ( "Post::delete(): Attempt to delete an Post object that does not have its ID property set.", E_USER_ERROR );

		$conn = open_connection();
		$st = $conn->prepare ( "DELETE FROM posts WHERE id = :id LIMIT 1" );
		$st->bindValue( ":id", $this->id, PDO::PARAM_INT );
		$st->execute();
	}

}

?>