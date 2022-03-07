<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateArticlesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => true
            ],
            'salePriceListId' => [
                'type' => 'INT',
                'unsigned' => TRUE
            ],
            'priceListName' => [
                'type' => 'VARCHAR',
                'constraint' => 150
            ],
            'saleArticleNumber' => [
                'type' => 'VARCHAR',
                'constraint' => 50
            ],
            'saleArticleShortName' => [
                'type' => 'VARCHAR',
                'constraint' => 50
            ],
            'saleArticleLongName' => [
                'type' => 'VARCHAR',
                'constraint' => 180
            ],
            'saleArticleExists' => [
                'type' => 'Boolean',
                'default' => TRUE
            ]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('articles');
    }

    public function down()
    {
        $this->forge->dropTable('articles');
    }
}
