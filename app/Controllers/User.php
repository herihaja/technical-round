<?php

namespace App\Controllers;

use App\Models\UserModel;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class User extends BaseController
{
    /**
     * Render the login form
     */
    public function login()
    {
        return view('login');
    }

    /**
     * This will handle sign in process
     */
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
                return json_encode(["success" => true]);
            } else {
                return json_encode([
                    "success" => false,
                    "errors" => [
                        "password" => "Password is incorrect."
                    ]

                ]);
            }
        } else {
            return json_encode([
                "success" => false,
                "errors" => [
                    "name" => "Email/mobile does not exist."
                ]
            ]);
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
            /** If all validations pass */
            $userModel = new UserModel();
            $data = [
                'name'     => $this->request->getVar('name'),
                'email'    => $this->request->getVar('email'),
                'mobile'    => $this->request->getVar('mobile'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT)
            ];
            $userModel->save($data);
            return json_encode(['success' => true]);
        } else {
            $data['validation'] = $this->validator;
            $response = [
                "success" => false,
                "errors" => $data['validation']->getErrors()
            ];
            return json_encode($response);
        }
    }

    public function saved()
    {
        return "Changes saved successfully.";
    }

    public function forgotpwd()
    {
        return view("forgot-password");
    }

    public function sendotp()
    {
        helper(['form']);
        $userModel = new UserModel();
        $identifier = $this->request->getVar('name');

        $data = $userModel->where('email', $identifier)->orWhere('mobile', $identifier)->first();

        /** Sending mail if identifier was correct */
        if ($data) {
            /** Generate the OTP */
            $otp = mb_substr(md5($data["email"] . time()), 0, 6);

            /** Update password for the current user */
            $data['password'] = password_hash($otp, PASSWORD_DEFAULT);
            $userModel->save($data);

            /** Preparing and sending the mail content */
            $subject = "OTP from technical round app";
            $message = "Here is your OTP: " . $otp;
            $email = "hery.imiary@gmail.com";
            $mail = new PHPMailer(true);
            try {

                $mail->isSMTP();
                $mail->Host         = 'smtp.gmail.com';
                $mail->SMTPAuth     = true;
                $mail->Username     = 'siminddl@gmail.com';
                $mail->Password     = 'yorwxzkidcvmemmh';
                $mail->SMTPSecure   = 'tls';
                $mail->Port         = 587;
                $mail->Subject      = $subject;
                $mail->Body         = $message;
                $mail->setFrom('username@gmail.com', 'From application');

                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );

                $mail->addAddress($data["email"]);
                $mail->isHTML(true);

                if (!$mail->send()) {
                    echo "Something went wrong. Please try again.";
                }
            } catch (Exception $e) {
                echo "Something went wrong. Please try again.";
            }
            return view("reset-password", ["identifier" => $identifier]);
        }
        return view("forgot-password", [
            "errors" => ["name" => "User with (Mobile/Email) not found."],
            "identifier" => $identifier
        ]);
    }

    public function resetpwd()
    {
        helper(['form']);
        $userModel = new UserModel();
        $identifier = $this->request->getVar('name');
        $password = $this->request->getVar('otp');

        $data = $userModel->where('email', $identifier)->orWhere('mobile', $identifier)->first();

        if ($data) {
            $pass = $data['password'];
            /** Check if otp match posted password */
            $authenticatePassword = password_verify($password, $pass);

            if (!$authenticatePassword) {
                $response = [
                    "success" => false,
                    "errors" => ["otp" => "Please enter the OPT sent via mail."]
                ];
                return json_encode($response);
            }

            $rules = [
                'password'      => 'required|min_length[8]|max_length[50]|regex_match[/^(?=.{8,})(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&+=!]).*$/]',
                'password1'     => 'matches[password]'
            ];

            if ($this->validate($rules)) {
                $userModel = new UserModel();
                $data['password'] = password_hash($this->request->getVar('password'), PASSWORD_DEFAULT);
                $userModel->save($data);
                return json_encode(['success' => true]);
            } else {
                $data['validation'] = $this->validator;
                $response = [
                    "success" => false,
                    "errors" => $data['validation']->getErrors()
                ];
                return json_encode($response);
            }
        }
    }
}
