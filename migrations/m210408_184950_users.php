<?php

use yii\db\Migration;

/**
 * Class m210408_184950_users
 */
class m210408_184950_users extends Migration
{
    /**
     * {@inheritdoc}
     */

    public function Up()
    {
/*
        $q = "CREATE TABLE `users` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(32) NOT NULL COLLATE 'utf8_general_ci',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `email` (`email`) USING BTREE
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;";


        Yii::$app->db->createCommand($q)->execute();
*/
    }

    /**
     * {@inheritdoc}
     */
    public function Down()
    {

        echo ' migration cannot be reverted ';

        return true;
    }


}
