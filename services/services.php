<?php

class Services {

    private $link;
    public $is_auth;

    public function __construct() {

        $db = require_once 'config/db.php';

        $this->is_auth = rand(0, 1);

        $this->link = mysqli_connect($db['host'], $db['user'], $db['password'], $db['database']);
        mysqli_set_charset($this->link, "utf8");

        if (!$this->link) {
            redirect_to_error(mysqli_connect_error());
        }
    }

    private function get_data($sql)
    {
        $result = mysqli_query($this->link, $sql);

        if ($result) {
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
        else {
            redirect_to_error(mysqli_error($this->link));
        }
    }

    private function db_get_prepare_stmt($sql, $data = []) {
        $stmt = mysqli_prepare($this->link, $sql);

        if ($data) {
            $types = '';
            $stmt_data = [];

            foreach ($data as $value) {
                $type = null;

                if (is_int($value)) {
                    $type = 'i';
                }
                else if (is_string($value)) {
                    $type = 's';
                }
                else if (is_double($value)) {
                    $type = 'd';
                }

                if ($type) {
                    $types .= $type;
                    $stmt_data[] = $value;
                }
            }

            $values = array_merge([$stmt, $types], $stmt_data);

            $func = 'mysqli_stmt_bind_param';
            $func(...$values);
        }

        return $stmt;
    }

    public function get_lots()
    {
        $sql = 'SELECT lt.id, lt.name, lt.price, lt.image_url AS url, ct.name AS category
                FROM lots AS lt
                    INNER JOIN categories AS ct ON ct.id = lt.category_id
                WHERE lt.date_completion > current_date()
                ORDER BY  lt.id DESC
                LIMIT 10;';

        return $this->get_data($sql);
    }

    public function get_lot($id)
    {
        $sql = 'SELECT lt.name, lt.description, lt.price, lt.image_url, ct.name as category
                FROM lots AS lt
                    INNER JOIN categories AS ct ON ct.id = lt.category_id
                WHERE lt.id ='.$id.';';

        return $this->get_data($sql);
    }

    public function get_categories()
    {
        $sql = 'SELECT * FROM categories;';

        return $this->get_data($sql);
    }

    public function add_lot($lot)
    {
        $sql ='INSERT INTO lots(name, description, image_url, price, date_completion, bid_step, owner_id, winner_id, category_id)
	            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);';
	    $stmt = $this->db_get_prepare_stmt($sql, [$lot['lot-name'], $lot['message'], $lot['lot-image'], $lot['lot-rate'], $lot['lot-date'], $lot['lot-step'], 1, 0, $lot['category']]);
        $res = mysqli_stmt_execute($stmt);
        if (!$res) {
            redirect_to_error(mysqli_error($this->link));
        }
        return mysqli_insert_id($this->link);
    }
}

