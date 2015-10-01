<?php

namespace App\Network\Session;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use SessionHandlerInterface;
use Cake\Network\Session\DatabaseSession;
use Cake\Log\Log;

class DatabaseSessionExtended extends DatabaseSession
{

    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }

    public function read($id)
    {
        $result = parent::read($id);

        if(session_decode ($result)){
            Log::write('debug', '-- Extracted session data here --');
            Log::write('debug', $_SESSION);
        }
        return $result;
    }

    public function write($id, $data)
    {
        $result = parent::write($id, $data);

        if($result){

            $user_id = $_SESSION['Auth']['User']['id'];
            $record = compact('user_id');

            $record[$this->_table->primaryKey()] = $id;
            $result = $this->_table->save(new Entity($record));

        }
        return (bool)$result;

    }

}
