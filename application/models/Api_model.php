<?php
class Api_model extends CI_Model {

    public function getUserByToken($token)
    {
        return $this->db
            ->where('token', $token)
            ->where('expires_at >', date('Y-m-d H:i:s'))
            ->get('api_tokens')
            ->row();
    }

    public function deleteToken($token)
    {
        return $this->db
            ->where('token', $token)
            ->delete('api_tokens');
    }
}