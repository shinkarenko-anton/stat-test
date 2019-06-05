<?php
/**
 * Created by PhpStorm.
 * User: anton
 * Date: 6/5/2019
 * Time: 12:59 PM
 */

class Stat
{
    /**
     * @var mysqli
     */
    private $db;
    /**
     * @var false|string
     */
    private $datetime;

    /**
     * Stat constructor.
     *
     * @param mysqli $db
     */
    public function __construct(mysqli $db)
    {
        $this->db = $db;
        $this->datetime = date("Y-m-d H:i:s");
    }

    /**
     * Save visitor's statistics
     *
     * @param User $user
     */
    public function saveStat(User $user) {
        //check record wich meets the requirements
        $sql = "SELECT * FROM stat WHERE ip_address = ? AND user_agent = ? AND page_url = ? LIMIT 1";

        if($query = $this->db->prepare($sql)) {
            $query->bind_param('sss', $user->getIp(), $user->getAgent(), $user->getUrl());
            $query->execute();
            $result = $query->get_result();
            if ($result->num_rows) {
                $record = $result->fetch_object();
                $count = $record->views_count + 1;
                //update existing record
                $sql = "UPDATE stat SET view_date = ?, views_count = ? WHERE id = ?";
                if($query = $this->db->prepare($sql)) {
                    $query->bind_param('sii', $this->datetime, $count, $record->id);
                    $query->execute();
                }
            } else {
                $count = 1;
                //add new record
                $sql = "INSERT INTO stat VALUES (?, ?, ?, ?, ?, ?)";
                if($query = $this->db->prepare($sql)) {
                    $id = null;
                    $query->bind_param('issssi', $id, $user->getIp(), $user->getAgent(), $this->datetime, $user->getUrl(), $count);
                    $query->execute();
                }
            }
        }
    }
}
