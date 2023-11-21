<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Services\UserService;
use Kernel\Controller\Controller;

class AdminController extends Controller
{
    /**
     * @return void
     */
    public function index(): void
    {
        $users = UserService::getAllUsers($this->db());
        $this->view('admin/users/list', ['users' => $users], 'Admin Panel');
    }

    /*
     * @param int $id The user ID.
     * @return void
     */
    public function show(int $id): void
    {
        $user = UserService::getUserById($this->db(), $id);

        if (!$user) {
            $this->session()->set('error', 'User not found.');
            $this->redirect('/admin/users/list');
            return;
        }

        $this->view('admin/users/get', ['user' => $user], 'Admin Panel');
    }

    /**
     * @param int $id The user ID.
     * @return void
     */
    public function delete(int $id): void
    {
        $result = UserService::deleteUser($this->db(), $id);

        if ($result) {
            $this->session()->set('success', 'User deleted successfully.');
        } else {
            $this->session()->set('error', 'Failed to delete user.');
        }

        $this->redirect('/admin/users/list');
    }

    /**
     * @param int $id The user ID.
     * @return void
     */
    public function edit(int $id): void
    {
        $user = UserService::getUserById($this->db(), $id);

        if (!$user) {
            $this->session()->set('error', 'User not found.');
            $this->redirect('/admin/users/list');
            return;
        }

        $this->view('admin/users/edit', ['user' => $user], 'Admin Panel');
    }

    /**
     * @param int $id The user ID.
     * @return void
     */
    public function update(int $id): void
    {
        $user = UserService::getUserById($this->db(), $id);

        if (!$user) {
            $this->session()->set('error', 'User not found');
            $this->redirect('/admin/users/list');
            return;
        }

        $name = $this->request()->input('name');
        $email = $this->request()->input('email');
        $password = $this->request()->input('password');

        $validation = $this->request()->validate([
            'name' => ['required', 'max:255', 'min:3'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'min:8']
        ]);

        if (!$validation) {
            foreach ($this->request()->errors() as $field => $errors) {
                $this->session()->set($field, $errors);
            }
            $this->redirect('/admin/users/edit/' . $id);
            return;
        }

        $result = UserService::updateUser($this->db(), [
            'name' => $name,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ], ['id' => $id]);

        if ($result) {
            $this->session()->set('success', 'User updated successfully');
        } else {
            $this->session()->set('error', 'Failed to update user');
        }

        $this->redirect('/admin/users/list');
    }
}
