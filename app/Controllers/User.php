<?php

namespace App\Controllers;

use App\Models\UserModel;

class User extends BaseController
{
    public function login()
    {
        /* $csrf = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        ); */
        //print_r($csrf);
        //die();
        return view('login');
    }

    public function signin()
    {
        $session = session();
        $userModel = new UserModel();
        $identifier = $this->request->getVar('name');
        $password = $this->request->getVar('password');

        $data = $userModel->where('email', $identifier)->orWhere('mobile', $identifier)->first();

        if ($data) {
            $pass = $data['password'];
            $authenticatePassword = password_verify($password, $pass);
            if ($authenticatePassword) {
                $ses_data = [
                    'id' => $data['id'],
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'isLoggedIn' => TRUE
                ];
                $session->set($ses_data);
                return redirect()->to('/user/profile');
            } else {
                $session->setFlashdata('msg', 'Password is incorrect.');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('msg', 'Email does not exist.');
            return redirect()->to('/login');
        }
        return view('login');
    }

    public function signup()
    {
        helper(['form']);
        return view('signup');
    }

    public function registration()
    {
        helper(['form']);
        $rules = [
            'name'          => 'required|min_length[2]|max_length[50]|is_unique[users.name]',
            'email'         => 'required|min_length[4]|max_length[100]|valid_email|is_unique[users.email]',
            'password'      => 'required|min_length[8]|max_length[50]|regex_match[/^(?=.{8,})(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&+=!]).*$/]',
            'mobile'        => 'required|max_length[50]|is_unique[users.mobile]|regex_match[/^(\+\d{1,3}[- ]?)?\d{10}$/]'
        ];

        if ($this->validate($rules)) {
            $userModel = new UserModel();
            $data = [
                'name'     => $this->request->getVar('name'),
                'email'    => $this->request->getVar('email'),
                'mobile'    => $this->request->getVar('mobile'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT)
            ];
            $userModel->save($data);
            return redirect()->to('/dashboard');
        } else {
            $data['validation'] = $this->validator;
            return view('signup', $data);
        }
    }
}
