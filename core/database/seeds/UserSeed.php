<?php

use Phinx\Seed\AbstractSeed;

class UserSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $data = array(
            array(
                'name'        => 'Admin',
                'email'       => 'admin@in9web.com',
                'password'    => hash('sha256', 'admin9'),
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            )
        );

        $table = $this->table('users');
        $table->insert($data)
              ->save();
    }
}
