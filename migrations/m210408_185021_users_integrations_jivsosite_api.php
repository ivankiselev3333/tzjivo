<?php

use yii\db\Migration;

/**
 * Class m210408_185021_users_integrations_jivsosite_api
 */
class m210408_185021_users_integrations_jivsosite_api extends Migration
{
    /**
     * {@inheritdoc}
     */

    public function safeUp()
    {

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

        $q = "CREATE TABLE `users_integrations_jivosite_api` (
  `user_id` INT(10) UNSIGNED  NOT NULL, UNIQUE (`user_id`),
  `js` TEXT(65535) NOT NULL COLLATE 'utf8_general_ci',
  INDEX `fk_users` (`user_id`) USING BTREE,
  CONSTRAINT `fk_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;";


        Yii::$app->db->createCommand($q)->execute();
    }

    /**
     * {@inheritdoc}
     */
    public
    function safeDown()
    {
        echo "users_integrations_jivosite_api cannot be reverted.\n";

        return true;
    }


}
