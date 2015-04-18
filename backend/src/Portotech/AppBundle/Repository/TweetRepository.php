<?php

namespace Portotech\AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use PDO;

/**
 * TweetRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TweetRepository extends EntityRepository
{

    public function loadDataFile($file, $visualization) {
        $db = $this->getEntityManager()->getConnection();
        $sql = "LOAD DATA INFILE :file INTO TABLE Tweet FIELDS TERMINATED BY '\t' LINES TERMINATED BY '\r\n' IGNORE 1 LINES (tweet_id, tweet_text, user, retweets, words, creat_at, hashtags, subject, sentiment) SET Visualization_id = :visualization";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':file', $file, PDO::PARAM_STR);
        $stmt->bindParam(':visualization', $visualization, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function loadDataFileIgnoreOn($file, $visualization) {
        $db = $this->getEntityManager()->getConnection();
        $sql = "LOAD DATA INFILE :file IGNORE INTO TABLE Tweet FIELDS TERMINATED BY '\t' LINES TERMINATED BY '\r\n' IGNORE 1 LINES (tweet_id, tweet_text, user, retweets, words, creat_at, hashtags, subject, sentiment) SET Visualization_id = :visualization";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':file', $file, PDO::PARAM_STR);
        $stmt->bindParam(':visualization', $visualization, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function findTweetsByVisualizationId($visualization) {
        return $this->getEntityManager()->getRepository("PortotechAppBundle:Tweet")->findBy(array(
            'visualization' => $visualization
        ));
    }

    public function countTweetsByVisualization($visualization) {
        $query = $this->getEntityManager()->createQuery("SELECT COUNT(t.id) FROM PortotechAppBundle:Tweet t WHERE t.visualization = ?1");
        $query->setParameter(1, $visualization);
        return $query->getSingleScalarResult();
    }

    public function findTweetsTagsByVisualization($visualization){
        $db = $this->getEntityManager()->getConnection();
        $sql = "SELECT words, COUNT(words) AS total
                FROM Tweet
                WHERE Visualization_id = :visualization AND words IS NOT NULL
                GROUP BY words
                ORDER BY total";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':visualization', $visualization, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll();
    }


    public function findTweetsEachFiveMinutesByVisualization($visualization){
        $db = $this->getEntityManager()->getConnection();
        $sql = "SELECT dateByFiveMinutes(creat_at) AS creat_at, quarterByFiveMinutes(creat_at) AS quarter, AVG(sentiment) AS media
                FROM Tweet
                WHERE Visualization_id = :visualization
                GROUP BY MONTH(creat_at), DAY(creat_at), HOUR(creat_at), quarterByFiveMinutes(creat_at)
                ORDER BY creat_at";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':visualization', $visualization, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findTweetsEachTenMinutesByVisualization($visualization){
        $db = $this->getEntityManager()->getConnection();
        $sql = "SELECT dateByTenMinutes(creat_at) AS creat_at, quarterByTenMinutes(creat_at) AS quarter, AVG(sentiment) AS media
                FROM Tweet
                WHERE Visualization_id = :visualization
                GROUP BY MONTH(creat_at), DAY(creat_at), HOUR(creat_at), quarterByTenMinutes(creat_at)
                ORDER BY creat_at";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':visualization', $visualization, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findTweetsEachFifteenMinutesByVisualization($visualization){
        $db = $this->getEntityManager()->getConnection();
        $sql = "SELECT dateByFifteenMinutes(creat_at) AS creat_at, quarterByFifteenMinutes(creat_at) AS quarter, AVG(sentiment) AS media
                FROM Tweet
                WHERE Visualization_id = :visualization
                GROUP BY MONTH(creat_at), DAY(creat_at), HOUR(creat_at), quarterByFifteenMinutes(creat_at)
                ORDER BY creat_at";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':visualization', $visualization, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findTweetsEachThirtyMinutesByVisualization($visualization){
        $db = $this->getEntityManager()->getConnection();
        $sql = "SELECT dateByThirtyMinutes(creat_at) AS creat_at, quarterByThirtyMinutes(creat_at) AS quarter, AVG(sentiment) AS media
                FROM Tweet
                WHERE Visualization_id = :visualization
                GROUP BY MONTH(creat_at), DAY(creat_at), HOUR(creat_at), quarterByThirtyMinutes(creat_at)
                ORDER BY creat_at";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':visualization', $visualization, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll();
    }


}
