<?php

use Phinx\Migration\AbstractMigration;

class CreateFilesTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $table = $this->table('files');
        $table->addColumn('description', 'string')
              ->addColumn('filename', 'string')
              ->addColumn('filetype', 'string')
              ->addColumn('filesize', 'string')
              ->addColumn('full_url', 'text')
              ->addColumn('full_url_thumb', 'text', array('null' => true))
              ->addColumn('full_path', 'text')
              ->addColumn('full_path_thumb', 'text', array('null' => true))
              ->addColumn('is_image', 'string', array('default' => 'no'))
              ->addColumn('hosted_by', 'string', array('default' => 'local')) // on future can change to amazon or others
              ->addColumn('user_id', 'integer') // created by this user
              ->addColumn('created_at', 'timestamp', array('null' => true)) // autotimestamps by eloquent
              ->addColumn('updated_at', 'timestamp', array('null' => true)) // autotimestamps by eloquent
              ->addColumn('deleted_at', 'timestamp', array('null' => true)) // eloquent softdeletes
              ->create();
    }
}
