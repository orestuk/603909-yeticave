<?php

class Services {

    private $link;
    private $is_auth;

    function __construct() {

        $db = require_once 'config/db.php';

        $this->is_auth = rand(0, 1);

        $this->link = mysqli_connect($db['host'], $db['user'], $db['password'], $db['database']);
        mysqli_set_charset($this->link, "utf8");

        if (!$this->link) {
            redirect_to_error(mysqli_connect_error());
        }
    }

    function get_data($sql)
    {
        $result = mysqli_query($this->link, $sql);

        if ($result) {
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
        else {
            redirect_to_error(mysqli_error($link));
        }
    }

    function get_lots()
    {
        $sql = 'SELECT lt.id, lt.name, lt.price, lt.image_url AS url, ct.name AS category
                FROM lots AS lt
                    INNER JOIN categories AS ct ON ct.id = lt.category_id
                WHERE lt.date_completion > current_date()
                ORDER BY  lt.id DESC
                LIMIT 10;';

        return $this->get_data($sql);
    }

    function get_lot($id)
    {
        $sql = 'SELECT lt.name, lt.description, lt.price, lt.image_url, ct.name as category
                FROM lots AS lt
                    INNER JOIN categories AS ct ON ct.id = lt.category_id
                WHERE lt.id ='.$id.';';

        return $this->get_data($sql);
    }

    function get_categories()
    {
        $sql = 'SELECT * FROM categories;';

        return $this->get_data($sql);
    }
}

