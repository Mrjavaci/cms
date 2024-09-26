<?php

namespace App\Controllers;

use PDO;
use VirtaraCase\Controller\Controller;

class UserController extends Controller
{
    public function list()
    {
        $stmt = $this->database->getConnection()->prepare('SELECT * FROM users');
        $stmt->execute();

        return $this->view('user-list', ['users' => $stmt->fetchAll(PDO::FETCH_ASSOC)]);
    }

    public function apiList()
    {
        return $this->database->getConnection()->query('SELECT * FROM users')->fetchAll(PDO::FETCH_ASSOC);
    }

    public function show()
    {
        $stmt = $this->database->getConnection()->prepare('SELECT * FROM users WHERE id = :id');

        $stmt->execute(['id' => $this->parameters['id']]);
        if ($stmt->rowCount() === 0) {
            return $this->view('error', ['message' => 'User not found']);
        }

        return $this->view('user', ['user' => $stmt->fetch()]);
    }

    public function store()
    {
        $this->validate([
            'name'    => 'required',
            'surname' => 'required',
            'email'   => 'required|email',
            'phone'   => 'required|numeric',
        ]);

        $stmt = $this->database->getConnection()->prepare('INSERT INTO users (name, surname, email, phone) VALUES (:name, :surname, :email, :phone)');
        $stmt->execute([
            'name'    => $this->parameters['name'],
            'surname' => $this->parameters['surname'],
            'email'   => $this->parameters['email'],
            'phone'   => $this->parameters['phone'],
        ]);

        $this->redirect('/user/'.$this->database->getConnection()->lastInsertId());
    }

    public function notDie()
    {
        return ['message' => 'You are allowed to see this page'];
    }
}