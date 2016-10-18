<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Connection;

/**
 * Class ActivationRepository
 * @package App
 */
class ActivationRepository {

    protected $db;

    protected $table = 'user_activations';

    /**
     * ActivationRepository constructor.
     * @param Connection $db
     */
    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    public function createActivation($user)
    {
        $activation = $this->getActivation($user);
        if (!$activation) {
            return $this->createToken($user);
        }
        return $this->regenerateToken($user);
    }

    /**
     * Update token for user
     * @param $user
     * @return string - token
     */
    public function regenerateToken($user)
    {
        $token = $this->getToken();

        // update token to user
        $this->db->table($this->table)->where('user_id', $user->id)->update([
           'token' => $token,
            'created_at' => new Carbon()
        ]);

        return $token;
    }

    /**
     * Generate token
     * @return string - token
     */
    public function getToken()
    {
        return hash_hmac('sha256', str_random(40), config('app.key'));
    }

    /**
     * Create token and store this in table
     * @param $user
     * @return string - token
     */
    public function createToken($user)
    {
        $token = $this->getToken();

        // store token in table
        $this->db->table($this->table)->insert([
            'user_id' => $user->id,
            'token' => $token,
            'created_at' => new Carbon()
        ]);

        return $token;
    }


    /**
     * Get activation by user
     * @param $user
     * @return $this
     */
    public function getActivation($user)
    {
        return $this->db->table($this->table)->where('user_id', $user->id)->first();
    }

    /**
     * Delete activation by token
     * @param $token
     */
    public function deleteActivation($token)
    {
        $this->db->table($this->table)->where('token', $token)->delete();
    }

    public function getActivationByToken($token)
    {
        return $this->db->table($this->table)->where('token', $token)->first();
    }


}