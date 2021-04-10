<?php

use yii\db\Migration;

/**
 * Class m210409_081047_insert_users
 */
class m210409_081047_insert_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        Yii::$app->db->createCommand()->batchInsert('users', ['id', 'email'], [
            [1, 'test@yandex.ru',],
            [2, 'test2@gmail.com',],
            [3, 'test3@gmail.com',],
        ])->execute();
        Yii::$app->db->createCommand()->batchInsert('users_integrations_jivosite_api', ['user_id', 'js'], [
            [1, 'вставьте код сюда',],
            [2, 'вставьте код сюда',],
            [3, '<script src="//code.jivosite.com/widget/dyQzo0d4Ss" async></script>',],
        ])->execute();

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropTable('users');
        $this->dropTable('users_integrations_jivosite_api');

        return $true;

    }

}
